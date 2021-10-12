<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';
require_once APPPATH . 'libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class CORE_API_Controller extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth','session']);
	}

	protected function output($data, $message){
		try{
			$token = $this->getBearerToken();
			if(strlen($token) == 0){
				$response = array(
					"status"=> REST_Controller::HTTP_UNAUTHORIZED,
					"message"=> "Bearer Token tidak valid!",
					"data"=> array()
				);
				$this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}else{
				$key = $this->config->item('app_key');
				$user = JWT::decode($token, $key, array('HS256'));
				$response = array(
					"status"=> REST_Controller::HTTP_OK,
					"message"=> $message,
					"data"=> $data
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		} catch (Exception $e) {
			$response = array(
				"status"=> REST_Controller::HTTP_UNAUTHORIZED,
				"message"=> "Bearer Token  tidak valid!",
				"data"=> array()
			);
			$this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
		}
	}

	function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

	function getBearerToken() {
		$headers = $this->getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

}

class API_Controller extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth','session']);
		if (!$this->ion_auth->logged_in()){ redirect('auth/login', 'refresh'); }
	}
	
	public function datatable_post(){
        try {
            $post = $this->input->post(NULL, TRUE);
            $model = base64_decode($post["model"]);
            $this->load->model($model, 'model');
            $response = $this->model->datatable_render($post);
            $this->set_response($response, REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response($e, REST_Controller::HTTP_EXPECTATION_FAILED);
        }
	}
	
	public function datatabledelete_post(){
        try {
			$post = $this->input->post(NULL, TRUE);
			$id = $post["id"];
			$model = base64_decode($post["model"]);
			$this->load->model($model, 'model');
			$response = $this->model->datatable_delete($id);
            $this->set_response($response, REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response($e, REST_Controller::HTTP_EXPECTATION_FAILED);
        }
    }

}

class MY_Controller extends CI_Controller {

	public $data = array();

	protected $module;
    protected $title;
    protected $information;
    protected $resource;
	protected $model;
	protected $script;

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth', 'form_validation', 'template', 'session', 'upload', 'excel']);
		$this->template->set_template('layouts/app');
		if(!auth_mac_address()){ show_404(); }
		if(!$this->ion_auth->logged_in()){ redirect('auth/login', 'refresh'); }
	}

	public function index(){

        $can_view = auth_can("can_view", $this->resource);
		if(!$can_view){  show_404();}
		# Begin Items
		# End Items
        $this->_render_page($this->resource."/list", $this->data);
    }

    public function create(){

        $can_create = auth_can("can_create", $this->resource);
        if(!$can_create){ show_404(); }

        if ($this->input->method() === 'post') {
            $postData = $this->input->post(NULL, TRUE);
            $rules = $this->entity->form_elements($this->form_validation);
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == TRUE) {
				# Begin Action
				# End Action
                $source = $this->entity->get_mapping_source($postData);
				$source = $this->before_insert($source);
                $new_data = $this->entity->save_data($source);
                $id = $new_data->id;
				$this->after_insert($postData, $new_data, $id);
                $this->session->set_flashdata('alert_title', 'Berhasil!');
                $this->session->set_flashdata('alert_icon', 'fa-check');
                $this->session->set_flashdata('alert_type', 'success');
                $this->session->set_flashdata('alert_message', $this->title.' berhasil disimpan!.');
                redirect($this->resource."/detail/".$id);
            }else{
				$entity = (object)  $this->entity->get_mapping_source($postData);
				$entity->id = null;
				# Begin Items
				# End Items
				$this->data["model"] = $entity;
                $this->_render_page($this->resource."/form", $this->data);
            }
        }else{
			$entity = $this->entity->get_source();
			# Begin Items
			# End Items
            $this->data["model"] = $entity;
            $this->_render_page($this->resource."/form", $this->data);
        }
    }

    public function detail($id){

        $can_view = auth_can("can_view", $this->resource);
        if(!$can_view){ show_404(); }

        if(is_null($id)) show_404();

        if(!is_numeric($id)) show_404();

        $entity = $this->entity->find_data($id);
        if(is_null($entity)) show_404();

		# Begin Items
		# End Items
        $this->data["model"] = $entity;
        $this->_render_page($this->resource."/detail", $this->data, $id);
    }

    public function edit($id){

        $can_edit = auth_can("can_edit", $this->resource);
        if(!$can_edit){ show_404(); }

        if(is_null($id)) show_404();

        if(!is_numeric($id)) show_404();

        $entity = $this->entity->find_data($id);
        if(is_null($entity)) show_404();

        if ($this->input->method() === 'post') {
            $postData = $this->input->post(NULL, TRUE);
            $rules = $this->entity->form_elements($this->form_validation, $id);
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == TRUE) {
				# Begin Action
				# End Action
                $source = $this->entity->get_mapping_source($postData);
				$source = $this->before_update($source, $id);
                $new_data = $this->entity->update_data($id, $source);
                $id = $new_data->id;
				$this->after_update($postData, $new_data, $id);
                $this->session->set_flashdata('alert_title', 'Berhasil!');
                $this->session->set_flashdata('alert_icon', 'fa-check');
                $this->session->set_flashdata('alert_type', 'success');
                $this->session->set_flashdata('alert_message', $this->title.' berhasil diupdate!.');
                redirect($this->resource."/detail/".$id);
            }else{
				# Begin Items
				# End Items
                $this->data["model"] = $entity;
                $this->_render_page($this->resource."/form", $this->data, $id);
            }
        }else{
			# Begin Items
			# End Items
            $this->data["model"] = $entity;
            $this->_render_page($this->resource."/form", $this->data, $id);
        }

    }

    public function delete($id){

        $can_delete = auth_can("can_delete", $this->resource);
        if(!$can_delete){ show_404(); }
        
        if(is_null($id)) show_404();
		if(!is_numeric($id)) show_404();
		
		# Begin Action
		# End Action
		
        $this->entity->delete_data($id);
        $this->session->set_flashdata('alert_title', 'Berhasil!');
        $this->session->set_flashdata('alert_icon', 'fa-check');
        $this->session->set_flashdata('alert_type', 'success');
        $this->session->set_flashdata('alert_message', $this->title.' berhasil dihapus!.');
        redirect($this->resource);
	}

	protected function file_upload($file_title, $file_input, $types){
		if (!is_dir(FCPATH . "/uploads")) { @mkdir(FCPATH . "/uploads"); }
		$pathTarget = "uploads/".slugify($file_title);
		if (isset($_FILES[$file_input])){
			if (!is_dir(FCPATH . "/" . $pathTarget . "/")) {
                @mkdir(FCPATH . "/" . $pathTarget . "/");
            }
			$config['upload_path'] = FCPATH . "/" . $pathTarget . "/";
			$config['allowed_types'] = $types;
			$config['overwrite'] = true;
			$config['file_name'] = gen_uuid(4);
			$this->upload->initialize($config);
			$upload = $this->upload->do_upload($file_input);
			if ($upload) {
				return $pathTarget."/".$this->upload->data('file_name');
			}
		}
		return null;
	}
	
	protected function _render_page($view, $data, $id = 0){

        $can_view = auth_can("can_view", $this->resource);
        $can_edit = auth_can("can_edit", $this->resource);
        $can_create = auth_can("can_create", $this->resource);
        $can_delete = auth_can("can_delete", $this->resource);
      
        $data["permission"] = array(
            "can_view"=> $can_view,
            "can_edit"=> $can_edit,
            "can_create"=> $can_create,
            "can_delete"=> $can_delete
        );  

        $meta_permission = '
            <meta name="can_view" content="'.$can_view.'">
            <meta name="can_edit" content="'.$can_edit.'">
            <meta name="can_create" content="'.$can_create.'">
            <meta name="can_delete" content="'.$can_delete.'">
        ';

        $data["index_url"]      = base_url($this->resource);
        $data["create_url"]     = base_url($this->resource."/create");
        $data["edit_url"]       = base_url($this->resource."/edit/".$id);
        $data["delete_url"]     = base_url($this->resource."/delete/".$id);
        $data["detail_url"]     = base_url($this->resource."/detail/".$id);
        $data["information"] 	= $this->information;
		$data["module"] 		= $this->module;
		
		if(!is_null($this->script)){
			$this->template->script = "<script src='".base_url('assets/js/'.$this->script)."?".time()."'></script>";
		}

        $this->template->meta_permission = $meta_permission;
        $this->template->title = $this->title;
        $this->template->content->view($view, $data);
        $this->template->publish();
    }

	protected function after_insert($formData, $data, $id){}

	protected function after_update($formData, $data, $id){}

	protected function before_insert($data){ return $data; }

	protected function before_update($data, $id){ return $data; }

}

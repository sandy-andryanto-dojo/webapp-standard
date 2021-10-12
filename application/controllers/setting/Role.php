<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {

	protected $module       = "Hak Akses";
    protected $title        = "Data Hak Akses";
    protected $information  = "manajemen hak kases";
    protected $resource     = "setting/role";
	protected $model        = "setting/role_model";
	protected $script		= "app.setting.role.js";
    

    public function __construct(){
        parent::__construct();
        $this->load->model($this->model, 'entity');
	}
	
	public function create(){

        $can_create = auth_can("can_create", $this->resource);
        if(!$can_create){ show_404(); }

        if ($this->input->method() === 'post') {
            $postData = $this->input->post(NULL, TRUE);
            $rules = $this->entity->form_elements($this->form_validation);
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == TRUE) {
                $new_data = $this->entity->save_data($postData);
                $id = $new_data->id;
                $this->session->set_flashdata('alert_title', 'Berhasil!');
                $this->session->set_flashdata('alert_icon', 'fa-check');
                $this->session->set_flashdata('alert_type', 'success');
                $this->session->set_flashdata('alert_message', $this->title.' berhasil disimpan!.');
                redirect($this->resource."/detail/".$id);
            }else{
				$entity = (object)  $this->entity->get_mapping_source($postData);
				$entity->id = null;
				$this->data["model"] = $entity;
				$this->data["permissions"] = $this->entity->get_permission();
                $this->_render_page($this->resource."/form", $this->data);
            }
        }else{
            $entity = $this->entity->get_source();
			$this->data["model"] = $entity;
			$this->data["permissions"] = $this->entity->get_permission();
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

		$this->data["model"] = $entity;
		$this->data["permissions"] = $this->entity->get_permission($id);
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
                $new_data = $this->entity->update_data($id, $postData);
                $id = $new_data->id;
                $this->session->set_flashdata('alert_title', 'Berhasil!');
                $this->session->set_flashdata('alert_icon', 'fa-check');
                $this->session->set_flashdata('alert_type', 'success');
                $this->session->set_flashdata('alert_message', $this->title.' berhasil diupdate!.');
                redirect($this->resource."/detail/".$id);
            }else{
				$this->data["model"] = $entity;
				$this->data["permissions"] = $this->entity->get_permission($id);
                $this->_render_page($this->resource."/form", $this->data, $id);
            }
        }else{
			$this->data["model"] = $entity;
			$this->data["permissions"] = $this->entity->get_permission($id);
            $this->_render_page($this->resource."/form", $this->data, $id);
        }

    }

}

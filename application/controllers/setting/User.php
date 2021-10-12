<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	protected $module       = "Pengguna";
    protected $title        = "Data Pengguna";
    protected $information  = "manajemen data pengguna";
    protected $resource     = "setting/user";
	protected $model        = "setting/user_model";
	protected $script		= "app.setting.user.js";
    

    public function __construct(){
        parent::__construct();
		$this->load->model($this->model, 'entity');
	}
	
	public function create(){

        $can_create = auth_can("can_create", $this->resource);
        if(!$can_create){ show_404(); }

		$auth_user = auth_user();
		

		$roles_selected = array();
        if ($this->input->method() === 'post') {
			$postData = $this->input->post(NULL, TRUE);
			
			$this->form_validation->set_rules('username', 'Username', 'min_length[5]|required|is_unique[auth_users.username]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[auth_users.email]');
			$this->form_validation->set_rules('roles[]', 'Hak Akses', 'required');
			$this->form_validation->set_rules('password', 'Password', 'min_length[5]|required');
			
			
			if($this->input->post("phone")){
				$this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[auth_users.phone]');
			}

            if ($this->form_validation->run() == TRUE) {

				$roles = $this->input->post("roles");
                $email = $this->input->post("email");
                $identity = $this->input->post("username");
                $password = $this->input->post("password");

				$addtional = array();
				
				
				if($this->input->post("phone")){
                    $addtional["phone"] = $this->input->post("phone");
				}
				
				

                $addtional["username"] = $this->input->post("username");
				$user_id = $this->ion_auth->register($identity, $password, $email, $addtional, $roles);
				$this->ion_auth->activate($user_id);
				$this->entity->insert_profile($user_id);
				

				$old_values = $postData;
				$new_values = $this->common_model->getrow_by_id("auth_users", $user_id);
				save_audit([
					"event"=> "SAVE",
					"auditable_id"=> $user_id,
					"auditable_type"=> "auth_users",
					"old_values"=> json_encode($old_values),
					"new_values"=> json_encode($new_values),
					"url"=> "setting/user",
				]);	

				
                $this->session->set_flashdata('alert_title', 'Berhasil!');
                $this->session->set_flashdata('alert_icon', 'fa-check');
                $this->session->set_flashdata('alert_type', 'success');
                $this->session->set_flashdata('alert_message', $this->title.' berhasil disimpan!.');
                redirect($this->resource."/detail/".$user_id);
            }else{
				$entity = (object) $this->entity->get_mapping_source($postData);
				$entity->id = null;
				$this->data["model"] = $entity;
				$this->data["roles"] = model_dropdown("view_admin_roles", "id", "name");
				$this->data["roles_selected"] = $roles_selected;
				$this->data["route"] = null;
                $this->_render_page($this->resource."/form", $this->data);
            }
        }else{
            $entity = $this->entity->get_source();
			$this->data["model"] = $entity;
			$this->data["roles_selected"] = $roles_selected;
			$this->data["roles"] = model_dropdown("view_admin_roles", "id", "name");
			$this->data["route"] = null;
            $this->_render_page($this->resource."/form", $this->data);
        }
	}
	
	public function edit($id){

		$auth_user = auth_user();
		
        $can_edit = auth_can("can_edit", $this->resource);
        if(!$can_edit){ show_404(); }

        if(is_null($id)) show_404();

        if(!is_numeric($id)) show_404();

        $entity = $this->entity->find_data($id, "id");
		if(is_null($entity)) show_404();

		$homepage = $this->entity->get_homepage($entity->homepage);
		
		
		
		$roles_selected = array();
		$roles_id = $this->common_model->getlist_by_column("auth_user_roles", "user_id", $id);
		foreach($roles_id as $row){
			$roles_selected[] = $row->role_id;
		}

        if ($this->input->method() === 'post') {
			$postData = $this->input->post(NULL, TRUE);
			
			$this->form_validation->set_rules('username', 'Username', 'min_length[5]|required|edit_unique[auth_users.username.' . $id . ']');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|edit_unique[auth_users.email.' . $id . ']');
            $this->form_validation->set_rules('roles[]', 'Hak Akses', 'required');

			

            if($this->input->post("phone")){
                $this->form_validation->set_rules('phone', 'Phone', 'required|edit_unique[auth_users.phone.' . $id . ']');
            }

            if ($this->form_validation->run() == TRUE) {

				$roles = $this->input->post("roles");
                $email = $this->input->post("email");
                $identity = $this->input->post("username");
                $data = [
                    'email' => $email,
                    'username' => $identity
                ];

                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
				}

				
                $this->ion_auth->remove_from_group('', $id);
				$groupData = $roles;
                if (isset($groupData) && !empty($groupData)) {
                    foreach ($groupData as $grp) {
                        $this->ion_auth->add_to_group($grp, $id);
                    }
                }

                $identity_column = $this->config->item('identity', 'ion_auth');
                if ($identity_column == 'email') { 
                    $data["username"] = $this->input->post("username");
				}
				
				$this->ion_auth->update($id, $data);

				$old_values = $postData;
				$new_values = $this->common_model->getrow_by_id("auth_users", $id);
				save_audit([
					"event"=> "UPDATE",
					"auditable_id"=> $id,
					"auditable_type"=> "auth_users",
					"old_values"=> json_encode($old_values),
					"new_values"=> json_encode($new_values),
					"url"=> "setting/user",
				]);	

				
                $this->session->set_flashdata('alert_title', 'Berhasil!');
                $this->session->set_flashdata('alert_icon', 'fa-check');
                $this->session->set_flashdata('alert_type', 'success');
                $this->session->set_flashdata('alert_message', $this->title.' berhasil disimpan!.');
                redirect($this->resource."/detail/".$id);

            }else{
				$this->data["model"] = $entity;
				$this->data["roles"] = model_dropdown("view_admin_roles", "id", "name");
				$this->data["roles_selected"] = $roles_selected;
				$this->data["route"] = isset($homepage->id) ? $this->common_model->getrow_by_id("auth_routes", $homepage->id) : null;
                $this->_render_page($this->resource."/form", $this->data, $id);
            }
        }else{
			$this->data["model"] = $entity;
			$this->data["roles_selected"] = $roles_selected;
			$this->data["roles"] = model_dropdown("view_admin_roles", "id", "name");
			$this->data["route"] = isset($homepage->id) ? $this->common_model->getrow_by_id("auth_routes", $homepage->id) : null;
            $this->_render_page($this->resource."/form", $this->data, $id);
        }

	}
	
	public function detail($id){

		$auth_user = auth_user();
		

        $can_view = auth_can("can_view", $this->resource);
        if(!$can_view){ show_404(); }

        if(is_null($id)) show_404();

        if(!is_numeric($id)) show_404();

        $entity = $this->entity->find_data($id, "id");
        if(is_null($entity)) show_404();


		$homepage = $this->entity->get_homepage($entity->homepage);

		$this->data["model"] = $entity;
		$this->data["route"] = isset($homepage->id) ? $this->common_model->getrow_by_id("auth_routes", $homepage->id) : null;
        $this->_render_page($this->resource."/detail", $this->data, $id);
    }

}

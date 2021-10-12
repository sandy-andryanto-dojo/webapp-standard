<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $data = array();

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth', 'form_validation', 'template', 'session', 'upload']);
		$this->lang->load('auth');
		$this->template->set_template('layouts/app');
		$this->load->model('account/auth_model');
		if (!$this->ion_auth->logged_in()) {  redirect('auth/login', 'refresh'); }
	}

	public function index(){
		$user_id = auth_user_id();
		$this->data["user"] = $this->auth_model->get_user($user_id);
		$this->data["profile"] = $this->auth_model->get_profile($user_id);
        $this->template->title = "Ubah Profil";
        $this->template->content->view("account/profile", $this->data);
        $this->template->publish();
	}

	public function update(){

		$auth_data = array();
		$id = auth_user_id();
		$this->form_validation->set_rules('username', 'Username', 'min_length[5]|required|edit_unique[auth_users.username.' . $id . ']');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|edit_unique[auth_users.email.' . $id . ']');
		if($this->input->post("phone")){
			$this->form_validation->set_rules('phone', 'Nomor Telepon', 'edit_unique[auth_users.phone.' . $id . ']');
			$auth_data["phone"] = $this->input->post("phone");
		}

		if ($this->form_validation->run() === TRUE) {
			$auth_data["username"] = $this->input->post("username");
			$auth_data["email"] = $this->input->post("email");
			if ($this->ion_auth->update($id, $auth_data)) {	
				$postData = $this->input->post(NULL, TRUE);
				$this->auth_model->update_profile($id, $postData);
				$this->session->set_flashdata('alert_title', 'Update Berhasil!');
				$this->session->set_flashdata('alert_icon', 'fa-check');
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_message', 'Profil anda berhasil diupdate!.');
				$new_value =  $this->auth_model->get_user($id);
				redirect("account/profile");
			}else{
				$this->data["user"] = $this->auth_model->get_user($id);
				$this->data["profile"] = $this->auth_model->get_profile($id);
				$this->template->title = "Ubah Profil";
				$this->template->content->view("account/profile", $this->data);
				$this->template->publish();
			}
		}else{
			$this->data["user"] = $this->auth_model->get_user($id);
			$this->data["profile"] = $this->auth_model->get_profile($id);
			$this->template->title = "Ubah Profil";
			$this->template->content->view("account/profile", $this->data);
			$this->template->publish();
		}

	}

}

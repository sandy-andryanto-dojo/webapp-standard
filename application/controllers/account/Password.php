<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {

	private $data = array();

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth', 'form_validation', 'template', 'session', 'upload']);
		$this->lang->load('auth');
		$this->template->set_template('layouts/app');
		if (!$this->ion_auth->logged_in()) {  redirect('auth/login', 'refresh'); }
	}

	public function index(){
        $this->template->title = "Ubah Password";
        $this->template->content->view("account/password", $this->data);
        $this->template->publish();
	}

	public function update(){
		$old_values = auth_user();
		$id = auth_user_id();
		$this->form_validation->set_rules('old_password', 'Password Lama', 'required');
		$this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password Baru', 'required|matches[new_password]');
		if ($this->form_validation->run() === TRUE) {
			$identity = $this->session->userdata('identity');
			$change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));
			if ($change) {
				//if the password was successfully changed
				$new_data = auth_user();
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				save_audit([
					"event"=> "UPDATE",
					"auditable_id"=> $id,
					"auditable_type"=> "auth_users",
					"old_values"=> json_encode($old_values),
					"new_values"=> json_encode($new_data),
					"url"=> "account/password",
				]);	
				redirect('auth/logout', 'refresh');
			} else {
				$this->session->set_flashdata('alert_title', 'Something Wrong !');
				$this->session->set_flashdata('alert_icon', 'fa-exclamation-triangle');
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_message', $this->ion_auth->errors());
				redirect('account/password', 'refresh');
			}
		}else{
			$this->template->title = "Ubah Password";
			$this->template->content->view("account/password", $this->data);
			$this->template->publish();
		}
	}

}

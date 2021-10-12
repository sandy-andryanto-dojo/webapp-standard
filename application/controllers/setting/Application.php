<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

	private $data = array();

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth', 'form_validation', 'template', 'session', 'upload']);
		$this->lang->load('auth');
		$this->template->set_template('layouts/app');
		$this->load->model("setting/setting_model");
		if(!auth_mac_address()){ show_404(); }
		if (!$this->ion_auth->logged_in()) {  redirect('auth/login', 'refresh'); }
	}

	public function index(){
		$this->data["currencies"] = $this->setting_model->load_currencies();
		$this->data["timezones"] = $this->setting_model->load_timezone();
        $this->template->title = "Pengaturan";
        $this->template->content->view("setting/application/index", $this->data);
        $this->template->publish();
	}

	public function update(){
		$postData = $this->input->post(NULL, TRUE);
		foreach($postData as $row => $key){
			$key_slug = $row;
			$key_value = $key;
			if($this->input->post($row)){
				$this->setting_model->update_value($key_slug, $key_value);
			}
		}
		$this->session->set_flashdata('alert_title', 'Update Berhasil!');
		$this->session->set_flashdata('alert_icon', 'fa-check');
		$this->session->set_flashdata('alert_type', 'success');
		$this->session->set_flashdata('alert_message', 'Pengaturan berhasil diupdate!.');
		redirect('setting/application', 'refresh');
	}

}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth', 'form_validation', 'template', 'session', 'upload']);
		if(!auth_mac_address()){ show_404(); }
		if (!$this->ion_auth->logged_in()) {  redirect('auth/login', 'refresh'); }
	}

	public function index(){
		redirect('dashboard/summary');
	}
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Database_backup extends CI_Controller {

	private $data = array();

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth', 'form_validation', 'template', 'session', 'upload']);
		$this->lang->load('auth');
		$this->template->set_template('layouts/app');
		if(!auth_mac_address()){ show_404(); }
		if (!$this->ion_auth->logged_in()) {  redirect('auth/login', 'refresh'); }
	}

	public function index(){
		
		if (!is_dir(FCPATH . 'sql')) {
			@mkdir(FCPATH . 'sql', '0777', true);
		}

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$prefs = array(     
			'format'      => 'zip',             
			'filename'    => 'backup-'.gen_uuid(4).'.sql'
		);
		$backup =& $this->dbutil->backup($prefs); 
		$db_name = 'db-backup-'. date("Y-m-d-H-i-s") .'.zip';
		$save = FCPATH."sql/".$db_name;
		@write_file($save, $backup); 
		@force_download($db_name, $backup);
	}
	
	public function create(){
		show_404();
	}

	public function edit($id){
		show_404();
	}

	public function detail($id){
		show_404();
	}

	public function delete($id){
		show_404();
	}

}

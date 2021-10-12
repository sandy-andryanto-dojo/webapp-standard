<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Console extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->model("console/database_model", "db_model");
		$this->load->model("console/seed_model", "db_seed_model");
		$this->load->model("console/route_model", "route_model");
        if (!$this->input->is_cli_request()) exit('Only CLI access allowed');
        if (ENVIRONMENT == 'production') exit('Only development allowed');
	}

	public function db_index(){
        echo date_now()." >> Starting indexing at database ".$this->db->database." ...\n";
        $this->db_model->sync_index();
        echo date_now()." >> Finish indexing at database ".$this->db->database." ...\n";
    }

    public function db_schema(){
        if(!is_dir(FCPATH."/sql")){  mkdir(FCPATH."/sql", 0777, true); }
        $folder = FCPATH.'/sql';
        $files = glob($folder . '/*');
        foreach($files as $file){
            if(is_file($file)){ 
                @unlink($file);
            }
        }
        echo exec('mysqldump -u '.$this->db->username.' -p -R --no-data ' . $this->db->database . ' > '.FCPATH.'/sql/db_schema.sql');
	}
	
	public function db_seed(){
        echo date_now()." >> Starting seeded at database ".$this->db->database." ...\n";
        $this->db_seed_model->run();
        echo date_now()." >> Finish seeded at database ".$this->db->database." ...\n";
	}
	
	public function route_update(){
        echo date_now()." >> Starting updating route ".$this->db->database." ...\n";
        $this->route_model->run();
        echo date_now()." >> Finish updating route ".$this->db->database." ...\n";
    }

	
	
}

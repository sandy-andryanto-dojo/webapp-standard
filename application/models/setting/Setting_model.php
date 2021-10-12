<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Setting_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
	}

	public function get_config($slug){
		$this->db->where("key_slug", $slug);
		$this->db->limit(1);
		$result = $this->db->get("auth_configs")->row();
		return is_null($result) ? $slug : $result->key_value;
	}

	public function load_currencies(){
		$json = file_get_contents(FCPATH . "storages/currencies.json");
		return json_decode($json, true);
	}

	public function load_timezone(){
		$json = file_get_contents(FCPATH . "storages/timezones.json");
		return json_decode($json, true);
	}

	public function update_value($slug, $value){

		$this->db->limit(1);
		$this->db->where("key_slug", $slug);
		$config = $this->db->get("auth_configs")->row();


		if(is_null($config)){
			$conf = array(
				"key_slug"=> $slug,
				"key_name"=> $slug,
				"key_value"=> $value,
				"sort"=> 0,
				"category"=> 0,
				"type"=> 0,
			);
			$this->db->insert("auth_configs", $conf);
		}else{
			$this->db->where("key_slug", $slug);
			$this->db->update("auth_configs", ["key_value"=> $value]);
		}

	}
}

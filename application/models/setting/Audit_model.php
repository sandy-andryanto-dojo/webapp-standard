<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Audit_model extends MY_Model{

	protected $datatable_source = "auth_audits";
	protected $table			= "auth_audits";
	protected $resource 		= "setting/audit";


	
	public function datatable_columns(){
		return array(
			"auth_audits.created_at",
			"auth_audits.event",
			"auth_audits.url",
			"auth_audits.ip_address",
			"auth_users.username",
			"auth_personals.image"
		);
	}

	public function datatable_query(){
		$this->db->join("auth_users", "auth_users.id = auth_audits.user_id");
		$this->db->join("auth_personals", "auth_personals.user_id = auth_audits.user_id");
		$this->db->where("auth_audits.id !=", 0);
	}

}

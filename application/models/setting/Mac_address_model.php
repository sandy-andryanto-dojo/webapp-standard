<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Mac_address_model extends MY_Model{

	protected $datatable_source = "view_dt_ref_macaddress";
	protected $table			= "ref_macaddress";
	protected $resource 		= "setting/mac_address";

	public function form_elements($form, $id = null){
		if(is_null($id)){
			$form->set_rules('code', 'Mac Address', 'required|min_length[17]|max_length[17]|is_unique['.$this->table.'.code]');
		}else{
			$form->set_rules('code', 'Mac Address', 'required|min_length[17]|max_length[17]|edit_unique['.$this->table.'.code.' . $id . ']');
		}
		return $form;
	}
	
	public function datatable_columns(){
		return array(
			"id",
			"code",
			"description"
		);
	}

	public function cek_mac_address($input){
		$this->db->limit(1);
		$this->db->where("code", trim($input));
		$this->db->where("active", 1);
		$result = $this->db->get("ref_macaddress")->row();
		return is_null($result) ? false : true;
	}

	

}

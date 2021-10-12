<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Contact_model extends MY_Model{

	protected $datatable_source = "view_dt_ref_contacts";
	protected $table			= "ref_contacts";
	protected $resource 		= "reference/contacts";

	public function form_elements($form, $id = null){
		if(is_null($id)){
			$form->set_rules('name', 'Nama', 'required|is_unique['.$this->table.'.name]');
		}else{
			$form->set_rules('name', 'Nama', 'required|edit_unique['.$this->table.'.name.' . $id . ']');
		}
		return $form;
	}
	
	public function datatable_columns(){
		return array(
			"id",
			"name",
			"phone",
			"email",
		);
	}

	

}

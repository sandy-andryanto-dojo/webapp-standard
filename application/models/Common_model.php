<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Common_model extends CI_Model{

	public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
	}

	public function delete_data($id, $table){
		$this->db->where("id", $id);
		return $this->db->delete($table);
	}

	public function update_data($id, $table, $data){
		$this->db->where("id", $id);
		return $this->db->update($table, $data);
	}

	public function insert_data($table, $data){
		return $this->db->insert($table, $data);
	}

	public function get_data_byid($table, $id){
		$this->db->where("id", $id);
		$this->db->limit(1);
		return $this->db->get($table)->row();
	}
	
	public function getrow_by_id($table, $id){
		$this->db->where("id", $id);
		$this->db->limit(1);
		$data = $this->db->get($table)->row();
		if(is_null($data)){
			$fields = $this->db->query("DESC ".$table)->result();
			$temp = array();
			foreach($fields as $field){
				$temp[$field->Field] = null;
			}
			return (object) $temp;
		}
		return $data;
	}
	
	public function getlist_by_column($table, $column, $value, $count = false){
		$this->db->where($column, $value);
		if($count){
			return $this->db->get($table)->num_rows();
		}else{
			return $this->db->get($table)->result();
		}
		
	}

	public function model_dropdown($table, $pk, $name){
		$this->db->select(" ".$pk." AS id, ".$name." AS name ");
		$this->db->order_by($table.".".$name, "ASC");
		return  $this->db->get($table)->result_array();
	}

	public function my_dropdown($items, $name, $placeholder, $id_selected = null, $multiple = false){
		$option = "<option diasbled>-- ".$placeholder." --</option>";
		if($multiple){
			foreach ($items as $row) {
				$selected = "";
				if (!is_null($id_selected)) {
					foreach ($id_selected as $ids) {
						if ((int)$ids == (int)$row["id"]) {
							$selected = "selected";
						}
					}
					$option .= '<option value="' . $row["id"] . '" ' . $selected . ' >' . $row["name"] . '</option>';
				} else {
					$option .= '<option value="' . $row["id"] . '" ' . $selected . ' >' . $row["name"] . '</option>';
				}
			}
			$id = str_replace("[", null, $name);
			$id = str_replace("]", null, $id);
			return "<select multiple='multiple' name='" . $name . "' id='" . $id . "' class='form-control select2'>" . $option . "</select>";
		}else{
			foreach ($items as $row) {
				$selected = "";
				if(!is_null($id_selected)){
					if($id_selected == $row["id"]){
						$selected = "selected";
					}
				}
				$option .= '<option value="' . $row["id"] . '" ' . $selected . ' >' . $row["name"] . '</option>';
			}
			$id = str_replace("[", null, $name);
			$id = str_replace("]", null, $id);
			return "<select name='" . $name . "' id='" . $id . "' class='form-control select2'>" . $option . "</select>";
		}
	}
	
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model{

	protected $datatable_source	= null;
	protected $table			= null;
	protected $resource			= null;

    public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_data($table, $column, $value){
        $sql = "SELECT * from ".$table." WHERE get_clean_string(".$column.") = get_clean_string('".$value."') LIMIT 1";
        return $this->db->query($sql)->row();
	}
	#Datable Elements

    public function datatable_render(array $data){
		$draw = $data["draw"];
		$totalRecords =  $this->datatable_count();
		$totalDisplayRecords = $this->datatable_record($data, true);
		$aaData = $this->datatable_record($data, false);
		return array(
			"draw"=> $draw,
			"iTotalRecords"=>$totalRecords,
			"iTotalDisplayRecords"=>$totalDisplayRecords,
			"aaData"=>$aaData
		);
	}

	public function datatable_query(){
		$this->db->where($this->datatable_source.".active", 1);
	}

	public function datatable_count(){
		$this->datatable_query();
		return $this->db->get($this->datatable_source)->num_rows();
	}

	public function datatable_delete($id){
		$this->delete_data($id);
		return array(["status"=> true]);
	}

	public function datatable_record(array $request, $count = false){

		$cols = $this->datatable_columns();
		$row = $request["start"];
		$rowperpage = $request["length"];
		$columnIndex = $request["order"][0]["column"];
		$columnSortOrder = $request["order"][0]["dir"];
		$searchValue = $request["search"]["value"];

		$this->datatable_query();

		if(strlen($searchValue) > 0){
			$condition = null;
			for($i = 0; $i < count($cols); $i++){
				if($i == 0){
					$condition .= " LOWER(CAST(".$cols[$i]." as CHAR(50))) LIKE '%" . strtolower($searchValue) . "%' ";
				}else{
					$condition .= " OR LOWER(CAST(".$cols[$i]." as CHAR(50))) LIKE '%" . strtolower($searchValue) . "%' ";
				}
			}
			$where = " (" . $condition . ")";
			$this->db->where($where);
		}
		

		$this->db->order_by(isset($cols[$columnIndex]) ? $cols[$columnIndex] : $this->datatable_source.".id", $columnSortOrder);
		if($count){
			return $this->db->get($this->datatable_source)->num_rows();
		}else{
			$this->db->limit($rowperpage, $row);
			return $this->db->get($this->datatable_source)->result();
		}

	}

	# CRUD Elements

	public function get_mapping_source($data){
		$source = array();
		$sql = "
			SELECT 
				column_name
			FROM 
				information_schema.columns
			WHERE table_schema = '".$this->db->database."'
			AND table_name = '".$this->table."'
			AND column_name NOT IN ('id', 'created_at', 'updated_at', 'active')
		";
		$model = array();
		$result = $this->db->query($sql)->result();
		foreach($result as $row){
			if(isset($data[$row->column_name])){
				$source[$row->column_name] = isset($data[$row->column_name]) ? $data[$row->column_name] : null;
			}
		}
		return $source;
	}

	public function get_source(){
		$sql = "
			SELECT 
				concat(table_schema, '.', table_name) as table_source,
				column_name
			FROM 
				information_schema.columns
			WHERE table_schema = '".$this->db->database."'
			AND table_name = '".$this->table."'
		";
		$model = array();
		$result = $this->db->query($sql)->result();
		foreach($result as $row){
			$model[$row->column_name] = null;
		}
		return (object) $model;
	}

	public function find_data($id, $pk = "id"){
		$this->db->where($this->table.".".$pk, $id);
		$this->db->limit(1);
		return $this->db->get($this->table)->row();
	}

	public function save_data(array $data){
		$data["created_at"] = date_now();
		$data["active"] = 1;
		$this->db->insert($this->table, $data);
		$id = $this->db->insert_id();
		$new_data = $this->find_data($id);

		save_audit([
			"event"=> "SAVE",
			"auditable_id"=> $id,
			"auditable_type"=> $this->table,
			"new_values"=> json_encode($new_data),
			"url"=> $this->resource,
		]);	

		return $new_data;
	}

	public function update_data($id, array $data){
		$old_data = $this->find_data($id);
		$data["updated_at"] = date_now();
		$data["active"] = 1;
		$this->db->where($this->table.".id", $id);
		$this->db->update($this->table, $data);
		$new_data = $this->find_data($id);

		save_audit([
			"event"=> "UPDATE",
			"auditable_id"=> $id,
			"auditable_type"=> $this->table,
			"old_values"=> json_encode($old_data),
			"new_values"=> json_encode($new_data),
			"url"=> $this->resource,
		]);	

		return $new_data;
	}

	public function delete_data($id){

		$data = $this->find_data($id);

		save_audit([
			"event"=> "DELETE",
			"auditable_id"=> $id,
			"auditable_type"=> $this->table,
			"old_values"=> json_encode($data),
			"new_values"=> json_encode($data),
			"url"=> $this->resource,
		]);	

		$this->db->where($this->table.".id", $id);
		return $this->db->update($this->table, ["active"=> 0]);
	}

}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Role_model extends MY_Model{

	protected $datatable_source = "view_dt_auth_roles";
	protected $table			= "auth_roles";
	protected $resource 		= "setting/role";

	public function form_elements($form, $id = null){
		$this->form_validation->set_rules('routes[]', 'Modul Aplikasi', 'required');
        if (is_null($id)) {
            $form->set_rules('name', 'Nama', 'required|is_unique[' . $this->table . '.name]');
        } else {
            $form->set_rules('name', 'Nama', 'required|edit_unique[' . $this->table . '.name.' . $id . ']');
        }
	}
	
	public function datatable_columns(){
		return array(
			"id",
			"name",
		);
	}

	public function get_permission($id = null){
        $this->db->where("auth_permissions.role_id", $id);
        $this->db->join("auth_routes","auth_routes.id = auth_permissions.route_id");
        return $this->db->get("auth_permissions")->result();
	}
	
	public function save_data(array $postData){

		$name = $postData["name"];
		$role_data = array(
			"name"=> strtolower($name),
			"description"=> strtoupper($name),
			"created_at"=> date_now(),
			"updated_at"=> date_now(),
			"active"=> 1
		);
		$this->db->insert("auth_roles", $role_data);
		$role_id = $this->db->insert_id();
		$this->syncRoutes($role_id, $postData);
		$new_data = $this->find_data($role_id);

		save_audit([
			"event"=> "SAVE",
			"auditable_id"=> $role_id,
			"auditable_type"=> $this->table,
			"new_values"=> json_encode($new_data),
			"url"=> $this->resource,
		]);	

		return $new_data;

	}

	public function update_data($id,array $postData){

		$old_data = $this->find_data($id);
		$name = $postData["name"];
		$role_data = array(
			"name"=> strtolower($name),
			"description"=> strtoupper($name),
			"created_at"=> date_now(),
			"updated_at"=> date_now(),
			"active"=> 1
		);
		$this->db->where("id", $id);
		$this->db->update("auth_roles", $role_data);
		$this->syncRoutes($id, $postData);
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

	private function syncRoutes($role_id, array $post){
        $this->db->query("DELETE FROM auth_permissions WHERE role_id = ".$role_id);
        if(count($post) > 0){
            for($i = 0; $i < count($post); $i++){
                if(isset($post['routes'][$i])){
                    $route_id = $post['routes'][$i];
                    $view = isset($post['can_view' . $route_id]) ? 1 : 0;
                    $create = isset($post['can_add' . $route_id]) ? 1 : 0;
                    $edit = isset($post['can_edit' . $route_id]) ? 1 : 0;
                    $delete = isset($post['can_delete' . $route_id]) ? 1 : 0;
                    $this->db->insert("auth_permissions", [
                        "role_id" => $role_id,
                        "route_id" => $route_id,
                        "can_create" => $create,
                        "can_edit" => $edit,
                        "can_view" => $view,
                        "can_delete" => $delete
                    ]);
                }
            }
        }
    }

}

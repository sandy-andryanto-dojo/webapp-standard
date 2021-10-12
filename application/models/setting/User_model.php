<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class User_model extends MY_Model{

	protected $datatable_source = "view_dt_auth_users";
	protected $table			= "auth_users";
	protected $resource 		= "setting/user";
	private   $menu_name;
	
	public function datatable_columns(){
		return array(
			"id",
			"username",
			"email",
			"phone",
			"groups"
		);
	}

	public function get_homepage($url){
		$this->db->where("url", trim($url));
		$this->db->limit(1);
		return $this->db->get("auth_routes")->row();
	}

	public function datatable_query(){
		$user_id = auth_user_id();
		$this->db->where("id !=", $user_id);
	}

	public function insert_profile($user_id){
		$data = array("user_id"=> $user_id);
		$this->db->insert("auth_personals", $data);
	}

	public function find_data($id, $pk = "id"){
		$this->db->where($this->datatable_source.".".$pk, $id);
		$this->db->limit(1);
		return $this->db->get($this->datatable_source)->row();
	}

	public function user_roles($postData){
	
		if(isset($postData["roles"]) && strlen($postData["roles"]) > 0){
			$roles = $postData["roles"];
			$roles_id = explode(",", $roles);
			$route_id = array();
			$this->db->where_in("role_id", $roles_id);
			$permissions = $this->db->get("auth_permissions")->result();
			foreach($permissions as $permission){
				$route_id[] = $permission->route_id;
			}

			$this->db->where_in("id", $route_id);
			$this->db->where("parent_id", null);
			$this->db->order_by("sort", "ASC");
			$routes = $this->db->get("auth_routes")->result();

			$result = array();
			foreach($routes as $row){
				$result[] = $this->get_child($row->id, $route_id);
			}

			$menu_roles = array();
			if(count($result) > 0){
				$result_str = explode(",", end($result));
				foreach($result_str as $str){
					$menu_app = explode("|", $str);
					if(count($menu_app) == 2){
						$menu_roles[] = array(
							"id"=> $menu_app[1],
							"name"=> $menu_app[0],
						);
					}
				}
			}

			return $menu_roles;
		}

		return array();
	}

	private function get_child($parent_id, $route_id){
		$this->db->where("parent_id", $parent_id);
		$this->db->where_in("id", $route_id);
		$routes = $this->db->get("auth_routes")->result();
		if(count($routes) > 0){
			foreach($routes as $route){
				if(!is_null($route->parent_id)){
					$parent = $this->common_model->getrow_by_id("auth_routes", $route->parent_id);
					$this->menu_name .= $parent->name." \\ ".$route->name."|".$route->id.",";
				}else{
					$this->menu_name .= $route->name."|".$route->id.",";
				}
				$this->get_child($route->id, $route_id);
			}
		}
		return $this->menu_name;
	}

}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Route_model extends CI_Model{

	public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
	}
	
	public function run(){
        $this->db->query("TRUNCATE TABLE auth_routes");
        $this->db->query("TRUNCATE TABLE auth_permissions");
        $json = file_get_contents(FCPATH . "seeds/routes.json");
        $routes = json_decode($json, true);
		$i = 1;
        foreach ($routes as $row) {
            $this->createRoutes($row, $i);
            $i++;
        }
        $this->seedPermissions();
	}

	private function createRoutes($row, $sort, $parent_id = null){
        $insertData = array(
            "parent_id" => $parent_id,
            "name" => isset($row["label"]) ? $row["label"] : null,
            "url" => isset($row["url"]) ?  $row["url"] : null,
            "icon" => isset($row["icon"]) ? $row["icon"] : null,
            "sort" => $sort,
        );

		if(!is_null($insertData["url"])){
			if($insertData["url"] != 'javascript:void(0);'){
				$insertData["url"] = "".$insertData["url"];
			}
		}

        $this->db->insert("auth_routes", $insertData);
        $route_id = $this->db->insert_id();
        if (isset($row["childs"])) {
            $childs = $row["childs"];
            if (count($childs) > 0) {
                $i = 1;
                foreach ($childs as $child) {
                    $this->createRoutes($child, $i, $route_id);
                    $i++;
                }
            }
        }
    }
    
    private function seedPermissions(){
        $roles = $this->db->get("auth_roles")->result();
        foreach($roles as $role){
            $routes = $this->db->get("auth_routes")->result();
            foreach($routes as $route){
                 $data = array(
                    "role_id"=> $role->id,
                    "route_id"=> $route->id,
                    "can_view"=> 1,
                    "can_create"=> slugify($role->name) == slugify('admin') ? 1 : 0,
                    "can_edit"=> slugify($role->name) == slugify('admin') ? 1 : 0,
                    "can_delete"=> slugify($role->name) == slugify('admin') ? 1 : 0
                 );
                 $this->db->insert("auth_permissions", $data);
            }
        }
    }
	
}

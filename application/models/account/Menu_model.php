<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model{

	private $menu = null;
	private $route_path;

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function get_menu($id){
        $this->db->where("auth_routes.id", $id);
        $this->db->limit(1);
        return $this->db->get("auth_routes")->row();
    }

    public function auth_user($user_id){
        $this->db->where("auth_users.id", $user_id);
        $this->db->limit(1);
        return $this->db->get("auth_users")->row();
    }

    public function auth_user_menu($user_id){
        $role_id = $this->auth_role_id($user_id);
        $route_id = $this->auth_routes($role_id);
        $parents = $this->auth_user_route($role_id);
        if(count($parents) > 0){
            foreach($parents as $route){
                $this->createMenu($route, $role_id);
            }

        }
        return minify_html($this->menu);
    }   

    private function auth_user_route(array $role_id, $parent_id = null){
        $route_id =  $this->auth_routes($role_id);
        $this->db->where_in("id", $route_id);
        $this->db->where("parent_id", $parent_id);
        $this->db->order_by("parent_id", "ASC");
        $this->db->order_by("sort", "ASC");
        return $this->db->get("auth_routes")->result();
    }

    private function auth_routes(array $role_id){
        $route_id = array();
        $this->db->where_in("auth_permissions.role_id", $role_id);
        $result = $this->db->get("auth_permissions")->result();
        foreach($result as $row){
            if(!in_array($row->route_id, $route_id)){
                $route_id[] = $row->route_id;
            }
        }
        return $route_id;
    }

    private function auth_role_id($user_id){
        $role_id = array();
        $this->db->where("auth_user_roles.user_id", $user_id);
        $result = $this->db->get("auth_user_roles")->result();
        foreach($result as $row){
            if(!in_array($row->role_id, $role_id)){
                $role_id[] = $row->role_id;
            }
        }
        return $role_id;
    }

    private function createMenu($parent, array $role_id){

        $current_route = $this->uri->uri_string();
        $current_route_array = explode("/", $current_route);

        $actions = [
            "create", 
            "edit", 
            "detail"
        ];

        foreach($actions as $row){
            if(in_array($row, $current_route_array)){
                $key = array_search($row, $current_route_array);
                $temp = array_splice($current_route_array, 0, $key);
                $temp = array_values( $temp);
                $current_route = implode("/", $temp);
            }
        }

        $url = strlen($parent->url) == 0 ? "javascript:void(0);" : base_url($parent->url); 
        $icon = is_null($parent->icon) ? "fa fa-arrow-right" : "fa " . $parent->icon;
        $active = $current_route == $parent->url ? 'active' : '';
        $data = $this->auth_user_route($role_id, $parent->id);

		$target = $parent->url == "setting/database_backup" ? "_blank" : "_self";

        if (count($data) > 0) {
			$this->menu .= ' 
				<li class="dropdown treeview" data-id="'.$parent->id.'" data-parent="0" data-menu-name="'.slugify($parent->name).'">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="'.$icon.'"></i> &nbsp; '.$parent->name.' <b class="caret"></b></a>
					<ul class="dropdown-menu">';
				foreach ($data as $row) {
					$this->createMenu($row, $role_id);
				}		
			$this->menu .= '
					</ul>
				</li>
			';
        }else{
            $getRoute = $this->get_menu($parent->id);
			$icon = "fa fa-arrow-right";
			if(!is_null($getRoute->icon)){
				$icon = "fa ".$getRoute->icon;
			}

			$this->menu .= '
				<li class="'.$active.' nav-link" data-id="'.$parent->id.'" data-parent="'.$getRoute->parent_id.'" data-menu-name="'.slugify($parent->name).'">
					<a href="'.$url.'"  target="'.$target.'">
						<i class="'.$icon.'"></i> &nbsp; '.$parent->name.'
					</a>
				</li>
			';
        }
	}
	
	public function get_route($id){
		$route = $this->common_model->getrow_by_id("auth_routes",$id);
		if(!is_null($route->parent_id)){
			$parent = $this->common_model->getrow_by_id("auth_routes", $route->parent_id);
			$str = $parent->name." \\ ".$route->name;
			$this->route_path .= $str;
		}else{
			$this->route_path .= " ".$route->name;
		}
		return $this->route_path;
	}

}

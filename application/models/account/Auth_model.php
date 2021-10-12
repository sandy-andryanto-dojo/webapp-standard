<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Auth_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
	}

	public function auth_last_login($user_id){
		$user = $this->get_user($user_id);
		return date('Y-m-d H:i:s', $user->last_login);
	}

	public function join_date($user_id){
		$user = $this->get_user($user_id);
		return date('d/m/Y', $user->created_on);
	}

	public function get_user($user_id){
		$this->db->where("auth_users.id", $user_id);
		$this->db->limit(1);
		return $this->db->get("auth_users")->row();
	}

	public function get_profile($user_id){
		$this->db->where("auth_personals.user_id", $user_id);
		$this->db->limit(1);
		return $this->db->get("auth_personals")->row();
	}
	
	public function get_user_name($user_id){
		$user = $this->get_user($user_id);
		$personal = $this->get_profile($user_id);
		if(strlen($personal->fullname) > 0){
			return $personal->fullname;
		}else if(strlen($personal->nickname) > 0){
			return $personal->nickname;
		}else if(strlen($user->username) > 0){
			return $user->username;
		}
		return $user->email;
	}

	public function get_user_image($user_id){
		$personal = $this->get_profile($user_id);
		$gender = (int) $personal->gender;
		
		if(strlen($personal->image) > 0){
			if(file_exists(FCPATH."/".$personal->image)){
				return base_url($personal->image);
			}
		}else{
			if($gender == 1){
				return base_url('assets/img/male.png');
			}else if($gender == 2){
				return base_url('assets/img/female.png');
			}
		}

		return base_url('assets/img/user.png');
	}

	private function auth_route_id(array $role_id){
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

	public function auth_user_can($user_id, $resource, $action){
        $role_id = $this->auth_role_id($user_id);
        $route_id = $this->auth_route_id($role_id);
        $this->db->where_in("auth_permissions.role_id", $role_id);
        $this->db->where_in("auth_permissions.route_id", $route_id);
        $this->db->where("auth_routes.url", $resource);
        $this->db->where("auth_permissions.".$action, 1);
        $this->db->join("auth_routes", "auth_routes.id = auth_permissions.route_id");
        $result = $this->db->get("auth_permissions")->num_rows();
        return (int) $result > 0 ? true : false;
	}
	
	public function save_audit(array $data){
		$data["ip_address"] = get_client_ip();
        $data["created_at"] = date_now();
        $data["user_id"] = auth_user_id();
        $data["ip_address"] = get_client_ip();
        $data["user_agent"] = isset($_SERVER['HTTP_USER_AGENT']) ? json_encode($_SERVER['HTTP_USER_AGENT']) : null;
        return $this->db->insert("auth_audits", $data); 
	}

	public function auth_user_roles($id){
		$result = array();
		$role_id = $this->auth_role_id($id);
		$roles = $this->db->where_in("id", $role_id)->get("auth_roles")->result();
		foreach($roles as $role){
			$result[] = strtoupper($role->name);
		}
		return implode(", ", $result);
	}

	public function update_profile($id, $post){
		$data = array(
			"fullname"=> $post["fullname"],
			"nickname"=> $post["nickname"],
			"gender"=> $post["gender"],
			"birth_date"=> $post["birth_date"],
			"birth_place"=> $post["birth_place"],
			"postal_code"=> $post["postal_code"],
			"address"=> $post["address"],
			"about_me"=> $post["about_me"],
			"notes"=> $post["notes"]
		);
		$this->db->where("user_id", $id);
		$this->db->update("auth_personals", $data);
	}

	public function upload_image($result){

		$path = $result["path"];
		$user_id = auth_user_id();
		$profile = $this->get_profile($user_id);
		
		if(strlen($profile->image) > 0){
			if(file_exists(FCPATH."/".$profile->image)){
				@unlink(FCPATH."/".$profile->image);
			}
		}

		$this->db->where("user_id", $user_id);
		$this->db->update("auth_personals", ["image"=> $path]);

		return $result;
	}

	public function user_notification($id){
		$unread = $this->db->where("active", 1)->where("user_id", $id)->where("readed_at", null)->order_by("id", "DESC")->get("auth_notifications")->num_rows();
		$list = $this->db->where("active", 1)->where("user_id", $id)->where("readed_at", null)->limit(5)->order_by("id", "DESC")->get("auth_notifications")->result();
		return array(
			"total_unread"=> $unread,
			"list"=> $list
		);
	}

}

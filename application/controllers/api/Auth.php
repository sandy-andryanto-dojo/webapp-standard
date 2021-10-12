<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';
require_once APPPATH . 'libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class Auth extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->library(['ion_auth','session']);
	}

	public function token_post(){
		$response = array();

		$username = $this->input->post("username");
		$email = $this->input->post("email");
		$password = $this->input->post("password");

		if(!$username || !$username){
			$response = array(
				"status"=> REST_Controller::HTTP_UNAUTHORIZED,
				"message"=> "Silahkan masukan username atau email!",
				"data"=> array()
			);
		}else if(!$password){
			$response = array(
				"status"=> REST_Controller::HTTP_UNAUTHORIZED,
				"message"=> "Silahkan masukan password!",
				"data"=> array()
			);
		}else{
			
			$this->db->limit(1);
			$this->db->where("username", trim($username));
			$this->db->or_where("email", trim($email));
			$user = $this->db->get("auth_users")->row();

			if(!is_null($user)){
				$check = $this->ion_auth->verify_password($password, $user->password, $user->email);
				if(!$check){
					$response = array(
						"status"=> REST_Controller::HTTP_UNAUTHORIZED,
						"message"=> "Kata sandi anda salah, silahkan coba lagi!",
						"data"=> array()
					);
				}else{
					$key = $this->config->item('app_key');
					$jwt = JWT::encode($user, $key);
					$response = array(
						"status"=> REST_Controller::HTTP_OK,
						"message"=> "login berhasil!",
						"data"=> array(
							"csrf-token-name"=> $this->security->get_csrf_token_name(),
							"csrf-token-value"=> $this->security->get_csrf_hash(),
							"token"=> $jwt
						)
					);
				}
			}else{
				$response = array(
					"status"=> REST_Controller::HTTP_UNAUTHORIZED,
					"message"=> "Login gagal, pengguna tidak ditemukan!",
					"data"=> array()
				);
			}

		}

        $this->set_response($response, REST_Controller::HTTP_OK);
	}

}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH . 'vendor/fzaninotto/faker/src/autoload.php';

Class Seed_model extends CI_Model{

	private $faker;

	const DEFAULT_ADMIN_USERNAME = "admin";
    const DEFAULT_ADMIN_EMAIL = "admin@admin.com";
    const DEFAULT_ADMIN_PASSWORD = "secret";

	public function __construct(){
        parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->load->model("console/route_model", "route_model");
		$this->faker = Faker\Factory::create();
		$this->load->library('ion_auth');
	}

	public function app_url($path){
		return "http://127.0.0.1:5000/".$path;
	}

	public function check_data($table){;
		$rows = $this->db->get($table)->num_rows();
		return (int) $rows > 0 ? true : false;
	}

	public function getRandom($table){
		$this->db->limit(1);
		$this->db->where("active", 1);
		$this->db->order_by('RAND()');
		return $this->db->get($table)->row();
	}
	
	public function run(){
		$this->auth_role();
		$this->auth_user();
		$this->auth_config();
		$this->reference();
		$this->route_model->run();
	}

	

	public function reference(){

		$this->db->query("TRUNCATE TABLE ref_contacts");
		

		for($i = 1; $i <= 100; $i++){
			$data = array(
				"name"=> $this->faker->name,
				"phone"=> $this->faker->phoneNumber,
				"email"=> $this->faker->email,
				"website"=> $this->faker->freeEmailDomain,
				"address"=> $this->faker->address,
				"message"=> $this->faker->text,
				"created_at"=> date_now(),
				"updated_at"=> date_now(),
				"active"=> 1
			);
			$this->db->insert("ref_contacts", $data);
		}
	}

	public function auth_config(){

		$this->db->query("TRUNCATE TABLE auth_configs");
		$data = array(
            "currency-code"=> "IDR",
            "timezone"=> "(UTC+07:00) Bangkok, Hanoi, Jakarta",
            "header-invoice"=>"<p>".$this->faker->paragraph(10, true)."</p>",
            "footer-invoice"=>"<p>".$this->faker->paragraph(10, true)."</p>",
            "web-site-name"=> $this->faker->company,
            "mail-driver"=> "smtp",
            "mail-host"=> "smtp.mailtrap.io",
            "mail-port"=> "2525",
            "mail-username"=> "c535da0ec172f9",
            "mail-password"=> "4403a18c50be55",
            "mail-encryption"=> "tls",
            "mail-address"=> "from@example.com",
            "mail-name"=> "Example",
			"web-meta-description"=> $this->faker->text,
			"web-meta-author"=> $this->faker->name,
			"mac-address"=> 2
        );

        foreach($data as $row => $key){
			$conf = array(
				"key_slug"=> $row,
				"key_name"=> $row,
				"key_value"=> $key,
				"sort"=> 0,
				"category"=> 0,
				"type"=> 0,
			);
			$this->db->insert("auth_configs", $conf);
        }
    }
    
    

	public function auth_user(){
		$table = "auth_users";
		$check_data = $this->check_data($table);
		if(!$check_data){
			$admin = $this->db->where("name", trim("admin"))->limit(1)->get("auth_roles")->row();
			$member = $this->db->where("name", trim("members"))->limit(1)->get("auth_roles")->row();
			$this->create_user($admin);
			for($i = 1; $i <=99; $i++){
				$this->create_user($member);
			}
		}
	}

	public function auth_role(){
		$table = "auth_roles";
		$roles = ["Admin", "Members"];
		$check_data = $this->check_data($table);
		if(!$check_data){
			foreach($roles as $role){
				$element = array(
					"name"=> strtolower($role),
					"description"=> strtoupper($role),
					"created_at"=> date_now(),
					"updated_at"=> date_now(),
					"active"=> 1
				);
				$this->db->insert($table, $element);
			}
		}
	}

	

	private function create_user($role){
		
		$email = self::DEFAULT_ADMIN_EMAIL;
		$identity = self::DEFAULT_ADMIN_USERNAME;
		$password = self::DEFAULT_ADMIN_PASSWORD;
		

		if($role->name != 'admin'){
			$email = $this->faker->unique()->safeEmail;
			$identity = $this->faker->unique()->userName;
			$password = self::DEFAULT_ADMIN_PASSWORD;
			
		}
		
		$additional = array(
			'username'=>$identity,
			'phone'=>  $this->faker->phoneNumber,
			'homepage'=> "account/profile",
			
		);

		$user_id = $this->ion_auth->register($identity, $password, $email, $additional, [$role->id]);
		$gender_id = rand(1,2);
		$gender  = $gender_id == 1 ? "male" : "female";

		$personals = array(
			"user_id"=> $user_id,
			"fullname"=> $this->faker->name($gender),
			"nickname"=> $this->faker->firstName($gender),
			"gender"=> $gender_id,
			"birth_date"=> date_now(),
			"postal_code"=> rand(1000,9999),
			"birth_place"=> $this->faker->city,
			"address"=> $this->faker->address,
			"about_me"=> $this->faker->text,
			"notes"=> $this->faker->text
		);

		

		$this->db->insert("auth_personals", $personals);
		$this->ion_auth->activate($user_id);
	}
	
}

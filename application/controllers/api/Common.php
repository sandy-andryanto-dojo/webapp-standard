<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends API_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("account/auth_model");
	}


	public function upload_user_post(){
		try {
			$result = crop_and_upload("uploads/users");
			$response = $this->auth_model->upload_image($result);
			$this->set_response($response, REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response($e, REST_Controller::HTTP_EXPECTATION_FAILED);
        }
	}

}

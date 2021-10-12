<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends MY_Controller {

	protected $module       = "";
    protected $title        = "";
    protected $information  = "";
    protected $resource     = "dashboard/summary";
	protected $model        = "reference/contact_model";
	protected $script		= "app.setting.contact.js";
    

    public function __construct(){
        parent::__construct();
        $this->load->model($this->model, 'entity');
	}

}

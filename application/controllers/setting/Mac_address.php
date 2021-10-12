<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mac_address extends MY_Controller {

	protected $module       = "Mac Address";
    protected $title        = "Data Mac Address";
    protected $information  = "manajemen data mac address";
    protected $resource     = "setting/mac_address";
	protected $model        = "setting/mac_address_model";
	protected $script		= "app.setting.mac_address.js";
    

    public function __construct(){
        parent::__construct();
        $this->load->model($this->model, 'entity');
	}

}

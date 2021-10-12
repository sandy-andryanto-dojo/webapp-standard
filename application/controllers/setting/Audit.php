<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends MY_Controller {

	protected $module       = "Audit Trail";
    protected $title        = "Data Audit Trail";
    protected $information  = "Audit trail";
    protected $resource     = "setting/audit";
	protected $model        = "setting/audit_model";
	protected $script		= "app.setting.audit.js";
    

    public function __construct(){
        parent::__construct();
        $this->load->model($this->model, 'entity');
    }

}

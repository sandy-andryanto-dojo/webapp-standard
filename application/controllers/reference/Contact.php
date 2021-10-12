<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {

	protected $module       = "Kontak";
    protected $title        = "Data Kontak";
    protected $information  = "manajemen data kontak";
    protected $resource     = "reference/contact";
	protected $model        = "reference/contact_model";
	protected $script		= "app.reference.contact.js";
    

    public function __construct(){
        parent::__construct();
        $this->load->model($this->model, 'entity');
	}

}

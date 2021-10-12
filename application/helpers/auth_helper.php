<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('auth_mac_address')) {
    function auth_mac_address(){
		$CI = get_instance();
		$CI->load->model('setting/mac_address_model');
		$MAC = exec('getmac');
		$MAC = strtok($MAC, ' ');
		$input = trim($MAC);
		$check = (int) app_config('mac-address');
		return $check == 1 ? $CI->mac_address_model->cek_mac_address($input) : true;
    }
}




if (!function_exists('auth_last_login')) {
    function auth_last_login(){
		$CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->auth_model->auth_last_login($user_id);
    }
}


if (!function_exists('auth_join_date')) {
    function auth_join_date(){
		$CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->auth_model->join_date($user_id);
    }
}

if (!function_exists('auth_user')) {
    function auth_user(){
		$CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->auth_model->get_user($user_id);
    }
}

if (!function_exists('auth_user_id')) {
    function auth_user_id(){
        $CI = get_instance();
        $CI->load->library('ion_auth');
        return $CI->ion_auth->get_user_id();
    }
}

if (!function_exists('auth_user_name')) {
    function auth_user_name(){
        $CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->auth_model->get_user_name($user_id);
    }
}

if (!function_exists('auth_user_image')) {
    function auth_user_image(){
        $CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->auth_model->get_user_image($user_id);
    }
}

if (!function_exists('auth_user_menu')) {
    function auth_user_menu(){
        $CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/menu_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->menu_model->auth_user_menu($user_id);
    }
}

if (!function_exists('auth_can')) {
    function auth_can($action, $resource){
		$CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
        return $CI->auth_model->auth_user_can($user_id, $resource, $action);
    }
}

if (!function_exists('save_audit')) {
    function save_audit(array $data){
		$CI = get_instance();
		$CI->load->model('account/auth_model');
        return $CI->auth_model->save_audit($data);
    }
}


if (!function_exists('auth_user_roles')) {
    function auth_user_roles(){
        $CI = get_instance();
		$CI->load->library('ion_auth');
		$CI->load->model('account/auth_model');
		$user_id =  $CI->ion_auth->get_user_id();
		return $CI->auth_model->auth_user_roles($user_id);
    }
}

if (!function_exists('table_permission')) {
    function table_permission(){
        $CI = get_instance();
		$CI->load->model('account/table_permission_model');
		return $CI->table_permission_model->generate();
    }
}


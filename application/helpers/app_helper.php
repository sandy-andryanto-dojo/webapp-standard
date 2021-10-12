<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('minify_html')) {
    function minify_html($Html){
        $Search = array(
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/', # Delete multispace (Without \n)
            '/\>\s+\</', # strip whitespaces between tags
            '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
            '/=\s+(\"|\')/'); # strip whitespaces between = "'
  
        $Replace = array(
            "\n",
            "\n",
            " ",
            "",
            " ",
            "><",
            "$1>",
            "=$1");
  
        $Html = preg_replace($Search, $Replace, $Html);
        return $Html;
    }
}


if (!function_exists('date_now')) {
    function date_now(){
        return date("Y-m-d H:i:s");
    }
}

if (!function_exists('app_debug')) {
    function app_debug($data){
        var_dump($data); die();
    }
}

if (!function_exists('clean_string')) {
    function clean_string($val){
        $val = strtolower($val);
        $val = str_replace(" ", null, $val);
        $val = str_replace(".", null, $val);
        $val = str_replace("-", null, $val);
        $val = str_replace("/", null, $val);
        $val = str_replace("\\", null, $val);
        $val = str_replace("_", null, $val);
        $val = str_replace("(", null, $val);
        $val = str_replace(")", null, $val);
        return $val;   
    }
}

if (!function_exists('slugify')) {
    function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}

if (!function_exists('gen_uuid')) {
    function gen_uuid($type = 1)
    {
        $CI = get_instance();
        $CI->load->library("Uniqueid");
        return $CI->uniqueid->generate($type);
    }
}

if (!function_exists('get_client_ip')) {
    function get_client_ip(){
        $ip = "console";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (!function_exists('tmp_to_date')) {
    function tmp_to_date($timestamp)
    {
		$datetimeFormat = 'd M Y H:i:s';
		$date = new \DateTime();
		$date->setTimestamp($timestamp);
		return $date->format($datetimeFormat);
    }
}


if (!function_exists('crop_and_upload')) {
    function crop_and_upload($path){
		require_once APPPATH . '/libraries/CropImage.php';
        $avatarSrc = isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null;
        $avatarData = isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null;
        $avatarFile = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;
        $crop = new CropImage($avatarSrc, $avatarData, $avatarFile);
        $result = $crop->getResult();
        $realImage = $result;
        if (!is_dir(FCPATH . "" . $path)) {
            @mkdir(FCPATH . "" . $path, 0777, true);
        }
        $arr_photo = explode('/', $result);
        $photo = $path . '/' . end($arr_photo);
        $copy = @copy(FCPATH . '' . $result, FCPATH . '' . $photo);
        if ($copy) {
            $realImage = $photo;
            if ($crop->getOriginal()) {
                $original = $crop->getOriginal();
                if (file_exists(FCPATH . '' . $original)) {
                    @unlink(FCPATH . '' . $original);
                }
            }
            @unlink(FCPATH . '' . $result);
        }
        $response = array(
            'state' => 200,
            'message' => $crop->getMsg(),
            'path' => $realImage,
            'result' => site_url($realImage)
        );
        return $response;
    }
}

if (!function_exists('app_config')) {
    function app_config($slug){
        $CI = get_instance();
		$CI->load->model('setting/setting_model');
		return $CI->setting_model->get_config($slug);
    }
}

if (!function_exists('model_dropdown')) {
    function model_dropdown($table, $id, $name){
        $CI = get_instance();
		$CI->load->model('common_model');
		return $CI->common_model->model_dropdown($table, $id, $name);
    }
}

if (!function_exists('my_dropdown')) {
    function my_dropdown($items, $name, $placeholder, $selected, $multiple){
        $CI = get_instance();
		$CI->load->model('common_model');
		return $CI->common_model->my_dropdown($items, $name, $placeholder, $selected, $multiple);
    }
}

if (!function_exists('get_route')) {
    function get_route($id){
        $CI = get_instance();
		$CI->load->model('account/menu_model');
		return $CI->menu_model->get_route($id);
    }
}

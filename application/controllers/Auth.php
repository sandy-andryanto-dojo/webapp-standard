<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends CI_Controller {

    public $data = [];

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->load->library(['ion_auth', 'form_validation','template']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->template->set_template('layouts/auth');
		if(!auth_mac_address()){ show_404(); }
    }

    /**
     * Log the user in
     */
    public function login() {
        $this->data['title'] = $this->lang->line('login_heading');

		// load the BotDetect Captcha library and set its parameter
		$this->load->library('botdetect/BotDetectCaptcha', array(
			'captchaConfig' => 'DefaultCaptcha'
		));

		// captcha code input field is required
		$this->form_validation->set_rules('CaptchaCode', 'Kode Captcha', 'required');

        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === TRUE) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

			 // validate the user-entered Captcha code when the form is submitted
			 $code = $this->input->post('CaptchaCode');
			 $isHuman = $this->botdetectcaptcha->Validate($code);

			 if(!$isHuman){
				$this->session->set_flashdata('message', '<li>Kode captcha salah, silahkan coba lagi.</li>');
                redirect('auth/login', 'refresh'); 
			 }else if ($isHuman && $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
				//redirect them back to the home page
				
				$id = auth_user_id();
				$new_data = auth_user();
				save_audit([
					"event"=> "UPDATE",
					"auditable_id"=> $id,
					"auditable_type"=> "auth_users",
					"new_values"=> json_encode($new_data),
					"url"=> "auth/login",
				]);	
		

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {

            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			// make Captcha Html accessible to View code
			$this->data['captchaHtml'] = $this->botdetectcaptcha->Html();
			$this->data['captchaValidationMessage'] = ($this->session->flashdata('captchaValidationMessage'))? $this->session->flashdata('captchaValidationMessage') : '';


            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
				'class'=> 'form-control',
				'placeholder'=> strtoupper('Username atau Email')
            ];

            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
				'type' => 'password',
				'class'=> 'form-control',
				'placeholder'=> strtoupper('Kata Sandi')
            ];

            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
        }
    }

    /**
     * Log the user out
     */
    public function logout() {

		$id = auth_user_id();
		$new_data = auth_user();
		save_audit([
			"event"=> "UPDATE",
			"auditable_id"=> $id,
			"auditable_type"=> "auth_users",
			"old_values"=> json_encode($new_data),
			"new_values"=> json_encode($new_data),
			"url"=> "auth/logout",
		]);	

        $this->data['title'] = "Logout";

        // log the user out
        $this->ion_auth->logout();

        // redirect them to the login page
        redirect('welcome', 'refresh');
    }

    /**
     * Forgot password
     */
    public function forgot_password() {
        $this->data['title'] = $this->lang->line('forgot_password_heading');

        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }

		$this->load->library('botdetect/BotDetectCaptcha', array(
			'captchaConfig' => 'DefaultCaptcha'
		));

		$this->form_validation->set_rules('CaptchaCode', 'Kode Captcha', 'required');


        if ($this->form_validation->run() === FALSE) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = [
                'name' => 'identity',
				'id' => 'identity',
				'placeholder'=> strtoupper('Alamat Email Aktif'),
				'class'=> "form-control"
            ];

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

			$this->data['captchaHtml'] = $this->botdetectcaptcha->Html();

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
        } else {

			$code = $this->input->post('CaptchaCode');
       		$isHuman = $this->botdetectcaptcha->Validate($code);
			if(!$isHuman){
				$this->session->set_flashdata('message', '<li>Kode captcha salah, silahkan coba lagi.</li>');
                redirect('auth/forgot_password', 'refresh'); 
			}

            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    /**
     * Reset password - final step for forgotten password
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $this->data['title'] = $this->lang->line('reset_password_heading');

        $user = $this->ion_auth->forgotten_password_check(base64_decode($code));

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			$this->load->library('botdetect/BotDetectCaptcha', array(
				'captchaConfig' => 'DefaultCaptcha'
			));

			$this->form_validation->set_rules('CaptchaCode', 'Kode Captcha', 'required');

            if ($this->form_validation->run() === FALSE) {
                // display the form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = [
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
					'class'=> "form-control",
					'placeholder'=> strtoupper( 'Kata Sandi')
                ];
                $this->data['new_password_confirm'] = [
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
					'placeholder'=>  strtoupper('Konfirmasi Kata Sandi'),
					'class'=> "form-control",
                ];
                $this->data['user_id'] = [
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                ];
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;
				$this->data['captchaHtml'] = $this->botdetectcaptcha->Html();

                // render
                $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
            } else {

				$CaptchaCode = $this->input->post('CaptchaCode');
				$isHuman = $this->botdetectcaptcha->Validate($CaptchaCode);


				if(!$isHuman){
					$this->session->set_flashdata('message', '<li>Kode captcha salah, silahkan coba lagi.</li>');
					redirect('auth/reset_password/' . $code, 'refresh');
				}

                $identity = $user->{$this->config->item('identity', 'ion_auth')};

                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($identity);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function activate($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, base64_decode($code));
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth/login", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return [$key => $value, "key_name"=> $key, "key_value"=> $value];
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce() {
		$key = $this->input->post("key_name");
		$key_value = $this->input->post("key_value");
		$csrf = $this->input->post($key);
        if($csrf){
			return true;
		}
		return false;
    }

    /**
     * @param string     $view
     * @param array|null $data
     * @param bool       $returnhtml
     *
     * @return mixed
     */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE) {//I think this makes more sense
		
		if ($this->ion_auth->logged_in()) {
            redirect('welcome', 'refresh');
		}
		
		$viewdata = (empty($data)) ? $this->data : $data;
        $this->template->title = $viewdata['title'];
        $this->template->content->view($view, $viewdata);
        $this->template->publish();
    }

}

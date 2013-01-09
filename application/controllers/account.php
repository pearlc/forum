<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 계정 관련 컨트롤러
 *
 * 로그인/로그아웃/회원가입 등의 컨트롤러
 *
 * @package	Foki
 * @category	Front-controller
 * @author	Drunken Code
 * @link	?
 */

class Account extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->lang->load('tank_auth'); // 이건 나중에 account_lang 과 통합시켜야함
        $this->lang->load('account');
    }
    
    /**
     * Session을 통해 전달받은 메시지를 출력.
     * 전달받은 메시지가 없다면, login 화면으로 이동
     */
    function index()
    {
        if ($message = $this->session->flashdata('message')) {
            
            $data = array(
                'main_content'=>'account/general_message',
                'data'=>array('message'=>$message),
            );
            $this->load->view('template', $data);
        } else {
            redirect('/account/login/');
        }
    }
    
    /**
     * 뷰 테스트 용도 (공개 버전에서는 지워야함)
     */
    function test() {
        $data['main_content'] = 'account/change_password_form';
        $this->load->view('template', $data);
    }
    
    function mypage() {
        $data['main_content'] = 'account/mypage';
        $this->load->view('template', $data);
    }
    
    /**
     * Login user on the site
     *
     * @return void
     */
    function login()
    {
        if ($this->tank_auth->is_logged_in()) {                 // logged in
            redirect('');

        } elseif ($this->tank_auth->is_logged_in(FALSE)) {      // logged in, not activated
            redirect('/account/send_again/');

        } else {
            
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND ($email = $this->input->post('email'))) {
                    $email = $this->security->xss_clean($email);
            } else {
                    $email = '';
            }

            $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
            if ($this->tank_auth->is_max_login_attempts_exceeded($email)) {
                if ($data['use_recaptcha'])
                    $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
                else
                    $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
            }
            $data['errors'] = array();

            if ($this->form_validation->run()) {                // validation ok
                if ($this->tank_auth->login(
                        $this->form_validation->set_value('email'),
                        $this->form_validation->set_value('password'),
                        $this->form_validation->set_value('remember'),
                        $data['login_by_username'],
                        $data['login_by_email'])) {         // success
                    redirect('');

                } else {
                    $errors = $this->tank_auth->get_error_message();
                    if (isset($errors['banned'])) {     // banned user
                        $this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

                    } elseif (isset($errors['not_activated'])) {				// not activated user
                        redirect('/account/send_again/');

                    } else {													// fail
                        foreach ($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
                    }
                }
            }
            $data['show_captcha'] = FALSE;
            if ($this->tank_auth->is_max_login_attempts_exceeded($email)) {
                $data['show_captcha'] = TRUE;
                if ($data['use_recaptcha']) {
                    $data['recaptcha_html'] = $this->_create_recaptcha();
                } else {
                    $data['captcha_html'] = $this->_create_captcha();
                }
            }
            $data['data'] = $data;
            $data['main_content'] = 'account/login_form';
            $this->load->view('template', $data);
        }
    }

    /**
     * Logout user
     *
     * @return void
     */
    function logout()
    {
        $this->tank_auth->logout();

        $this->_show_message($this->lang->line('auth_message_logged_out'));
    }

    
    /**
     * Send activation email again, to the same or new email address
     *
     * @return void
     */
    function send_again()
    {
        if (!$this->tank_auth->is_logged_in(FALSE)) {   // not logged in or activated
            redirect('/account/login/');

        } else {
            
            // 이 부분을 고쳐야함
            
            $user_id = $this->session->userdata('user_id');
            $user = $this->users->get_user_by_id($user_id, FALSE);

            $data = array(
                'user_id' => $user_id,
                'username' => $user->username,
                'email' => $user->email,
                'new_email_key'=>$user->new_email_key,
            );
            $data['site_name']	= $this->config->item('website_name', 'tank_auth');
            $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
            
            $this->_send_email('activate', $data['email'], $data);
            
            
            /* 원래 있던 코드들
            
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

            $data['errors'] = array();

            if ($this->form_validation->run()) {        // validation ok
                if (!is_null($data = $this->tank_auth->change_email($this->form_validation->set_value('email')))) {     // success

                    $data['site_name']	= $this->config->item('website_name', 'tank_auth');
                    $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

                    $this->_send_email('activate', $data['email'], $data);

                    $this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
                }
            }
             * 
             */
            $data['data'] = $data;
            $data['main_content'] = 'account/send_again_form';
            $this->load->view('template', $data);
        }
    }
    
    /**
     * Register user on the site
     *
     * @return void
     */
    function register()
    {

        if ($this->tank_auth->is_logged_in()) {             // logged in
            redirect('');

        } elseif ($this->tank_auth->is_logged_in(FALSE)) {  // logged in, not activated
            redirect('/account/send_again/');

        } elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
            $this->_show_message($this->lang->line('auth_message_registration_disabled'));

        } else {
            $use_username = $this->config->item('use_username', 'tank_auth');
            if ($use_username) {
                $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
            }
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

            $captcha_registration = $this->config->item('captcha_registration', 'tank_auth');
            $use_recaptcha = $this->config->item('use_recaptcha', 'tank_auth');
            if ($captcha_registration) {
                if ($use_recaptcha) {
                    $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
                } else {
                    $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
                }
            }
            $data['errors'] = array();

            $email_activation = $this->config->item('email_activation', 'tank_auth');

            if ($this->form_validation->run()) {								// validation ok
                if (!is_null($data = $this->tank_auth->create_user(
                                $use_username ? $this->form_validation->set_value('username') : '',
                                $this->form_validation->set_value('email'),
                                $this->form_validation->set_value('password'),
                                $email_activation))) {									// success

                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    if ($email_activation) {									// send "activate" email
                        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

                        $this->_send_email('activate', $data['email'], $data);

                        unset($data['password']); // Clear password (just for any case)

                        $this->_show_message($this->lang->line('auth_message_registration_completed_1'));

                    } else {
                        if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

                            $this->_send_email('welcome', $data['email'], $data);
                        }
                        unset($data['password']); // Clear password (just for any case)

                        $this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
                    }
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
                }
            }
            if ($captcha_registration) {
                if ($use_recaptcha) {
                    $data['recaptcha_html'] = $this->_create_recaptcha();
                }
            }
            $data['use_username'] = $use_username;
            $data['captcha_registration'] = $captcha_registration;
            $data['use_recaptcha'] = $use_recaptcha;
            $data['main_content'] = 'account/register_form';
            
            $this->load->view('template', $data);
        }
    }
    
    /**
     * Activate user account.
     * User is verified by user_id and authentication code in the URL.
     * Can be called by clicking on link in mail.
     *
     * @return void
     */
    function activate()
    {
        $user_id = $this->uri->segment(3);
        $new_email_key = $this->uri->segment(4);

        // Activate user
        if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
            $this->tank_auth->logout();
            $this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));

        } else { // fail
            $this->_show_message($this->lang->line('auth_message_activation_failed'));
        }
    }
    
    /**
     * Change user password
     *
     * @return void
     */
    function change_password()
    {
        if (!$this->tank_auth->is_logged_in()) {    // not logged in or not activated
            redirect('/account/login/');

        } else {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

            $data['errors'] = array();

            if ($this->form_validation->run()) {        // validation ok
                if ($this->tank_auth->change_password(
                    $this->form_validation->set_value('old_password'),
                    $this->form_validation->set_value('new_password'))) {	// success
                    $this->_show_message($this->lang->line('auth_message_password_changed'));

                } else {														// fail
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
                }
            }
            $data['data'] = $data;
            $data['main_content'] = 'account/change_password_form';
            $this->load->view('template', $data);
        }
    }
    
    /**
     * Create reCAPTCHA JS and non-JS HTML to verify user as a human
     *
     * @return	string
     */
   function _create_recaptcha()
   {
           $this->load->helper('recaptcha');

           // Add custom theme so we can get only image
           $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

           // Get reCAPTCHA JS and non-JS HTML
           $html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

           return $options.$html;
   }

    /**
     * Show info message
     *
     * @param	string
     * @return	void
     */
    function _show_message($message)
    {
        $this->session->set_flashdata('message', $message);
        
        $data['main_content'] = '/account/';
        
        redirect('account/');
    }
    /**
     * Send email message of given type (activate, forgot_password, etc.)
     *
     * @param	string
     * @param	string
     * @param	array
     * @return	void
     */
   function _send_email($type, $email, $data)
   {
           $this->load->library('email');
           
           $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
           $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
           $this->email->to($email);
           $this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
           $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
           $this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
           $this->email->send();
   }
    
    // 이하 CI_ViewDelegate 메서드
    public function show_sidebar()
    {
        return false;
    }
    
    public function current_sidebar_title()
    {
        return '';
    }
    
    public function javascripts()
    {
        $method_name = $this->uri->segment(2);
        
        $javascripts = array(
            'account.js',
        );
        return $javascripts;
    }
    
    public function csses()
    {
        $method_name = $this->uri->segment(2);
        
        $csses = array(
            'account.css',
        );
        return $csses;
    }
}
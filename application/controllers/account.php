<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
            $this->load->view('account/general_message', array('message' => $message));
        } else {
            redirect('/account/login/');
        }
    }

    public function signup()
    {
        $data = array();
        $data['main_content'] = 'account/signup';
        
        $this->load->view('template', $data);
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
    
    public function create_()
    {
        $email = $this->input->post('email');
        $nickname = $this->input->post('nickname');
        $password = $this->input->post('password');
        
        $data=array();
        
        $data['create_result'] = true;
        $data['nickname'] = $nickname;
        $data['email'] = $email;
        
        $data['main_content'] = 'account/create_success';
        
        $this->load->view('template', $data);
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
        
        redirect('template', $data);
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
        
        $javascripts = array();
        if ($method_name == 'register') {
            $javascripts[] = 'register.js';
        }
        return $javascripts;
    }
    
    public function csses()
    {
        $method_name = $this->uri->segment(2);
        
        $csses = array();
        if ($method_name == 'register') {
            $csses[] = 'register.css';
        }
        return $csses;
    }
}
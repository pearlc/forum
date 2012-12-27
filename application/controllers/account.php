<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

    public function signup()
    {
        $data = array();
        $data['header']['javascript'][] = 'signup.js';
        $data['header']['css'][] = 'signup.css';
        $data['left_bar']['login'] = false;
        
        $this->load->helper('url');
        $this->load->view('account/signup', $data);
    }
    
    public function create()
    {
        $email = $this->input->post('email');
        $nickname = $this->input->post('nickname');
        $password = $this->input->post('password');
        
        $data=array();
        $data['header']['javascript'][] = 'signup.js';
        $data['header']['css'][] = 'signup.css';
        $data['left_bar']['login'] = false;
        
        $data['create_result'] = true;
        $data['nickname'] = $nickname;
        $data['email'] = $email;
        
        $this->load->helper('url');
        $this->load->view('account/create_success', $data);
    }
    
    public function validate_email()
    {
        // 중복체크는 별도의 함수에서 실행
    }
    
    public function validate_password()
    {
        
    }
    
    public function validate_nickname()
    {
        // 중복체크는 별도의 함수에서 실행
    }
    
    
}
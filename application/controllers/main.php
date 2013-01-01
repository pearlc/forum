<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index()
    {
        $data = array();
        $data['main_content'] = 'main/main';
        
        $this->load->view('template', $data);
    }
    
    
    // 이하 CI_ViewDelegate 메서드
    public function show_sidebar() {
        return true;
    }
    
    public function current_sidebar_title() {
        return '';
    }
    
    public function javascripts() {
        return array();
    }
    
    public function csses() {
        return array();
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wiki extends CI_Controller {

    public function index()
    {
        $data = array();
        $data['main_content'] = 'wiki/wiki';
        
        $this->load->view('template', $data);
    }
    
    // 이하 CI_ViewDelegate 메서드
    public function show_sidebar() {
        return true;
    }
    
    public function current_sidebar_title() {
        return 'wiki';
    }
    
    public function javascripts() {
        return array();
    }
    
    public function csses() {
        return array();
    }
}
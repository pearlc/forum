<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller {

    public function index()
    {
        $data = array();
        $data['left_bar']['login'] = false;
        
        $this->load->helper('url');
        $this->load->view('forum/forum', $data);
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Freeboard extends CI_Controller {

    public function index()
    {
        $data = array();
        $data['main_content'] = 'freeboard/freeboard';
        
        // (s) db 접근후 제목만 뿌려보자
        $this->db->order_by('id', 'desc');
        $this->db->limit(10,0);  // 첫번째 파라미터가 limit, 두번째 파라미터가 offset
        $query = $this->db->get('freeboard_articles');
        $data['data']['rows'] = $query->result();
        // (e) db 접근후 제목만 뿌려보자
        
        $this->load->view('template', $data);
    }
    
    public function view($article_id)
    {
        $data = array();
        $data['main_content'] = 'freeboard/view';
        
        $article = $this->db->get_where('freeboard_articles', array('id' => $article_id), 1)->result();
        $data['data']['article'] = $article[0];
        
        $this->load->view('template', $data);
    }
    
    // 이하 CI_ViewDelegate 메서드
    public function show_sidebar() {
        return true;
    }
    
    public function current_sidebar_title() {
        return 'freeboard';
    }
    
    public function javascripts() {
        return array('freeboard');
    }
    
    public function csses() {
        return array('freeboard');
    }
}
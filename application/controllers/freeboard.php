<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Freeboard extends CI_Controller {

    public function index()
    {
        $this->lists();
    }
    
    public function lists($page = 1)
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
    
    public function write()
    {
        // 로그인 되어있지 않다면 lists 화면으로
        // 
        // TODO : 나중에 자바스크립트로 처리
        
        
        
        if ( !$this->tank_auth->is_logged_in() ) {
            redirect('freeboard');
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {      // logged in, not activated
            redirect('/account/send_again/');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('ckeditor', '', 'trim|required|xss_clean');
        
        if ( $this->form_validation->run() ) {
            
            // 데이터 구성하고 insert
            $now = date('Y-m-d H:i:s');
            $data = array(
                'title' => $this->input->post('title'),
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'ip' => $this->input->ip_address(),
                'content' =>  $this->input->post('ckeditor'),
                'created'=> $now,
                'modified' => $now,
            );
            
            $this->db->insert('freeboard_articles', $data);
            $result = $this->db->insert_id();
            // insert 된 id 획득
            
            // 해당 게시글로 redirect
            redirect('freeboard/view/'.$result);
        }
        
        $data = array();
        $data['main_content'] = 'freeboard/write';
        
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
        
        $js = array('freeboard');
        
        if ($this->uri->segment(2) == 'write') {
            $js[] = 'ckeditor/ckeditor';
        }
        
        
        return $js;
    }
    
    public function csses() {
        return array('freeboard');
    }
}
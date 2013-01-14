<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Freeboard extends CI_Controller {

    public function index()
    {
        $this->lists();
    }
    
    public function lists()
    {
        $data = array();
        $data['main_content'] = 'freeboard/freeboard';
        
        // (s) db 접근후 제목만 뿌려보자
        $this->db->order_by('id', 'desc');
        $query = $this->db->get_where('freeboard_articles', array('deleted' => 0), 10, 0);
        $data['data']['rows'] = $query->result();
        // (e) db 접근후 제목만 뿌려보자
        
        $this->load->view('template', $data);
    }
    
    public function view( $article_id = 0 )
    {
        $data = array();
        $data['main_content'] = 'freeboard/view';
        
        $where_set = array(
            'id' => $article_id,
            'deleted' => 0,
        );
        
        $articles = $this->db->get_where('freeboard_articles', $where_set, 1)->result();
        
        // 해당 게시글이 존재하지 않으면 redirect
        if ( count($articles) == 0 ) {
            redirect('freeboard');
        }
        
        $data['data']['article'] = $articles[0];
        
        $this->load->view('template', $data);
    }
    
    /**
     * TODO : 글쓰기 완료 -> back -> 에디터 화면으로 돌아오고 나서 다시 완료 : 이렇게 하면 글이 두개 등록됨. 다른 사이트에서 어떻게 방지하는 지 확인해볼것
     */
    public function write()
    {
        // 로그인 되어있지 않다면 lists 화면으로
        // 
        // TODO : 글쓰기 버튼 눌렀을때, 자바스크립트가 처리하도록 할것
        
        
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
    
    public function edit($article_id = 0)
    {
        if ( $article_id == 0 ) {
            redirect('freeboard');
        }
        
        $where_set = array(
            'id' => $article_id,
            'user_id' => $this->session->userdata('user_id'),
            'deleted' => 0, // 삭제된 게시글은 고려하지 않음 (유저가 삭제한 게시글은 편집도 못함. 즉, 아예 접근이 불가능)
        );
        
        $query = $this->db->get_where('freeboard_articles', $where_set , 1, 0);
        $result = $query->result();
        $title = $result[0]->title;
        $content = $result[0]->content;
        
        // 해당되는 게시글이 없다면 redirect
        if ( count($result) != 1 ) {
            redirect('freeboard');
        }
        
        // form validate
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('ckeditor', '', 'trim|required|xss_clean');
        
        if ( $this->form_validation->run() ) {
            
            // 데이터 구성하고 update
            $now = date('Y-m-d H:i:s');
            $update_data = array(
                'title' => $this->input->post('title'),
                'username' => $this->session->userdata('username'), // username을 설정하는 이유 : 굳이 안해도 되지만 username 수정 기능이 생겼을 경우를 위해
                'ip' => $this->input->ip_address(), // ip가 변경되었을 경우, 덮어씀
                'content' =>  $this->input->post('ckeditor'),
                'modified' => $now,
            );
            
            $where_set = array(
                'id' => $article_id,
            );
            $this->db->update('freeboard_articles', $update_data, $where_set);
            
            // 해당 게시글로 redirect
            redirect('freeboard/view/'.$article_id);
        }
        
        // get요청으로 들어왔거나, form validation 이 실패했을 경우 진입
        $data = array();
        $data['main_content'] = 'freeboard/write';
        $data['title'] = $title;
        $data['content'] = $content;
        
        $this->load->view('template', $data);
    }
    
    /**
     * 게시글 삭제
     * 
     * 이곳에 진입하기 전에 javascript confirm() 으로 확인을 미리 거침
     * 
     * @param type $article_id
     */
    public function delete( $article_id = 0 ) {
        
        // TODO : 이곳에 오기 전에 javascript confirm() 으로 한번 물어볼것
        
        // 로그인이 되어있지 않다면 redirect 
        if ( !$this->tank_auth->is_logged_in() ) {
            redirect('freeboard');
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {      // logged in, not activated
            redirect('/account/send_again/');
        }
        
        // 게시글 select
        $where_set = array(
            'id' => $article_id,
            'user_id' => $this->session->userdata('user_id'),
            'deleted' => 0, // 삭제된 게시글은 고려하지 않음 (유저가 삭제한 게시글은 다시 삭제하도 못함. 즉, 아예 접근이 불가능) - 당연한것
        );
        $result = $this->db->get_where('freeboard_articles', $where_set, 1, 0)->result();
        
        // 이미 지워진 게시글이거나
        // 본인이 작성한 게시글이 아니거나 
        // 게시글이 존재하지 않는다면 redirect
        if ( count($result) != 1) {
            redirect('freeboard');
        }
        
        // 삭제
        $update_data = array(
            'deleted' => 1,
            'delete_code' => 1, // 1 : 작성자 삭제. TODO : 문서화 시킬것
        );
        $this->db->update('freeboard_articles', $update_data, $where_set);
        
        
        // 결과 메시지 출력
        $data = array();
        $data['main_content'] = 'freeboard/deleted';
        
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
        
        if ($this->uri->segment(2) == 'write' ||
            $this->uri->segment(2) == 'edit') {
            $js[] = 'ckeditor/ckeditor';
        }
        
        
        return $js;
    }
    
    public function csses() {
        return array('freeboard');
    }
}
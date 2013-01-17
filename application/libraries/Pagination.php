<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pagination Class
 *
 * 페이징 구현을 위한 클래스
 * 
 * 사용방식 : 컨트롤러에서 페이징을 위한 설정을 하고, 뷰에서는 $this->pagination 을 이용해서 인자를 가져다 쓰는 방식
 * 
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Pagination
 * @author      Drunken Code
 * @link        none
 */

class Pagination
{
    /**
     * Delegation Pattern 으로 구현...? => 그냥 막코딩 하는게 나을수도.. 하지만 어떤식으로든 정리가 필요해 보임;;
     * 
     * 
     * pagination ligrary의 input
     *  - 해당하는 articles 의 개수 : 이게 중요. 컨트롤러에서 넘겨받아야함.
     *  - 현재page : get으로 얻을수 있음. 굳이 안그래도 되지만 이것도 컨트롤러에서 넘겨받는게 좋을듯
     *  - 유지해야하는 k-v 쌍 ( 검색 keyword, 검색 옵션 ). 굳이 안그래도 되지만 이것도 컨트롤러에서 넘겨받는게 좋을듯
     * 
     * pagination library의 output
     *  - 현재 pagination의 첫번째 페이지 : 현재 page 에서 잘 버무리면 나옴
     *  - 현재 pagination의 마지막 페이지 : 현재 page 에서 잘 버무리면 나옴
     *  - 현재 해당하는 articles 들의 마지막 페이지 : 10의 단위로 잘끊어야함
     *  - prefix_query_string : 게시글 링크, 페이지 링크 등으로 넘어갈때 같이 데리고 다녀야 하는 데이터들 검색
     * 
     */
    
    // Pagination의 설정 역할을 하는 변수들
    private $articles_per_page;
    private $pages_in_pagination;
    
    // Controller 에서 입력될 값들
    private $articles_count;
    private $current_page;
    private $attaching_options;
    
    // View 에서 가져다 쓸 값들
    private $leftest_page;
    private $rightest_page;
    private $last_page;
    private $query_string_prefix;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        
        $this->ci->load->config('pagination', true);
        
        // pagination 설정
        $this->set_current_page( $this->ci->input->get('page') );
        
        $search_options = array();
        if ( $this->ci->input->get('so') && $this->ci->input->get('keyword') ) {
            $search_options['so'] = $this->ci->input->get('so');
            $search_options['keyword'] = $this->ci->input->get('keyword');
        }
        $this->attaching_options = $search_options;
        
        // Default로 config에 정의된 값 사용
        $this->articles_per_page = $this->ci->config->item('articles_per_page', 'pagination');
        $this->pages_in_pagination = $this->ci->config->item('pages_in_pagination', 'pagination');
    }
    
    public function set_current_page( $current_page = 1 )
    {
        $current_page = intval($current_page);
        if ( !$current_page || $current_page < 0 ) {
            $current_page = 1;
        }
        
        if ( $this->current_page != $current_page ) {
            $this->current_page = $current_page;
            unset($this->leftest_page);
            unset($this->rightest_page);
            unset($this->last_page);
        }
    }
    
    public function set_articles_per_page( $articles_per_page = 10 )
    {
        $articles_per_page = intval($articles_per_page);
        if ( !$articles_per_page || $articles_per_page < 0 ) {
            $articles_per_page = 10;
        }
        
        if ( $this->articles_per_page != $articles_per_page ) {
            $this->articles_per_page = $articles_per_page;
            unset($this->leftest_page);
            unset($this->rightest_page);
            unset($this->last_page);
        }
    }
    
    public function set_articles_count( $articles_count )
    {
        $articles_count = intval($articles_count);
        if ( $articles_count < 0 ) {
            $articles_count = 0;
        }
        
        if ( $this->articles_count != $articles_count ) {
            $this->articles_count = $articles_count;
            unset($this->leftest_page);
            unset($this->rightest_page);
            unset($this->last_page);
        }
    }
    
    public function set_attaching_options( $attaching_options ) 
    {
        if ( !is_array($attaching_options) ) {
            $attaching_options = array();
        }
        
        if ( $this->attaching_options != $attaching_options ) {
            $this->attaching_options = $attaching_options;
            unset($this->query_string_prefix);
        }
    }
    
    public function get_current_page()
    {
        if ( !isset($this->current_page) ) {
            $current_page = intval($this->ci->input->get('page'));
            if ( !$current_page ) {
                $current_page = 1;
            }
            $this->current_page = $current_page;
        }
        return $this->current_page;
    }
    
    public function get_articles_per_page()
    {
        return $this->articles_per_page;
    }
    
    public function get_leftest_page()
    {
        /**
         * 1 ~ 10 : 1
         * 11 ~ 20 : 11
         * 21 ~ 30 : 21
         * 101 ~ 110 : 101
         */
        
        if ( !isset($this->leftest_page) ) {
            $this->leftest_page = intval( ($this->current_page-1) / $this->pages_in_pagination ) * $this->pages_in_pagination + 1;
        }
        return $this->leftest_page;
    }
    
    public function get_rightest_page()
    {
        if ( !isset($this->rightest_page) ) {
            $rightest_page = intval( ($this->current_page-1) / $this->pages_in_pagination ) * $this->pages_in_pagination + 10;
            $last_page = $this->get_last_page();
            if ( $rightest_page > $last_page ) $rightest_page = $last_page;
        }
        return $rightest_page;
    }
    
    /**
     * 해당하는 articles 들의 가장 마지막 페이지
     */
    public function get_last_page()
    {
        if ( !isset($this->last_page) ) {
            $this->last_page = intval( $this->articles_count / $this->articles_per_page ) + ( $this->articles_count%$this->articles_per_page?1:0 );   // 남는 페이지가 있으면 1을 더함 : 맞나??
        }
        return $this->last_page;
    }
    
    public function get_query_string_prefix()
    {
        if ( !isset($this->query_string_prefix) ) {
            if ( !isset($this->attaching_options ) ) {
                $this->query_string_prefix = '';
            } else {
                $this->query_string_prefix = http_build_query( $this->attaching_options );
            }
        }
        return $this->query_string_prefix;
    }
}

?>

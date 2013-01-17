<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 검색 관련 컨트롤러
 * 
 * 통합검색시 사용되는 CI_Controller 이면서 다른 CI_Controller 에 대한 API 도 제공한다
 */

class Search extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function search() {
        return 'This is search()';
    }
}

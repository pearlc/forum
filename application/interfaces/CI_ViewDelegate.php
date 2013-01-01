<?php
/**
 * 사용하지 않는 interface.
 * 이걸 사용하기 위해서는 CI 에서 CI_Controller를 상속받는 controller에 
 * interface를 구현해야하는데, core 부분을 건드려야 해서 그냥 구현하지 않기로 함.
 * 
 * 문서화를 위해 이 코드는 남겨둠.
 */
 
// ------------------------------------------------------------------------

 /**
  * 뷰에서 컨트롤러에 호출하는 메서드들 (Delegate Pattern)
  * 
  * @author Drunken Code <drunkncode@gmail.com>
  */
interface CI_ViewDelegate
{
    /**
     * 현재 뷰에서 sidebar 를 보여줄지 여부
     *
     * @access	public
     * @return	bool
     */
    public function show_sidebar();
    
    /**
     * sidebar 에서 현재 가리킬 항목
     * 
     * @access public
     * @return string
     */
    public function current_sidebar_title();
    
    /**
     * 뷰 헤더에서 포함시킬 javascript
     * 
     * @access public
     * @return assoc array
     */
    public function javascripts();
    
    /**
     * 뷰 헤더에서 포함시킬 css
     * 
     * @access public
     * @return assoc array
     */
    public function csses();
}
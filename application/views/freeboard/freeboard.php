<!-- (s) freeboard -->

<?php

/***
 * 로직이 들어가는 부분들
 * 1. 댓글 개수 판단해서 '[', ']'  노출할지 결정
 * 2. 댓글 개수가 특정수를 넘어가면 진하게 또는 다른색으로 변경 <- css class 를 할당하는 식으로 구현해야함
 * 3. date 노출 형식 
 *      같은날이면 08:12
 *      다른날이면 12/01/23
 */

?>


<div class="bbs_header">
    <h4><a href="freeboard/"><?=$this->lang->line('common_label_freeboard');?></a></h4>
</div>

<table id="bbs_articles" border="1">
    <colgroup>
    <col width="57">
    <col>
    <col width="82">
    <col width="150">
    <col width="88">
    </colgroup>
    <thead>
        <tr>
            <th>no</th>
            <th>title</th>
            <th>name</th>
            <th>date</th>
            <th>hit</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ( count($rows) ) foreach($rows as $row) {
        ?>
        <tr>
            <td><?=$row->id?></td>
            <td class="title">
                <a href="freeboard/view/<?=$row->id?>"><?=$row->title?></a>
                <span class="comments_count">
                    <?= ($row->comments_count==0)?"":'['.$row->comments_count.']';?>
                </span>
            </td>
            <td><?=$row->username?></td><!-- TODO : javascript 링크 붙이기 -->
            <td><?=$row->modified?></td> <!-- TODO : 적절한 date foramt 으로 바꿔야함 -->
            <td><?=$row->hit?></td>
        </tr>
        <?
    }
    ?>   
    </tbody>
</table>

<?php
if ( count($rows)==0 ) {
    ?>
    <div class="bbs_message">
        게시글이 없습니다
    </div>
<?
}
?>


<div class="bbs_menu">
    <div class="view_articles"><a href="freeboard">목록</a></div>
    <div class="write_article"><a href="freeboard/write">글쓰기</a></div>
</div>

<div class="">
    <div class="pagination pagination-small pagination-centered">
        <ul>
            <?php
            /**
             * Delegation Pattern 으로 구현...? => 그냥 막코딩 하는게 나을수도.. 하지만 어떤식으로든 정리가 필요해 보임;;
             * 
             * 필요한것
             * 
             * 현재page : get으로 얻을수 있음
             * 해당하는 articles 의 개수 : 이게 중요. 컨트롤러에서 넘겨받아야함.
             * 현재 pagination의 첫번째 페이지 : 현재 page 에서 잘 버무리면 나옴
             * 현재 pagination의 마지막 페이지 : 현재 page 에서 잘 버무리면 나옴
             * 현재 해당하는 articles 의 마지막 페이지 : 10의 단위로 잘끊어야함
             * 
             * 검색 keyword
             * 검색 옵션
             * 
             * 
             * 
             * array(
             *  'articles_count',
             *  'end_page',
             *  'keyword',
             *  'options',
             * );
             * 
             * 
             * 
             * http_build_query() 함수 사용하면 보기 좋을듯
             * 
             */
            
            // 이것들은 controller로부터 넘겨받은 값 또는 상수.
            // articles_per_page 는 게시판 성격마다 달라질수도 있기때문에 delegation pattern 으로 뽑아내는것도 괜찮을듯
            $articles_count = 31;
            $articles_per_page = 10;
            $pages_in_pagination = 10;
            
            
            
            $page = $this->input->get('page');
            if ( !$page ) {
                $page = 1;
            }
            $leftest_page = intval($page / $pages_in_pagination) + 1;
            $rightest_page = intval($page / $pages_in_pagination) + 10;
            $last_page = intval( $articles_count / $articles_per_page ) + ($articles_count%$articles_per_page?1:0);   // 남는 페이지가 있으면 1을 더함 : 맞나??
            if ($rightest_page > $last_page) $rightest_page = $last_page;
            
            $query_string = '';
            $keyword = $this->input->get('keyword');
            $so = $this->input->get('so');
            if ( $keyword ) {
                $query_string .= 'keyword='.$keyword;
                $query_string .= '&so='.$so;
                $query_string .= '&';
            }
            $query_string .= 'page=';
            
            ?>
            
            <?php
            if ( $leftest_page >= 11 ) {
                ?><li><a href="freeboard?<?=$query_string.($leftest_page - 10 )?>">«</a></li><?
            }
            
            for ( $i = $leftest_page ; $i <= $rightest_page ; $i++ ) {
                if ( $page == $i ) {
                    ?>
                    <li class="active">
                        <span><?=$i?></span>
                    </li>
                    <?
                } else {
                    ?>
                    <li>
                        <a href="freeboard?<?=$query_string.$i?>"><?=$i?></a>
                    </li>
                    <?
                }
            }
            
            if ( $rightest_page < $last_page ) {
                ?><li><a href="freeboard?<?=$query_string.($leftest_page + 10)?>">»</a></li><?
            }
            ?>
        </ul>
    </div>
</div>

<div class="bbs_search">
    <?
    // get 방식으로 보내기 위해 form_open을 사용하지 않음
    ?>
    <form class="form-search">
        <select name="so">
            <option>1</option>
            <option>2</option>
            <option>123451234512345</option>
            <option>4</option>
            <option>5</option>
        </select>
    
        <div class="input-append">
            <input type="text" name="keyword" class="span2 search-query">
            <button type="submit" class="btn">Search</button>
        </div>
    </form>

</div>

<!-- (e) freeboard -->
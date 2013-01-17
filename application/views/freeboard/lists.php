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

$current_page = $this->pagination->get_current_page();
$leftest_page = $this->pagination->get_leftest_page();
$rightest_page = $this->pagination->get_rightest_page();
$last_page = $this->pagination->get_last_page();
$query_string_prefix = $this->pagination->get_query_string_prefix();

$so = 'search_title';
$keyword = '';
if ( $this->input->get('so') ) $so = $this->input->get('so');
if ( $this->input->get('keyword') ) $keyword = $this->input->get('keyword');
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
                <a href="freeboard/view/<?=$row->id?>?<?=$query_string_prefix."&page=".$current_page?>"><?=$row->title?></a>
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
    <div class="view_articles"><a href="freeboard?<?=$query_string_prefix.'&page='.$current_page?>">목록</a></div>
    <div class="write_article"><a href="freeboard/write">글쓰기</a></div>
</div>

<!-- (s) pagination -->
<div class="">
    <div class="pagination pagination-small pagination-centered">
        <ul>
            <?php
            
            if ( $leftest_page >= 11 ) {
                ?><li><a href="freeboard?<?=$query_string_prefix.'&page='.($leftest_page - 10 )?>">«</a></li><?
            }
            
            for ( $i = $leftest_page ; $i <= $rightest_page ; $i++ ) {
                if ( $current_page == $i ) {
                    ?>
                    <li class="active">
                        <span><?=$i?></span>
                    </li>
                    <?
                } else {
                    ?>
                    <li>
                        <a href="freeboard?<?=$query_string_prefix.'&page='.$i?>"><?=$i?></a>
                    </li>
                    <?
                }
            }
            
            if ( $rightest_page < $last_page ) {
                ?><li><a href="freeboard?<?=$query_string_prefix.'&page='.($leftest_page + 10)?>">»</a></li><?
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
        
        <label for="search_username"><input type="radio" name="so" value="search_username" <?=$so=="search_username"?"checked":""?>>이름</label>
        <label for="search_title"><input type="radio" name="so" value="search_title" <?=$so=="search_title"?"checked":""?>>제목</label>
        <label for="search_content"><input type="radio" name="so" value="search_content" <?=$so=="search_content"?"checked":""?>>내용</label>
        
        <div class="input-append">
            <input type="text" name="keyword" class="span2 search-query" value="<?=$keyword?>">
            <button type="submit" class="btn">Search</button>
        </div>
        
        <?php 
        if ($keyword != "") { 
            ?>
            <input type="button" value="검색취소" class="btn" onclick="javascript:window.location='freeboard';" />  <!-- TODO: inline javascript 없앨것 -->
        <?
        }
        ?>
    </form>
</div>

<!-- (e) freeboard -->
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
            <td><?=$row->created?></td> <!-- TODO : 적절한 date foramt 으로 바꿔야함 -->
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
    <div class="no_articles">
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
            <li class="disabled"><span>«</span></li>
            <li><a href="freeboard/lists/1">1</a></li>
            <li class="active"><span>2</span></li>
            <li><a href="freeboard/lists/3">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#">7</a></li>
            <li><a href="#">8</a></li>
            <li><a href="#">9</a></li>
            <li><a href="#">»</a></li>
        </ul>
    </div>
</div>

<div class="bbs_search">
    <select style="width:80px;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
    </select>
    
    <form class="form-search">
        <div class="input-append">
            <input type="text" class="span2 search-query">
            <button type="submit" class="btn">Search</button>
        </div
    </form>

</div>

<!-- (e) freeboard -->
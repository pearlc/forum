<!-- (s) freeboard -->

<div class="bbs_header">
    <h4><a href="freeboard/"><?=$this->lang->line('common_label_freeboard');?></a></h4>
</div>

<div class="article_title" style="background-color: #eff;height:30px;">
    <h4><?=$article->title?></h4>
</div>

<div class="article_meta">
    <span class="article_username">작성자 <strong><?=$article->username?></strong></span>
    <span class="article_date"><?=$article->created?></span>
    <?php 
    if ( $this->session->userdata('user_id') == $article->user_id ) {
        ?>
    <span class="article_menu">
        <a href="freeboard/edit/<?=$article->id?>">수정</a> <a href="freeboard/delete/<?=$article->id?>">삭제</a>
    </span>
    <?
    }
    ?>
</div>


<div class="article_content">
    <?=$article->content?>
</div>
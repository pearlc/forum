<?php $this->load->view('common_template/header.php'); ?>

<div class="row">

    <div class="span2">
        <div class="user-info">
            <?php $this->load->view('common_template/left_bar_login.php'); ?>
            <?php $this->load->view('common_template/left_bar_user_info.php'); ?>
        </div>
        <?php $this->load->view('common_template/left_bar_nav_tabs.php'); ?>
    </div>

    <div class="span10">
        <!-- (s) 문서 컨텐츠 -->
        <?php $this->load->view('wiki_template/doc_sample.php'); ?>
        <!-- (e) 문서 컨텐츠 -->
    </div>
</div>
<?php $this->load->view('common_template/footer.php');?>
<?php
if (!isset($header)) $header = array();
?>
<?php $this->load->view('common_template/header.php', $header); ?>

<div class="row">

    <div class="span2">
        <div class="user-info">
            <?php $this->load->view('templates/left_bar_login.php'); ?>
            <?php $this->load->view('templates/left_bar_user_info.php'); ?>
        </div>
        <?php $this->load->view('templates/left_bar_nav_tabs.php'); ?>
    </div>

    <div class="span10">
        <!-- (s) forum -->
        <?=$this->lang->line('test_this_is_forum')?>
        <!-- (e) forum -->
    </div>
</div>
<?php $this->load->view('templates/footer.php');?>
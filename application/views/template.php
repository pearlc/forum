<?php
$ci = get_instance();
if ( !isset($data) ) $data = array();

?>

<?php $this->load->view('includes/header.php'); ?>

<div class="row">

    <?php 
    if ($ci->show_sidebar()) {
        ?>
        <div class="span2">
            <div class="user-info">
                <?php 
                if ( $this->tank_auth->is_logged_in() || $this->tank_auth->is_logged_in(false) ) {
                    $this->load->view('includes/left_bar_user_info.php');
                } else {
                    $this->load->view('includes/left_bar_login.php');
                }
                ?>
            </div>
            <?php $this->load->view('includes/left_bar_nav_tabs.php'); ?>
        </div>
        <div class="span10">
            <?php $this->load->view($main_content); ?>
        </div>
        <?
        
    } else {?>
    
        <!-- (s) 메인 컨텐츠 -->
        <div class="span12">
            <?php $this->load->view($main_content, $data); ?>
        </div>
        <!-- (e) 메인 컨텐츠 -->
        
    <? } ?>

    
</div>
<?php $this->load->view('includes/footer.php');?>
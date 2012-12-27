<?php
if (!isset($header)) $header = array();
?>

<?php $this->load->view('templates/header.php', $header); ?>

<div class="row">

    <div class="span2">
        <div class="user-info">
            <?php $this->load->view('templates/left_bar_login.php'); ?>
            <?php $this->load->view('templates/left_bar_user_info.php'); ?>
        </div>
        <?php $this->load->view('templates/left_bar_nav_tabs.php'); ?>
    </div>

    <div class="span10">
        <!-- (s) 문서 컨텐츠 -->
        
        <div class="wiki-content">
            <p>
                음?
            </p>
            <p>
            메인 페이지. 메인 페이지. 메인 페이지 이네욤ㅋ 잘봐주셈ㄷㄱ
            메인 페이지. 메인 페이지. 메인 페이지 이네욤ㅋ 잘봐주셈 ㄷㄱㅇㅋ?
            메인 페이지. 메인 페이지. 메인 페이지 이네욤ㅋ 잘봐주셈ㅂ
            메인 페이지. 메인 페이지. 메인 페이지 이네욤ㅋ 잘봐주셈 ㅇㅋ?
            메인 페이지. 메인 페이지. 메인 페이지 이네욤ㅋ 잘봐주셈ㅁㅇㄹ
            메인 페이지. 메인 페이지. 메인 페이지 이네욤ㅋ 잘봐주셈 ㅇㅋ?
            </p>
        </div>
        <!-- (e) 문서 컨텐츠 -->
    </div>
</div>
<?php $this->load->view('templates/footer.php');?>
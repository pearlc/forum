<?php $this->load->view('templates/header.php', $header); ?>

<div class="container">

    <div class="span4 offset4">
        
        <p>
            <?=$nickname?> 님 환영합니다
        </p>
        <p>
            이메일 주소 인증을 위한 메일이 <?=$email?>로 발송되었습니다.
        </p>
        <p>
            메일을 확인해서 회원 가입을 완료하세요
        </p>
        
    </div>
</div>
<?php $this->load->view('templates/footer.php');?>
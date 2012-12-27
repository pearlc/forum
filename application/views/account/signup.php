<?php $this->load->view('templates/header.php', $header); ?>

<div class="container">

    <div class="span4 offset4">
        <h2>가입</h2>
        <form name="signup" action="<?=$this->config->config['create_account_url']?>" method="POST" >
            <div class="control-group">
                <label class="control-label" for="inputEmail">이메일</label>
                <div class="controls">
                    <input name="email" type="text" id="inputEmail" placeholder="abc@example.com">
                    ㅋ
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNickname">별명</label>
                <div class="controls">
                    <input name="nickname" type="text" id="inputNickname" placeholder="4~12자의 한글, 영문, 숫자">
                    <span>활동시 남겨질 이름</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">비밀번호</label>
                <div class="controls">
                    <input name="password" type="password" id="inputPassword" placeholder="6자 이상의 영문, 숫자, 특수문자">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPasswordConfirm">비밀번호 재입력</label>
                <div class="controls">
                    <input type="password" id="inputPasswordConfirm" placeholder="">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">가입</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('templates/footer.php');?>
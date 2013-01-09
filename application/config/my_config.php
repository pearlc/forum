<?php

// 회원 정보 url : 이렇게 세세한 url을 config 에 넣는게 맞는가...
$config['login_url'] = $this->config['base_url'].'account/login/';
$config['register_url'] = $this->config['base_url'].'account/register/';
$config['forgot_password_url'] = $this->config['base_url'].'account/forgot_password';
$config['mypage_url'] = $this->config['base_url'].'account/mypage';
$config['change_password_url'] = $this->config['base_url'].'account/change_password';
$config['logout_url'] = $this->config['base_url'].'account/logout';

// 세부 서비스 url
$config['news_url'] = $this->config['base_url'].'news';
$config['freeboard_url'] = $this->config['base_url'].'freeboard';
$config['wiki_url'] = $this->config['base_url'].'wiki';

?>

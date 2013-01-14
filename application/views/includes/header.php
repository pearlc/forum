<?php
$ci = get_instance();

$javascripts = $ci->javascripts();
$csses = $ci->csses();
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8" />

        <title><?=$this->lang->line('common_site_title');?></title>
        
        <base href="<?=base_url();?>">
        <meta name="author" content="SLRCLUB, Envision Community">
        <meta name="viewport" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        
        <link href="resources/css/bootstrap.css" rel="stylesheet" />
        <link href="resources/css/my-custom.css" rel="stylesheet" />
        <link href="resources/css/wiki.css" rel="stylesheet" />
        <?php foreach($csses as $k => $v) { ?>
            <link href="resources/css/<?=$v.'.css'?>" rel="stylesheet" />
        <?}?>

        <script src="resources/js/jquery-1.8.3.min.js" type="text/javascript" ></script>
        <script src="resources/js/bootstrap.js" type="text/javascript"></script>
        <?php foreach($javascripts as $k => $v) { ?>
        <script src="resources/js/<?=$v.'.js'?>" type="text/javascript"></script>
        <?}?>

    </head>
	
    <body>
        <div class="container">
            <div class="my-hero-unit">
                    <h1><a href="<?=base_url()?>"><?=$this->lang->line('common_label_header');?></a></h1>
            </div>
<?php
if (!isset($css)) $css = array();
if (!isset($javascript)) $javascript = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <base href="<?=base_url();?>">

        <meta charset="utf-8">
        <meta name="viewport" />

        <link href="resources/css/bootstrap.css" rel="stylesheet" />
        <link href="resources/css/my-custom.css" rel="stylesheet" />
        <link href="resources/css/wiki.css" rel="stylesheet" />
        <?php foreach($css as $k => $v) { ?>
            <link href="resources/css/<?=$v?>" rel="stylesheet" />
        <?}?>

        <script src="resources/js/jquery-1.8.3.min.js" type="text/javascript" ></script>
        <script src="resources/js/bootstrap.js" type="text/javascript"></script>
        <?php foreach($javascript as $k => $v) { ?>
            <script src="resources/js/<?=$v?>" type="text/javascript"></script>
        <?}?>

        <title>GTA V forum</title>
    </head>
	
    <body>
        <div class="container">
            <div class="my-hero-unit">
                    <h1><a href="<?=base_url()?>">GTA V Forum Header !!</a></h1>
                    <p></p>
            </div>
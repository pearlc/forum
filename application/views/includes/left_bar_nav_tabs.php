<?php
$ci = get_instance();
$current_sidebar_title = $ci->current_sidebar_title();
?>
<ul class="nav nav-tabs nav-stacked">
    <li class="<?=$current_sidebar_title=="news"?"active":""?>">
        <a href="<?=$this->config->config['news_url']?>"><?=$this->lang->line('common_label_news');?></a>
    </li>
    <li class="<?=$current_sidebar_title=="freeboard"?"active":""?>">
        <a href="<?=$this->config->config['freeboard_url']?>"><?=$this->lang->line('common_label_freeboard');?></a>
    </li>
    <li class="<?=$current_sidebar_title=="wiki"?"active":""?>">
        <a href="<?=$this->config->config['wiki_url']?>"><?=$this->lang->line('common_label_wiki');?></a>
    </li>
</ul>
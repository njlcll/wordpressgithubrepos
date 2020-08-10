<?php

function sr_add_scripts (){
    wp_enqueue_style('sr-main-style', plugins_url()."/mygithubrepos/css/style.css");
    wp_enqueue_script('sr-main-script', plugins_url()."/mygithubrepos/js/msin.css");
}

add_action('wp_enqueue_scripts', 'sr_add_scripts');
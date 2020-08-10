<?php
/*
Plugin Name: mygithubrepos
Plugin URI: 
Description: A widget to display your github repos
Version: 1.0
Author URI: https://www.njl-dev.co.uk
*/

if(!defined('ABSPATH')){
    exit();
}

//include scripts
require_once (plugin_dir_path(__FILE__)."/includes/github-scripts.php");
require_once (plugin_dir_path(__FILE__)."/includes/github-class.php");


function ghr_register_widget(){
    register_widget('WP_github_class');
}

add_action('widgets_init', "ghr_register_widget");

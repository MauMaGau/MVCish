<?php

    /* Set which config to use at end. It's usually best to create a new config for a new environment, rather than overwriting an existing config */

    $dev_config = array(
        'url_root' => '/',
        'doc_root' => '/',
        'include_root' => 'include/',
        'class_root' => 'class/',
        'db_host' => 'localhost',
        'db_name' => '',
        'db_user' => '',
        'db_pass' => '',
        'admin_email' => ''
    );

    /* Set which config to use here */
    $config = $dev_config;

    setlocale(LC_MONETARY, 'en_US');

    $config['ajax_controller'] = $config['doc_root'].'application/controllers/ajax.controller.php';

    $config['url_style'] = $config['url_root'].'application/resources/style/';
    $config['url_script'] = $config['url_root'].'application/resources/script/';
    $config['url_config'] = $config['url_root'].'config/';
    $config['url_video'] = $config['url_root'].'application/resources/video/';


    $config['url_customer_root'] = $config['url_root'].'customer/';
    $config['url_therapist_root'] = $config['url_root'].'therapist/';
    $config['url_admin_root'] = $config['url_root'].'admin/';

    $config['googleAnalytics'] = $config['doc_root'].'application/views/elements/googleAnalytics.html';
    $config['feedbackForum'] = $config['doc_root'].'application/views/elements/feedbackForum.html';

    $config['searchLog'] = $config['doc_root'].'application/logs/search.txt';

    /* Do not edit below this line */

    function formatDate($date,$isYear=true){
        if(!$isYear){
            return date("l M jS",strtotime($date));
        }else{
            return date("l M jS Y",strtotime($date));
        }

    }

    function formatTime($time){
        return date("g:ia",strtotime($time));
    }

    function formatMoney($money){
        return '$'.money_format('%!i', $money);
    }

?>
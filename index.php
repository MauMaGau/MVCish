<?php
    session_start();

    $start = microtime();

    include ('config/root_config.php');
    // Tidy the url
    $request = $_SERVER['REQUEST_URI'];
    $request = explode("/", $request);

    foreach(array_reverse($request) as $segment){
        if($segment != 'scheduler'){
            $script[] = array_pop($request);
        }else break;
    }
    $script = array_reverse($script);

    $site_section = $script[0];

    // Load appropriate config
    switch($site_section){
        case('main'): include('config/main_config.php');
        break;
        case('customer'): include('config/customer_config.php');
        break;
        case('therapist'): include('config/therapist_config.php');
        break;
        case('paypal'):
        break;
    }

    // Assemble url
    $script = implode('/',$script);
    $script = explode('?',$script);

    // Assemble GET
    $view = $script[0];
    if(isset($script[1])){
        $params = explode('&',$script[1]);
        foreach($params as $k=>$v){
            $v = explode('=',$v);
            $GET[$v[0]] = $v[1];
        }
    }else $GET = array();

    //print_r($script);
    //echo $view;
    //print_r($GET);
    //print_r($request);
    //print_r($get);

    // Assemble POST
    if(!empty($_POST)){
        if(!isset($_POST['ajax_action']) && $site_section != 'iOS'){
            //print_r($_POST);
            $POST = helper_sanitize::sanitize($_POST); // Do sanitization
            //print_r($POST);
        }else{
            $POST = $_POST;//helper_sanitize::nohtml($_POST);
        }
    }else{
        $POST = array();
    }



    // Begin Redirection

     // Check user is allowed in this section
    if(isset($_SESSION['session_id'])){
        $user = new model_user($config);
        $user->session_id = $_SESSION['session_id'];
        $user->verifySession();
        $config['user_id'] = $user->user_id;
        $config['user_type'] = $user->user_type;
        switch($user->user_type){
            case('therapist'): $config['therapist_id'] = $user->therapist_id; break;
            case('customer'): $config['customer_id'] = $user->customer_id; break;
        }
        //print_r($user);
        //print_r($_SESSION);
        if( $site_section != 'main' && $site_section != 'iOS' && $site_section != 'paypal' && (! $user->is_logged_in || $user->user_type != $site_section ) ){
            if( ! isset($POST['ajax_action'])){
            	header('Location:'.$config['url_root'].'main/login.php');
            }

        }
    }else{
        if( $site_section != 'main' && $site_section != 'iOS' && $site_section != 'paypal' && (!isset($POST['ajax_action']) && !isset($POST['ajax_page']) && (!isset($POST['ajax_page']) || strstr($POST['ajax_page'],'main_')))){
            //echo "no session";
            header('Location:'.$config['url_root'].'main/login.php');
        }
    }

    // Handle AJAX requests
    if(isset($POST['ajax_action'])){
        // check section == usertype
        include($config['ajax_controller']);
        exit;
    }

    // Create autoloader
    function __autoload($classname) {
        $local_doc_root = "B:/wamp/www/scheduler/";
        $dev_doc_root = "/opt/lampp/htdocs/scheduler/";
        $doc_root = $dev_doc_root;
        $classname = explode('_',$classname);
        switch($classname[0]){
            case('model'):include($doc_root.'application/models/'. $classname[1] . ".class.php");
            break;
            case('helper'):include($doc_root.'application/helpers/'. $classname[1] . ".helper.php");
            break;
            case('con'):include($doc_root.'application/controllers/'. $classname[1] . ".controller.php");
            break;
            case('lib'):include($doc_root.'application/library/'. $classname[1] . ".library.php");
            break;
            case('db'):include($doc_root.'application/database/'. $classname[0] . ".class.php");
            break;
            case('ajax'):include($doc_root.'application/views/'.$classname[1].'/'.$classname[2].'.ajax.php');
            break;
            case('ios'):include($doc_root.'application/views/iOS/'.$classname[1].'/'.$classname[0].'_'.$classname[1].'.class.php');
            break;
            case('messageTemplate'):include($doc_root.'application/helpers/messageTemplates/'.$classname[1].'.messageTemplate.php');
            break;
            case('video'):include($doc_root.'application/views/elements/video.php');
            break;
            default:include($classname[0].'.php');
        }
    }

    // Include the View
    if(!strstr($view,'edit.php') && !strstr($view,'datafeed.php') && !strstr($view,'ajaxfunctions.php')){
        if(!isset($view) || empty($view)){
        	$view = 'main/index.php';
        }
		if(!strstr($view,'.')){
			if(!strstr($view,'/')){
				$view .= '/';
			}
			$view .= 'index.php';
		}

		//
	    $body_id = str_replace('/','_',substr($view,0,-4));
		if(file_exists($config['doc_root'].'application/views/'.$view)){
            include($config['doc_root'].'application/views/'.$view);
        }else{
            include($config['doc_root'].'application/views/ohnoes404.php');
        }


	    //echo '<br/><hr/>Processed in - ' . (microtime() - $start) . 's';
    }else{
        include($config['doc_root'].'application/helpers/wdCalendar/dbconfig.php');
        include($config['doc_root'].'application/helpers/wdCalendar/functions.php');
        if(strstr($view,'edit.php')){
            include($config['doc_root'].'application/helpers/wdCalendar/edit.php');
        }elseif(strstr($view,'datafeed.php')){
            include($config['doc_root'].'application/helpers/wdCalendar/datafeed.php');
        }

    }

    session_write_close();
?>
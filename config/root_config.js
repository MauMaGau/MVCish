var config = [];
if(document.location.href.indexOf('192.168.0.20') != -1){
        config['url_root'] = 'http://192.168.0.20/scheduler/';
    }else{
        config['url_root'] = 'http://dtownsend.dyndns.org/scheduler/';
    }
// config['url_root'] = 'http://dtownsend.dyndns.org/scheduler/';
config['url_edit.ajax'] = config['url_root'] + 'helpers/wdCalendar/edit.ajaxfunctions.php';
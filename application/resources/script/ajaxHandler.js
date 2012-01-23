function retrieveAjax(page, action, data){
    /*alert(action);*/
    $.ajax({
        url: config['url_root'],
        async: false,
        data: {
             ajax_action: action,
             ajax_page: page,
             ajax_data: data
         },
         type: 'post',
         success: function(output) {
                      ajaxOutput = output
                      /*console.log(ajaxOutput);*/
                  }
    });
    return ajaxOutput;
}
/*$(holder).append(output)*/

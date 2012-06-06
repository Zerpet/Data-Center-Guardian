
var $dialog;

function check_consumption_form() {
    var $form = $('#record_form');
    var regex = /^\d{1,2}(\.\d{1,2})?$/;
    
    return regex.test($form.children(':nth-child(5)').val());
}

function add_new_record() {
    if($dialog !== undefined)
        $dialog.dialog("destroy");
    
    $dialog = undefined;
    
    $dialog = $('#form-container').dialog({autoOpen: true, modal: true, resizable: false, position: 'top', buttons: {
            "Submit": function() {
                if(check_consumption_form())
                    $('#record_form').submit();
                else 
                    $('#record_form').children(':nth-child(5)').css("border", "1px #FF0000 solid");
            },
            "Cancel": function() {
                if($dialog !== undefined)
                    $dialog.dialog("destroy");

                $dialog = undefined;
            }
    }});
    
}

function show_historical(rack_id) {
    alert("Not implemented yet!");
    return;
    
    
    
    
}

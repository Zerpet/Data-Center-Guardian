
var $dialog;
var last_position = null;
$(function() {
    $dialog = $("#machine-view").dialog({resizable: false, minWidth: 400, autoOpen: false,
        beforeClose: function(event, ui) {
            last_position = $dialog.dialog( "option", "position" );
        }});
});

/*
 * 
 */
function open_machine_dialog(name, responsible, starting) {
    
    if(last_position !== null) {
        $dialog.dialog("option", "position", last_position);
    }
    
    $.post("https://163.117.142.145/pfc/logic/query_machine.php", "name=" + name + "&responsible=" + responsible + "&start=" + starting, 
    function(data) {
        //data is already an object
        $('#responsible-information').children(':nth-child(1)').text(data.responsible);
        $('#responsible-information').children(':nth-child(2)').text(data.email);
        $('#responsible-information').children(':nth-child(3)').text(data.phone);
        $('#responsible-information').children(':nth-child(4)').text(data.office);
        
        $('#machine-information').children(':nth-child(1)').text(data.os);
        $('#machine-information').children(':nth-child(2)').text(data.ip);
        $('#machine-information').children(':nth-child(3)').text(data.color);
        $('#machine-information').children(':nth-child(4)').text(data.type);
        
        $('.machine-notes').text(data.notes);
        
        $dialog.dialog('open');
        
    }, "json");
    
}

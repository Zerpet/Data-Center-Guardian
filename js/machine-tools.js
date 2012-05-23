
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
        $dialog.dialog("option", "title", data.name);
        //data is already an object
        $('#responsible-information').children(':nth-child(1)').text(data.responsible);
        $('#responsible-information').children(':nth-child(2)').text(data.email);
        $('#responsible-information').children(':nth-child(3)').text(data.phone);
        $('#responsible-information').children(':nth-child(4)').text(data.office);
        
        $('#machine-information').children(':nth-child(1)').text(data.os);
        $('#machine-information').children(':nth-child(2)').text(data.ip);
        $('#machine-information').children(':nth-child(3)').text(data.color);
        $('#machine-information').children(':nth-child(4)').text(data.type);
        $('#machine-information').children(':nth-child(5)').text('Starts at ' + data.start);
        $('#machine-information').children(':nth-child(6)').text('It takes ' + data.us + ' U');
        
        $('.machine-notes').text(data.notes);
        
        $dialog.dialog('open');
        
    }, "json");
    
}

/*
 * 
 */
function edit_machine() {
    
    var html_form;
    
    $.get("https://163.117.142.145/pfc/logic/machine_edition.php", null, function(candidates) {
        var options = "";
        
        $.each(candidates, function(index, val) {
           options += '<option value="' + val + '">' + val + '</option>';
        });
        
        html_form = '<form id="machine-form" action="logic/commit_machine.php">\n' +
            '<input type="text" name="name" value="' + $dialog.dialog("option", "title") + '" />\n' +
            '<select name="responsible" form="machine-form">\n' +
            options +
            '</select>\n' +
            '<input type="text" name="os" value="' + $('#machine-information').children(":nth-child(1)").text() + '" />\n' +
            '<input type="text" name="ip" value="' + $('#machine-information').children(":nth-child(2)").text() + '" />\n' +
            '<select name="color" form="machine-form">\n' +
                '<option value="Bright">Bright</option>\n' +
                '<option value="Dark">Dark</option>\n' +
            '</select>\n' +
            '<select name="type" form="machine-form">\n' +
                '<option value="UPS">UPS</option>\n' +
                '<option value="Switch">Switch</option>\n' +
                '<option value="KVM">KVM</option>\n' +
                '<option value="Server">Server</option>\n' +
                '<option value="Storage Server">Storage Server</option>\n' +
            '</select>\n' +
            '<textarea form="machine-form" name="notes" maxlength="255">\n' +
                $('.machine-paragraph.machine-notes').text() +
            '</textarea>\n' +
            '<b>Starts? </b><input type="number" name="start" value="' + $('#machine-information').find(':nth-child(5)').text() + '" style="display: inline" />\n' +
            '<b>Length? </b><input type="number" name="us" value="' + $('#machine-information').find(':nth-child(6)').text() + '" style="display: inline" />\n' +
        '</form>\n';
        //TODO
        console.log(html_form);
        
    }, "json");
    
    
    
    $('#machine-view-content');
}

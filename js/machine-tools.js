
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
        $('#machine-information').children(':nth-child(5)').html('Starts at <b>' + data.start + '</b>');
        $('#machine-information').children(':nth-child(6)').html('It takes <b>' + data.us + '</b> U');
        
        $('.machine-notes').text(data.notes);
        
        $dialog.dialog('open');
        
    }, "json");
    
}

/*
 * 
 */
function edit_machine() {
    
    var html_form;
    var old_name = $dialog.dialog("option", "title");
    var old_resp = $('#responsible-information').children(':nth-child(1)').text();
    
    
    $.get("https://163.117.142.145/pfc/logic/machine_edition.php", null, function(candidates) {
        var options = "";
        
        $.each(candidates, function(index, val) {
           options += '<option value="' + val + '">' + val + '</option>';
        });
        
        html_form = '<form id="machine-form" action="logic/machine_edition.php" method="post">\n' +
            '<label>Name </label><input class="machine-paragraph" type="text" name="name" value="' + $dialog.dialog("option", "title") + '" /><br>\n' +
            '<select class="machine-paragraph" name="responsible" form="machine-form">\n' +
            options +
            '</select><br>\n' +
            '<label>OS </label><input class="machine-paragraph" type="text" name="os" value="' + $('#machine-information').children(":nth-child(1)").text() + '" /><br>\n' +
            '<label>IP </label><input class="machine-paragraph" type="text" name="ip" value="' + $('#machine-information').children(":nth-child(2)").text() + '" /><br>\n' +
            '<select class="machine-paragraph" name="color" form="machine-form">\n' +
                '<option value="Bright">Bright</option>\n' +
                '<option value="Dark">Dark</option>\n' +
            '</select><br>\n' +
            '<select class="machine-paragraph" name="type" form="machine-form">\n' +
                '<option value="UPS">UPS</option>\n' +
                '<option value="Switch">Switch</option>\n' +
                '<option value="KVM">KVM</option>\n' +
                '<option value="Server">Server</option>\n' +
                '<option value="Storage Server">Storage Server</option>\n' +
            '</select><br>\n' +
            '<label>Notes </label><br>\n' +
            '<textarea class="machine-paragraph" form="machine-form" name="notes" maxlength="255">\n' +
                $('.machine-paragraph.machine-notes').text() +
            '</textarea><br>\n' +
            '<b>Starts? </b><input class="machine-paragraph" type="number" name="start" value="' + $($('#machine-information').find('b')[0]).text() + '" style="display: inline; width: 1cm;" maxlength="2" min="0" max="42" required="required" /><br>\n' +
            '<b>Length? </b><input class="machine-paragraph" type="number" name="us" value="' + $($('#machine-information').find('b')[1]).text() + '" style="display: inline; width: 1cm;" maxlength="1" min="1" max="9" required="required" /><br>\n' +
            '<button class="medium button blue" type="submit">Save</button>' +
            '<button class="medium button red" id="discard-machine" type="button">Cancel</button>' +
        '</form>\n';
        
        
        $('#machine-view-content').html(html_form);
        
        $('#machine-form').submit(function(event) {
            
            var url = event.target.action;
            var data = "";
            $(event.target.elements).each(function(index, val) {
                
                if(val != "" && index < event.target.length - 2)
                    data += val.name + "=" + $(val).val() + "&";
                
            });
            
//            data = data.substr(0, data.length-1);

            data += "old_name=" + old_name + "&old_resp=" + old_resp;

            data = encodeURI(data);
            
            $.post(url, data, function(json) {
                //OK or ERROR
            }, "json");
            
            return false;
        });
        
        
    }, "json");
    //GET ends here
    
    
    $('#machine-view-content');
}

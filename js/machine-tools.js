
var $dialog;
var last_position = null;

$(function() {
    $('#machine-form').submit(function(event) {
        event.preventDefault();
        
        var valid = true;
        event.target.elements[3].style.border = "0px #FF0000 solid";
        valid = valid && validate_complete_ip(event.target.elements[3].value);
        
        if(valid === false) {
            event.target.elements[3].style.border = "1px #FF0000 solid";
            return valid;
        }
        event.target.elements[4].style.border = "0px #FF0000 solid";
        valid = valid && validate_color(event.target.elements[4].value);
        
        if(valid === false) {
            event.target.elements[4].style.border = "1px #FF0000 solid";
            return valid;
        }
            
        event.target.elements[5].style.border = "0px #FF0000 solid";
        valid = valid && validate_type(event.target.elements[5].value);
        
        if(valid === false) {
            event.target.elements[5].style.border = "1px #FF0000 solid";
            return valid;
        }
        
        event.target.elements[7].style.border = "0px #FF0000 solid";
        valid = valid && validate_starts(event.target.elements[7].value);
        
        if(valid === false) {
            event.target.elements[7].style.border = "1px #FF0000 solid";
            return valid;
        }
        
        event.target.elements[8].style.border = "0px #FF0000 solid";
        valid = valid && validate_us(event.target.elements[8].value);
        
        if(valid === false) {
            event.target.elements[8].style.border = "1px #FF0000 solid";
            return valid;
        }
            
        
        var url = event.target.action;
        var data = "";
        $(event.target.elements).each(function(index, val) {

            if(val != "" && index < event.target.length)
                data += val.name + "=" + $(val).val() + "&";

        });
        
        data = data.substr(0, data.length - 1);
        data = encodeURI(data);
        
        $.post(url, data, function(html) {
            //OK or ERROR
            if($dialog !== undefined) {
                $dialog.dialog("destroy");
            }
            $dialog = undefined;
            $(html).insertAfter("#rac-schema");
            setTimeout("$('#machine-commit-state').fadeOut('slow', function(){ $('#machine-commit-state').remove(); });", 5000);
        }, "html");
        
        return false;
    });
});

function open_machine_dialog(name, responsible, starting)  {
    
    if($dialog !== undefined) {
        $dialog.dialog("open");
        return;
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
        $('#machine-information').children(':nth-child(5)').html('Starts at <b>' + data.start + '</b>');
        $('#machine-information').children(':nth-child(6)').html('It takes <b>' + data.us + '</b> U');
        
        $('.machine-notes').text(data.notes);
        
        
        var buttons_array = [
            {
                text: "Close",
                click: function() {
                    $( this ).dialog( "close" );
                }
            }
        ];
        
        if(responsible === "administrator") {
            buttons_array.push({
                text: "Edit",
                click: function() {
                    edit_machine(name, data.responsible);
                }
            }, {
                text: "Delete",
                click: function() {
                    if(confirm("This action can not be undone! Are you sure you want to proceed?") === true)
                        delete_machine(name, data.responsible);
                }
            }
            );
        }
        
        $dialog = $("#machine-view").dialog({resizable: false, minWidth: 400, autoOpen: false, 
            modal: true, buttons: buttons_array});
        
        $dialog.dialog("option", "title", data.name);
        $dialog.dialog('open');
        
    }, "json");
    
}

function edit_machine(name, resp) {
    
    if($dialog === undefined)
        return;
    
    $dialog.dialog("destroy");
    $dialog = undefined;
    
    
    var $mach_form = $('#machine-form').children();
    var $mach_inf = $('#machine-information').children();


    $($mach_form[1]).val(name);

    $($mach_form[6]).val($($mach_inf[0]).text());
    $($mach_form[9]).val($($mach_inf[1]).text());

    $($mach_form[11]).children("[value='" + $($mach_inf[2]).text() + "']").attr("selected", "selected");
    $($mach_form[13]).children("[value='" + $($mach_inf[3]).text() + "']").attr("selected", "selected");

    $($mach_form[17]).text($('.machine-paragraph.machine-notes').text());

    $($mach_form[20]).val($($mach_inf[4]).children(":nth-child(1)").text());
    $($mach_form[23]).val($($mach_inf[5]).children(":nth-child(1)").text());

    $($mach_form[25]).val(name);
    $($mach_form[26]).val(resp);
    
    var options = sessionStorage.getItem('candidates');
    
    if(options === null) {

        //Add session ID here as parameter?
        $.get("https://163.117.142.145/pfc/logic/machine_edition.php", null, function(candidates) {
            
            options = "";

            $.each(candidates, function(index, val) {
                if(val === resp)
                    options += '<option value="' + val + '" selected="selected">' + val + '</option>';
                else
                    options += '<option value="' + val + '">' + val + '</option>';
            });

            $('#machine-form').children(":nth-child(4)").html(options);
            
            sessionStorage.setItem('candidates', options);
            
            $dialog = $('#dialog-form').dialog({resizable: false, modal: true, 
                buttons: {
                    Save: function() {
                        
                        $('#machine-form').submit();
                    },
                    Cancel: function() {
                        $dialog.dialog("destroy");
                        $dialog = undefined;
                    }
                }
            });

        }, "json");
        
    } else {
        $('#machine-form').children(":nth-child(4)").html(options);
        
        $dialog = $('#dialog-form').dialog({resizable: false, modal: true, 
            buttons: {
                Save: function() {
                    $('#machine-form').submit();
                },
                Cancel: function() {
                    $dialog.dialog("destroy");
                    $dialog = undefined;
                }
            }
        });
    }
}

function delete_machine(name, resp) {
    var data = "name=" + escape(name) + "&responsible=" + escape(resp) + "&action=delete";
    var url = "https://163.117.142.145/pfc/logic/machine_commit.php";
    
    $.post(url, data, function(state_html){
        if($dialog !== undefined) {
                $dialog.dialog("destroy");
            }
            $dialog = undefined;
            
        $(state_html).insertAfter("#rac-schema");
        setTimeout("$('#machine-commit-state').fadeOut('slow', function(){ $('#machine-commit-state').remove(); });", 5000);
    }, "html");
    
}

function add_new_machine(rack_id) {
    var $mach_form = $('#machine-form');
    $mach_form[0].reset();
    
    if($dialog !== undefined)
        $dialog.dialog("destroy");
    
    $mach_form.children("[name=old_name]").val(rack_id);
    
    var options = sessionStorage.getItem('candidates');
    
    if(options === null) {

        //Add session ID here as parameter?
        $.get("https://163.117.142.145/pfc/logic/machine_edition.php", null, function(candidates) {
            
            options = "";

            $.each(candidates, function(index, val) {
                options += '<option value="' + val + '">' + val + '</option>';
            });

            $('#machine-form').children(":nth-child(4)").html(options);
            
            sessionStorage.setItem('candidates', options);
            
            $dialog = $('#dialog-form').dialog({resizable: false, modal: true, 
                buttons: {
                    Save: function() {
                        $mach_form = $('#machine-form');
                    
                        $mach_form.attr("action", "logic/machine_commit.php");
                        $mach_form.submit();
                        $mach_form.attr("action", "logic/machine_commit.php");
                    },
                    Cancel: function() {
                        $dialog.dialog("destroy");
                        $dialog = undefined;
                    }
                }
            });

        }, "json");
        
    } else {
        $('#machine-form').children(":nth-child(4)").html(options);
        
        $dialog = $('#dialog-form').dialog({resizable: false, modal: true, 
            buttons: {
                Save: function() {
                    $mach_form = $('#machine-form');
                    
                    $mach_form.attr("action", "logic/machine_commit.php");
                    $mach_form.submit();
                    $mach_form.attr("action", "logic/machine_commit.php");
                },
                Cancel: function() {
                    $dialog.dialog("destroy");
                    $dialog = undefined;
                }
            }
        });
    }
    
}

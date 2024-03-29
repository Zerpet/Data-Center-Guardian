
/**
 * This function changes the elements of RACK view back to "Non-editable" mode.
 * It also restores the previous values of the fields.
 */
function cancel_rack_editing(rack_id) {
    
    if(typeof(Storage)!=="undefined") {
        
        $('#rac-iface').children("li").each(function(index) {
            $(this).text(sessionStorage.getItem("iface" + index));
            sessionStorage.removeItem("iface" + index)
        });
        
        
        
        //Next lines are just to remove some text from "editable mode", which is not necessary any more
        $('#rac-iface').children("input").remove();
        var aux = $('#rac-iface').html();
        $('#rac-iface').html(aux.substr(0, aux.lastIndexOf("</li>") + 5));
        
    } else {
        alert("Changes can not be undone because your browser does not support web storage");
        
        //But remove html for inputs
        $('#rac-iface').children("input").remove();
        var aux2 = $('#rac-iface').html();
        $('#rac-iface').html(aux2.substr(0, aux2.lastIndexOf("</li>") + 5));
    }
    
    $('#edit_rack').text("Edit RACK");
    $('#edit_rack').attr("name", "edit");
    $('#edit_rack').attr("onclick", "edit_rack();");
    
    $('#add_machine').text("Add machine");
    $('#add_machine').attr("name", "add");
    $('#add_machine').attr("onclick", "add_new_machine('" + rack_id + "');");
    
    $('#rac-info').children("p").remove();
    $('#phases').remove();
    
    $('#war-title').text("RACK name: " + $('input[name=rack-title]').val());
    
}

/**
 * This function changes rack view to "editable mode". It stores a copy of 
 * current values, just in case the user decides to not commit changes.
 */
function edit_rack(rack_id) {

    var index = 0;
    var ifaces = new Array();
    $('#rac-iface').children("li").each(function(i) {
        ifaces[i] = $(this).text();
        
        //Add editable text field for each element in list
        $(this).html('<input style="width: 30px;" type="number" value="' + ifaces[i].split(" -> ")[0] + '"' + 'size="2" mix="1" max="11"/>' + ' -> ' + '<input style="width: 85px;" type="text" value="' + ifaces[i].split(" -> ")[1] + '"' + 'size="16" />');
        
        index++;
    });
    
    while(index < 3) {
        $('#rac-iface').append('<input style="width: 30px;" type="number" value="" size="2"  mix="1" max="11"/>' + ' -> ' + '<input style="width: 85px;" type="text" value="" size="16" /><br/>');
        index++;
    }
    
    //Change button names and functions
    var $edit_rack = $('#edit_rack');
    $edit_rack.text("Discard changes");
    $edit_rack.attr("name", "cancel");
    $edit_rack.attr("onclick", "cancel_rack_editing('" + rack_id + "');");
    
    var $add_machine = $('#add_machine');
    $add_machine.text("Save changes");
    $add_machine.attr("name", "commit");
    $add_machine.attr("onclick", "commit_rack();");
    
    if(typeof(Storage)!=="undefined")
    {
        //Store a copy of current values, just in case
        for(i = 0; i < ifaces.length; i++) 
            sessionStorage.setItem("iface" + i, ifaces[i]);
        
    }
    else {
        alert("Be carefull!! Your browser does not support local storage, so changes cannot be undone.");
    }
    
    
    var phase_id = sessionStorage.getItem($('#rac-view').attr("class"));
    var phase_connection = "<p><img id='plug-img' src='images/PLUG.png' /> Connected to </p> <select id='phases'>";
    
    for(i = 1; i <= 11; i ++) {
        if( i == phase_id ) 
            phase_connection += '<option value="' + i + '" selected="selected">' + i + '</option>';
        else 
            phase_connection += '<option value="' + i + '">' + i + '</option>';
    }
    
    phase_connection += "</select>";
    
    $('#rac-iface').after(phase_connection);
    
    $('#war-title').html('<label style="font-size: 18px;">RACK name:</label><input type="text" value="' + $('#war-title').text().slice(11) + '" name="rack-title" />');
}


/**
 * This function gets the values from the inputs of rack-view and prepares a
 * query to commit the changes on current rack. It is also responsible of
 * updating the interface after successfull query.
 */
function commit_rack() {
    
    var pairs = new Array(3);
    var i = 0;
    //Burrarrum!
     $('#rac-iface').find(':input').each(function(index, dom) {
        
        if(index % 2 == 0) {    //If it's even, iface
            pairs[i] = new Array(2);
            pairs[i][0] = dom.value;
        } else {    //If it's odd, ip
            pairs[i++][1] = dom.value;
        }
        
    });
    
    var post_string = "rack=" + $('#rac-view').attr("class");
    
    for(i = 0; i < pairs.length; i++) {
        
        if(validate_input(pairs[i][0], pairs[i][1])) {
            post_string = post_string.concat("&iface" + (i+1) + "=" + pairs[i][0], "&ip" + (i+1) + "=" + encodeURI(pairs[i][1]));
        } else {
            alert("Interface or subnet are not a valid input");
            return;
        }
    }
    
    post_string += "&connected=";
    post_string += $('#phases').val();
    
    post_string += "&name=";
    post_string += $('input[name=rack-title]').val();
    
    
    $('body').css("cursor", 'url("https://163.117.142.145/pfc/images/loading.gif")');
    
    //Time to ajax
    $.post("https://163.117.142.145/pfc/logic/rack_commit.php", post_string, 
        function() {
           $('body').css("cursor", 'auto'); 
        }, "text")
        .success(function(data) {
            
            $.post("https://163.117.142.145/pfc/logic/wardrobe_view.php", "rac="+data, 
            function(html) {
                $('#rac-view').html(html);
            }, "html");
        });
    
}


function add_new_rack(id) {
    
    $.post("https://163.117.142.145/pfc/logic/add_rack.php", "rack=" + id, 
    function(data) {
        $('#boxes').hide('slow');
        $('#rac-view').show('slow', function() {
            $('#rac-view').html(data);
            $('#rac-view').removeClass();
            $('#rac-view').addClass(id);
            $('#phases option:nth-child(' + sessionStorage.getItem(id) + ')').attr("selected", "selected");
        });
        
    }, "html");
    
}

/*
 * name
 * rack
 * ip1
 * ip2
 * ip3
 * iface1
 * iface2
 * iface3
 * connected
 */
function delete_rack(id) {
    if(confirm("This action cannot be undone! Do you want to proceed?") === false)
        return;
    
    var post_string = "name=unnamed&rack=" + id + "&ip1=&ip2=&ip3=&iface1=&iface2=&iface3=&connected=" + sessionStorage.getItem(id);
    
    //Time to ajax
    $.post("https://163.117.142.145/pfc/logic/rack_commit.php", post_string, 
        function() {
           hide_view('rac-view', 'boxes');
        }, "text");
    
}

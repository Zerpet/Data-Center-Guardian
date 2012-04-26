
/**
 * This function shows a rac-view. It checks whether the wardrobe
 * have already been requested; in that case, it's toggled. If the 
 * wardrobe is not 'cached', it is requested to server.
 */
function show_rac(position) {
    
    if($('#rac-view').is(':visible') && $('#rac-view').hasClass(position)) {
        //Hide rac view and show back boxes
        $('#rac-view').hide(400, function() {
            $('#boxes').slideDown(400);
        });
    } else if(!$('#rac-view').is(':visible') && $('#rac-view').hasClass(position)) {
        //Hide boxes and show 'cached' RAC
        $('#boxes').slideUp(400, function() {
            $('#rac-view').show(400);
        });
    } else {
        //Hide everything in middle and query for clicked rac
        $('#rac-view').hide('slow', function() {
            $('#boxes').hide('slow', function() {
                $.ajax({
                url: "https://163.117.142.145/pfc/logic/wardrobe_view.php",
                type: "POST",
                data: "rac=" + position,
                success: function(wardrobe_html) {
                    $('#rac-view').html(wardrobe_html);
                    $('#rac-view').removeClass();
                    $('#rac-view').addClass(position);
                    $('#rac-view').show(400); 
                }
                //TODO on error case
                });
            });
        });
    }
}

/**
 * Function to hide an element. First parameter should be an element ID. Second
 * parameter is optional and should be an element ID to show.
 */
function hide_view(hideme, showme) {
    if(hideme === undefined) {
        alert("No present ID to hide"); //TODO delete debug alert
        return;
    }
    
    $('#' + hideme).hide(400);
    
    if(showme !== undefined)
        $('#' + showme).show('fast');
    
}

/**
 * Function to expand or compact the RAC schema painted on RAC view.
 */
function expand_compact_rac() {
    if($('#rac-view').is(":visible")) {
        
        $('.compact').each(function( i ) {
            $(this).fadeToggle(200 + i*100);
        });
        
        if($('button[name=expand]').attr("name") === "expand") {
            $('button[name=expand]').text("Compact RAC");
            $('button[name=expand]').attr("name", "compact");
        } else if($('button[name=compact]').attr("name") === "compact") {
            $('button[name=compact]').text("Expand RAC");
            $('button[name=compact]').attr("name", "expand");
        }
    }
}

/**
 * This function changes the elements of RACK view back to "Non-editable" mode.
 * It also restores the previous values of the fields.
 */
function cancel_rack_editing() {
    
    if(typeof(Storage)!=="undefined") {
        
        $('#rac-iface').children("li").each(function(index) {
            $(this).text(sessionStorage.getItem("iface" + index));
            sessionStorage.removeItem("iface" + index); //Once restored, remove
        });
        
        //Next lines are just to remove some text from "editable mode", which is not necessary any more
        $('#rac-iface').children("input").remove();
        var aux = $('#rac-iface').html();
        $('#rac-iface').html(aux.substr(0, aux.lastIndexOf("</li>") + 5));
        
    } else {
        alert("Changes can not be undone because your browser does not support web storage");
        
        $('#rac-iface').children("input").remove();
        var aux2 = $('#rac-iface').html();
        $('#rac-iface').html(aux2.substr(0, aux2.lastIndexOf("</li>") + 5));
    }
    
    $('#edit_rack').text("Edit RACK");
    $('#edit_rack').attr("name", "edit");
    $('#edit_rack').attr("onclick", "edit_rack();");
    
    $('#add_machine').text("Add machine");
    $('#add_machine').attr("name", "add");
    $('#add_machine').attr("onclick", "alert('Not implemented yet!');");
    
}

/**
 * This function changes rack view to "editable mode". It stores a copy of 
 * current values, just in case the user decides to not commit changes.
 */
function edit_rack() {

    var index = 0;
    var ifaces = new Array();
    $('#rac-iface').children("li").each(function(i) {
        ifaces[i] = $(this).text();
        //Add editable text field for each element in list
        $(this).html('<input type="number" value="' + ifaces[i].split(" -> ")[0] + '"' + 'size="3" />' + ' -> ' + '<input type="number" value="' + ifaces[i].split(" -> ")[1] + '"' + 'size="4" />');
        index++;
    });
    
    while(index < 3) {
        $('#rac-iface').append('<input type="number" value="" size="3" />' + ' -> ' + '<input type="number" value="" size="4" />');
        index++;
    }
    
    //Change button names and functions
    $('#edit_rack').text("Discard changes");
    $('#edit_rack').attr("name", "cancel");
    $('#edit_rack').attr("onclick", "cancel_rack_editing();");
    
    $('#add_machine').text("Save changes");
    $('#add_machine').attr("name", "commit");
    $('#add_machine').attr("onclick", "commit_rack();");
    
    if(typeof(Storage)!=="undefined")
    {
        for(i = 0; i < ifaces.length; i++) 
            sessionStorage.setItem("iface" + i, ifaces[i]);
        
    }
    else {
        alert("Be carefull!! Your browser does not support local storage, so changes cannot be undone.");
    }
    
}


function commit_rack() {
    
}



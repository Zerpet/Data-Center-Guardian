
/**
 * This function shows a rac-view. It checks whether the wardrobe
 * have already been requested; in that case, it's toggled. If the 
 * wardrobe is not 'cached', it is requested to server.
 */
function show_rac(position) {
    
    if($('#rac-view').is(':visible') && $('#rac-view').hasClass(position)) {
        //Hide rac view and show back boxes
        $('#rac-view').hide('fast', function() {
            $('#boxes').slideDown(400);
        });
    } else if(!$('#rac-view').is(':visible') && $('#rac-view').hasClass(position)) {
        //Hide boxes and show 'cached' RAC
        $('#boxes').slideUp(400, function() {
            $('#rac-view').show('fast');
        });
    } else {
        //Hide everything in middle and query for clicked rac
        $('#rac-view').hide('fast', function() {
            $('#boxes').hide('high', function() {
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

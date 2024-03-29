
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
    if(hideme !== undefined) 
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

/*
 * Function to clear the sessionStorage on logout
 */
function logout() {
   sessionStorage.clear(); 
}

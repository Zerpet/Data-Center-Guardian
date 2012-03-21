
function show_wardrobe(position) {
    
    if($('#wardrobe-view').is(':visible') && $('#wardrobe-view').hasClass(position)) {
        $('#wardrobe-view').hide('fast', function() {
            $('#boxes').slideDown(400);
        });
    } else {
        $('#wardrobe-view').hide('fast', function() {
            $('#boxes').hide('high', function() {
                $.ajax({
                url: "https://163.117.142.145/pfc/logic/wardrobe_view.php",
                type: "POST",
                data: "wardrobe=" + position,
                success: function(wardrobe_html) {
                    $('#wardrobe-view').html(wardrobe_html);
                    $('#wardrobe-view').removeAttr("hidden");
                    $('#wardrobe-view').removeClass();
                    $('#wardrobe-view').addClass(position);
                    $('#wardrobe-view').show(400); 
                    }
                });
            });
        });
    }
}


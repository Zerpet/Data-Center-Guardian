
var $dialog;
var chart;
var ocupation_chart;

function check_consumption_form() {
    var $form = $('#record_form');
    var regex = /^\d{1,2}(\.\d{1,2})?$/;
    
    return regex.test($form.children(':nth-child(5)').val());
}

function add_new_record() {
    if($dialog !== undefined)
        $dialog.dialog("destroy");
    
    $dialog = undefined;
    
    $dialog = $('#form-container').dialog({autoOpen: true, modal: true, resizable: false, position: 'center', buttons: {
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

function show_historical(rack_id, rack_name) {
    rack_id = parseInt(rack_id, 10);
    
    if(typeof(rack_id) !== "number")
        return;
    
    var post_data = "rack=" + rack_id;
    
    $.post("https://163.117.142.145/pfc/logic/consumption_query.php", post_data, 
    function(data){
        
        if(data.hasOwnProperty("error")) {
            $('#left-phase-container').slideUp('fast');
            $('#right-phase-container').slideUp('fast');
            
            //consumption-commit-state
            $('.content').append('<div id="consumption-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-error ui-corner-all"> <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span><strong>Ops!</strong> Server found and error:' + data.message + '</p></div>');
            setTimeout("$('#consumption-commit-state').fadeOut('slow', function(){ $('#consumption-commit-state').remove(); $('#left-phase-container').slideDown('fast'); $('#left-phase-container').slideDown('fast'); });", 5000);
            return;
        }
        
        
        var data_table = new google.visualization.DataTable();
        data_table.addColumn('date', 'Date');
        data_table.addColumn('number', 'Current');
        
        $.each(data, function(index) {
            data_table.addRow([new Date(data[index].record_timestamp.replace(" ", "T")), parseFloat(data[index].electric_current, 10)]);
        });
        
        var formatter = new google.visualization.DateFormat({pattern: "dd-MMM-yyyy HH:mm:ss"});
        formatter.format(data_table, 0);
        
        var options = {
          title: 'RACK Consumption',
          leyend: {position: 'top', textStyle: {color: 'blue', fontSize: 16}},
          vAxis: {format: '##,##', maxValue: 25, minValue: 0},
          width: 620,
          height: 250,
          pointSize: 5
        };
        
        chart = new google.visualization.LineChart(document.getElementById('chart_container'));
        chart.draw(data_table, options);
        
        $('#left-phase-container').slideUp('fast');
        $('#right-phase-container').slideUp('fast', function() {
            $('#close_buton').slideDown(500);
            $('#chart_title').slideDown(500).text("Historical data for RACK " + rack_name);
            $('#chart_container').slideDown(600);
            $('#ocupation_chart').slideDown(500);
        });
        
    }, "json");
    
    
    
}

function close_chart() {
    $('#chart_title').slideUp('fast');
    $('#close_buton').slideUp('fast');
    $('#ocupation_chart').slideUp('fast');
    $('#chart_container').slideUp('fast', function() {
        $('#left-phase-container').slideDown(400);
        $('#right-phase-container').slideDown(500);
    });
    
    if(chart !== undefined) {
        chart.clearChart();
        chart = undefined;
    }
    
    if(ocupation_chart !== undefined) {
        ocupation_chart.clearChart();
        ocupation_chart = undefined;
    }
    
}

function ocupationChart(rack_name, rack_ocupation) {
    var data = new google.visualization.DataTable();
    
    data.addColumn('string', 'State');
    data.addColumn('number', 1);
    data.addRow(['Used space', parseFloat(rack_ocupation)]);
    data.addRow(['Free', parseFloat(100 - rack_ocupation)]);
    
    var opt = {title: rack_name, backgroundColor: {fill: 'white'}};
    
    ocupation_chart = new google.visualization.PieChart(document.getElementById("ocupation_chart"));
    ocupation_chart.draw(data, opt);
}

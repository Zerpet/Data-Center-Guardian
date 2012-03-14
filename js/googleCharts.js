/* Charts everywhere! */

// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {
    'packages':['corechart', 'gauge']
});


// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(function(){
    var pie = new ChartsPro();
    pie.createChart({
            'title':'Disk Usage',
            'width': 400,
            'height': 300,
            'is3D': true
        });
    pie.setColumn([{type:'string',label:'Topping'},{type:'number',label:'Value'}]);
    pie.setRows(
        [
            ['Iddle',20],
            ['Writes',55],
            ['Reads',25]
        ]
    );
    pie.setTarget("chart_div");
    pie.setTypeChart("PieChart");
    pie.drawChart();
});



google.setOnLoadCallback(function(){
    var gau = new ChartsPro();
    gau.createChart({width: 400, height: 120, redFrom: 90, redTo: 100, yellowFrom:75, yellowTo: 90, minorTicks: 5});
    gau.setColumn([{type:'string',label:'Label'},{type:'number',label:'Value'}]);
    gau.setRows(
        [
            ['Memory',80],
            ['CPU',55],
            ['TC',47]
        ]
    );
    gau.setTarget("gauge_div");
    gau.setTypeChart("Gauge");
    gau.drawChart();
});

//-----------------------------------------


google.setOnLoadCallback(function() {
   var line = new ChartsPro(); 
    line.createChart({width: 400, height: 240, title: 'Overview'});
    line.setColumn([ {type: 'string', label: 'Time'}, {type: 'number', label: 'CPU'}, {type: 'number', label: 'Network'}, {type: 'number', label: 'RAM'} ]);
    line.setRows(
        [
            ['12.00', 15, 25, 45],
            ['12.30', 25, 45, 48],
            ['13.00', 15, 75, 52],
            ['13.30', 45, 6, 56],
            ['14.00', 85, 10, 62],
            ['14.30', 35, 50, 73],
        ]
    );
    line.setTarget("line_div");
    line.setTypeChart("LineChart");
    line.drawChart();
});


/*
var t = null;
var timer_enabled = 0; 
 
function setTimer(time, enabled, chart) {
    if(!enabled) {
        enabled = 1;
        timedAction(time, chart);
    }
}


function timedAction(time, chart) {
    updateGauge(chart);
    time = setTimeout(timedAction(time), 1000);
}


function updateGauge(chart) {
    //if( $("#gauge_div").is(":visible") ) {
        chart.clearRows();
        chart.setRows([ ['Memory', Math.random()], ['CPU',Math.random()], ['Network',Math.random()] ]);
        chart.drawChart();
    //}
}


function stopTimer() {
    clearTimeout(t);
    time_enabled = 0;
}
*/

/*
 * Function to toggle elements in the left menu
 */
function showHide(type) {
    if(type == "gant"){
        $("#gauge_div").hide("medium");
        $("#line_div").hide("medium");
        $("#chart_div").toggle("slow");
//        stopTimer();
    }else if(type == "gauge") {
        $("#chart_div").hide("medium");
        $("#line_div").hide("medium");
        $("#gauge_div").toggle("slow");
//        setTimer();
    } else {
        $("#chart_div").hide("medium");
        $("#gauge_div").hide("medium");
        $("#line_div").toggle("slow");
    }
    
}

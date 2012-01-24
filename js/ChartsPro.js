function ChartsPro(){
    var options     = null;
    var data        = null;
    var target      = null;
    var columns     = null;
    var chart       = null;
    var type_chart  = null;
    
    this.drawChart = function(){
        methods["drawChart"]();
    }
    this.createChart = function(opt){
        methods["createChart"](opt);
    }
    this.setColumn = function(cols){
        methods["setColumn"](cols);
    }
    this.setRows = function(rows){
        methods["setRows"](rows);
    }
    this.setTarget = function(targ){
        methods["setTarget"](targ);
    }
    this.setTypeChart = function(type){
        methods["setTypeChart"](type);
    }
    
    
    var methods = {
       createChart: function(options_){
           if(!options_) return false;
           options = options_
           data = new google.visualization.DataTable();
           return true;
       },
       drawChart: function(){
           chart = new google.visualization[type_chart](document.getElementById(target));
           chart.draw(data, options);
       },
       setColumn: function(columns){
           $.each(columns, function(ky,col){
               data.addColumn(col.type,col.label);
           });
       },
       setRows: function(rows){
           data.addRows(rows);
       },
       setTarget: function(target_){
           target = target_;
       },
       setTypeChart: function(type_) {
           type_chart = type_;
       }
    };
    
}


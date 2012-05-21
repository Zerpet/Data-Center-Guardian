
/*
 * 
 */
function show_machine(name, responsible, starting) {
    //$('#' + starting);  dialog sobre este elemento
    $dialog.dialog('open');
    console.log("Open!");
    //TODO onClose, poner las coordenadas para X e Y.
    return;
    
    $.post("https://163.117.142.145/pfc/logic/query_machine.php", "name=" + name + "&responsible=" + responsible + "&start=" + starting, 
    function(data) {
        //data is already an object
        
        
        
    }, "json");
    
}

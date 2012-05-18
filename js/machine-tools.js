
/*
 * 
 */
function show_machine(name, responsible, starting) {
    //$('#' + starting);  dialog sobre este elemento
    
    $.post("https://163.117.142.145/pfc/logic/query_machine.php", "name=" + name + "&responsible=" + responsible + "&start=" + starting, 
    function(data) {
        //TODO
    }, "json");
    
}

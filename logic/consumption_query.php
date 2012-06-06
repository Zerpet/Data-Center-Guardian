<?php
//require("./check_if_logged.php");
require '../includes/connect_DB.php';

function query_historical_data($rack) {
    
    $rack = filter_var($rack, FILTER_VALIDATE_INT);
    
    if($rack === FALSE) {
        echo '{ "error" : true, "message" : "RACK id is not a number" }';
        return;
    }
    
    $sql = "SELECT `record_timestamp`, `electric_current` FROM `consumption_record` WHERE `rack` = :rack ORDER BY `record_timestamp`";
    $stm = prepareStatement($sql);
    
    if($stm === FALSE) {
        echo '{ "error" : true, "message" : "Error preparing the statement" }';
        return;
    }
    
    if($stm->execute($_POST) === FALSE) {
        echo '{ "error" : true, "message" : "Error executing query" }';
        return;
    }
    
    $ret = $stm->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($ret);
    
}

//if($_SERVER['REQUEST_METHOD'] !== 'POST') {
//  TODO and check if we are administrator
//}

if(!isset($_POST['rack']))
    return;

query_historical_data($_POST['rack']);

?>

<?php
require 'check_if_logged.php';
require '../includes/connect_DB.php';
include '../includes/machine_class.php';

$filters = array(
    "name" => array 
        (
            "filter" => FILTER_SANITIZE_STRING
        ),
    "responsible" => array 
        (
            "filter" => FILTER_SANITIZE_STRING
        ),
    "start" => array 
        (
            "filter" => FILTER_VALIDATE_INT,
            "options" => array 
                (
                    "min_range" => 1,
                    "max_range" => 42
                )
        ),
);

$post = filter_input_array(INPUT_POST, $filters);

if($post == FALSE) {
    echo "Filter failed in query_machine";
    die(1);
}

if(in_array(FALSE, $post, TRUE) === TRUE) {
    //Send error TODO
    echo "Invalid POST input provided at query_machine";
    die(1);
}

$sql = "";
if($_SESSION['user'] == "administrator") {
    $sql = "SELECT machinename AS name, responsible, os, ip, color, type, notes, starting_pos, num_u, email, office, phone FROM allowed_users A\n"
    . " JOIN (SELECT name AS machinename, responsible, os, ip, color, type, notes, starting_pos, num_u\n"
    . " FROM machine WHERE name = ? AND starting_pos = ?) B\n"
    . " ON (A.name = B.responsible)";
    
} else { 
    $sql = "SELECT name, responsible, os, ip, color, type, notes, starting_pos, num_u, email, office, phone FROM machine A\n"
    . " JOIN (SELECT name AS username, email, office, phone\n"
    . " FROM allowed_users WHERE name = ?) B\n"
    . " ON (A.responsible = B.username)\n"
    . " WHERE name = ?";
}

$stm = $dbh->prepare($sql);
if($_SESSION['user'] == "administrator") 
    $stm->execute(array($post['name'], $post['start']));
else 
    $stm->execute(array($post['responsible'], $post['name']));

$result = $stm->fetch(PDO::FETCH_ASSOC);
if($result === FALSE) {
    //Error
    echo 'Error fetching object at query_machine';
    die(1);
}

$obj = new machine();

$obj->name = $result['name'];
$obj->responsible = $result['responsible'];
$obj->os = $result['os'];
$obj->ip = $result['ip'];
$obj->color = $result['color'];
$obj->type = $result['type'];
$obj->notes = $result['notes'];
$obj->start = $result['starting_pos'];
$obj->us = $result['num_u'];
$obj->email = $result['email'];
$obj->phone = $result['phone'];
$obj->office = $result['office'];

echo json_encode($obj);

?>

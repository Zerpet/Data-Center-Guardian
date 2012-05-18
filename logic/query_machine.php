<?php
require 'check_if_logged.php';
require '../includes/connect_DB.php';

class machine {
    public $name;
    public $responsible;
    public $os;
    public $ip;
    public $color;
    public $type;
    public $notes;
    public $start;
    public $us;
}

//$filters = array(
//    TODO
//);


$sql = "";
if($_SESSION['user'] == "administrator") 
    $sql = "SELECT name, responsible, os, ip, color, type, notes, starting_pos, num_u FROM machine WHERE name=? AND starting_pos=?";
else 
    $sql = "SELECT name, responsible, os, ip, color, type, notes FROM machine WHERE name=? AND responsible=?";

$stm = $dbh->prepare($sql);
if($_SESSION['user'] == "administrator") 
    $stm->execute(array($_POST['name'], $_POST['start']));
else 
    $stm->execute(array($_POST['name'], $_POST['responsible']));

$result = $stm->fetch(PDO::FETCH_ASSOC);
if($result === FALSE) {
    //Error
    echo 'Error fetching object at query_machine';
    die(1);
}

$obj = new machine();
if($_SESSION['user'] == "administrator") {
    $obj->name = $result['name'];
    $obj->responsible = $result['responsible'];
    $obj->os = $result['os'];
    $obj->ip = $result['ip'];
    $obj->color = $result['color'];
    $obj->type = $result['type'];
    $obj->notes = $result['notes'];
    $obj->start = $result['starting_pos'];
    $obj->us = $result['num_u'];
} else {
    $obj->name = $result['name'];
    $obj->responsible = $result['responsible'];
    $obj->os = $result['os'];
    $obj->ip = $result['ip'];
    $obj->color = $result['color'];
    $obj->type = $result['type'];
    $obj->notes = $result['notes'];
    $obj->start = NULL;
    $obj->us = NULL;
}

echo json_encode($obj);

?>

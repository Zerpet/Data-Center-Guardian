<?php
require 'check_if_logged.php';
global $dbh;    
require '../includes/connect_DB.php';

$user = null;
if(isset($_GET['user']))
    $user = $_GET['user'];
else 
    die();

$result = null;
if($user == 'administrator')
    $result = $dbh->query("SELECT position, pos_x, pos_y, phase FROM wardrobe A JOIN phase B ON(A.phase = B.id)")->fetchAll(PDO::FETCH_ASSOC);
else {
    $stm = $dbh->prepare("SELECT wardrobe AS position, pos_x, pos_y, phase FROM (SELECT wardrobe, phase FROM machine A JOIN wardrobe B ON(A.wardrobe = B.position) WHERE responsible=?) C JOIN phase D ON(C.phase=D.id);");
    $stm->execute(array($_GET['user']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
}
$dbh = null;    //Close connection to DB

$xmlDoc = new DOMDocument();
$root = $xmlDoc->appendChild($xmlDoc->createElement("canvas"));

foreach ($result as $connection) {
    
    $connection_tag = $root->appendChild($xmlDoc->createElement("connection"));
    
    $connection_tag->appendChild($xmlDoc->createElement("wardrobe", $connection['position']));
    $phase_tag = $connection_tag->appendChild($xmlDoc->createElement("phase"));
    
    $phase_tag->appendChild($xmlDoc->createElement("x", $connection['pos_x']));
    $phase_tag->appendChild($xmlDoc->createElement("y", $connection['pos_y']));
    $phase_tag->appendChild($xmlDoc->createElement("id", $connection['phase']));
    
}

$xmlDoc->formatOutput = true;
print $xmlDoc->saveXML()
?>

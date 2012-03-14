<?php
global $dbh;    
require '../includes/connect_DB.php';

$result = $dbh->query("SELECT position, pos_x, pos_y FROM wardrobe A JOIN phase B ON(A.phase = B.id)")->fetchAll(PDO::FETCH_ASSOC);
$dbh = null;    //Close connection to DB

$xmlDoc = new DOMDocument();
$root = $xmlDoc->appendChild($xmlDoc->createElement("canvas"));

foreach ($result as $connection) {
    
    $connection_tag = $root->appendChild($xmlDoc->createElement("connection"));
    
    $connection_tag->appendChild($xmlDoc->createElement("wardrobe", $connection['position']));
    $phase_tag = $connection_tag->appendChild($xmlDoc->createElement("phase"));
    
    $phase_tag->appendChild($xmlDoc->createElement("x", $connection['pos_x']));
    $phase_tag->appendChild($xmlDoc->createElement("y", $connection['pos_y']));
    
}

$xmlDoc->formatOutput = true;
print $xmlDoc->saveXML()
?>

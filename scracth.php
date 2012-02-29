<?php

require 'includes/connect_DB.php';

$responsible = $_SESSION['user'];
$responsible = stripslashes($responsible);
$responsible = mysql_escape_string($responsible);
//echo $responsible;
$table_name = "machine";
$sql = "SELECT `wardrobe` FROM `machine` WHERE `responsible` = \'admin\' LIMIT 0, 30 ";

// Shouldnt need sanitazing for SQL Injection
$result = mysql_query($sql);
if ($result === FALSE) {
    echo "Im sexy and I know it";
}
/* $rs = array();
  $i = 0;
  while( $rs[$i++] = mysql_fetch_assoc($result) );

  print_r($rs); */
?>
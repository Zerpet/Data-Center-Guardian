<?php
    
    $host = "localhost"; // Host name
    $username = "web"; // Mysql username
    $password = "2rrPqnJ3nVh7YYcQ"; // Mysql password
    $db_name = "test"; // Database name
    
    $rsc = mysql_connect($host, $username, $password);
    
    if(!$rsc) {
        header('Location: https://localhost/pfc/errorPage.php');
        exit(0);
    }
    
    if(!mysql_select_db($db_name)) {
        header('Location: https://localhost/pfc/errorPage.php');
        exit(0);
    }
    
?>

<?php
    
    $dsn = 'mysql:dbname=test;host=127.0.0.1'; // Host name
    $username = 'web'; // Mysql username
    $password = '2rrPqnJ3nVh7YYcQ'; // Mysql password
    
    $dbh = NULL;
    try {
        $dbh = new PDO($dsn, $username, $password, array(PDO::ATTR_PERSISTENT));
        $dbh->query("SET NAMES utf8");
    } catch (PDOException $e) {
        //header('Location: https://localhost/pfc/errorPage.php');
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }
    
?>

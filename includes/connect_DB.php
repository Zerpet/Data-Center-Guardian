<?php
    
    $dsn = 'mysql:dbname=test;host=127.0.0.1'; // Host name
    $username = 'web'; // Mysql username
    $password = '2rrPqnJ3nVh7YYcQ'; // Mysql password
    
    $dbh = NULL;
    try {
        $dbh = new PDO($dsn, $username, $password);
        $dbh->query("SET NAMES utf8");
    } catch (PDOException $e) {
        //TODO header('Location: https://163.117.142.145/pfc/errorPage.php');
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }
    
    /*
     * Returns a prepared statement object if the server successfully prepares
     * the statement
     */
    function prepareStatement($sql) {
        global $dbh;
        $statement = null;
        try {
            $statement = $dbh->prepare($sql);
        } catch(PDOException $e) {
            $statement = FALSE;
        }
        
        return $statement;
    }
    
    function fastQuery($sql, $class=null) {
        global $dbh;
        $stm = NULL;
        
        if($class !== null) 
            $stm = $dbh->query($sql, PDO::FETCH_CLASS, $class, NULL);
        else
            $stm = $dbh->query($sql);
        
        return $stm->fetchAll();
    }
    
?>

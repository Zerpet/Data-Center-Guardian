<?php 
    session_start(); 
    
    if(!isset($_SESSION['logged']) || $_SESSION['logged'] == FALSE) {
        session_destroy();
        header("Location: https://163.117.142.145/pfc/index.php");
        return;
    }
?>

<?php 
    session_start(); 
    
    if(!isset($_SESSION['logged']) || $_SESSION['logged'] == FALSE) {
        session_destroy();
        header("Location: https://localhost/pfc/index.php");
        return;
    }
?>

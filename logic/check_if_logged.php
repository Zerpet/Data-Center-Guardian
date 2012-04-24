<?php 
    session_start(); 
    
    if(!isset($_SESSION['logged']) || $_SESSION['logged'] == FALSE) {
        session_destroy();
        header("Location: https://163.117.142.145/pfc/index.php");
        return;
    }
    
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minates ago
        session_destroy();   // destroy session data in storage
        session_unset();     // unset $_SESSION variable for the runtime
        header("Location: https://163.117.142.145/pfc/index.php");
        return;
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>

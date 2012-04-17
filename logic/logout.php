<?php
    session_start();
    session_destroy();
    session_unset();
    header("Location: https://163.117.142.145/pfc/index.php");
?>

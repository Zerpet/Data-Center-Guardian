<?php
    if(!isset($_POST["password"]) || !isset($_POST["username"])) {
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/index.php?error=1');
    }
    
    $host = "localhost"; // Host name
    $username = "web"; // Mysql username
    $password = "2rrPqnJ3nVh7YYcQ"; // Mysql password
    $db_name = "test"; // Database name
    $tbl_name = "allowed_users"; // Table name 
    
    if(!mysql_connect($host, $username, $password)) {
        header('Location: https://localhost/pfc/errorPage.php');
        return;
    }
    
    if(!mysql_select_db($db_name)) {
        header('Location: https://localhost/pfc/errorPage.php');
        return;
    }
    
    $user = $_POST["username"];
    $pass = sha1($_POST["password"]);
    
    //To avoid SQL Injection
    $user = stripslashes($user);
    $pass = stripslashes($pass);
    $user = mysql_real_escape_string($user);
    $pass = mysql_real_escape_string($pass);
    
    $sql = "SELECT 'X' FROM $tbl_name WHERE name='$user' and password='$pass'";
    $result = mysql_query($sql);
    
    // Mysql_num_row is counting table row
    $count = mysql_num_rows($result);
    if($count == 1) {
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['logged'] = TRUE;
        //http_redirect("../overview.php", NULL, true, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/overview.php');
    } else {
        
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/index.php?error=1');
    }
?>

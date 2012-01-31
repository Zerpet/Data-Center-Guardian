<?php
    if(!isset($_POST["password"]) || !isset($_POST["username"])) {
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/index.php?error=1');
    }
    
    $host = "localhost"; // Host name
    $username = "root"; // Mysql username
    $password = "5Zerpet6"; // Mysql password
    $db_name = "test"; // Database name
    $tbl_name = "allowed_users"; // Table name 
    
    mysql_connect($host, $username, $password) OR die("Cannot connect");
    mysql_select_db($db_name)or die("Cannot select DB");
    
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
        
        //http_redirect("../overview.php", NULL, true, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/overview.php');
    } else {
        
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/index.php?error=1');
    }
?>

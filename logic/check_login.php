<?php
    if(!isset($_POST["password"]) || !isset($_POST["username"])) {
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://163.117.142.145/pfc/index.php?error=1');
    }
    
    global $dbh;
    require("../includes/connect_DB.php");
    
    $tbl_name = "allowed_users"; // Table name 
    
    $user = $_POST["username"];
    $pass = sha1($_POST["password"]);
    
    $sql = "SELECT 'X' FROM $tbl_name WHERE name=? AND password=?";
    $statement = $dbh->prepare($sql);
    $statement->execute(array($user, $pass));
    $dbh = null; 
    
    $count = $statement->rowCount();
    if($count == 1) {
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['logged'] = TRUE;
        $_SESSION['LAST_ACTIVITY'] = time();
        //http_redirect("../overview.php", NULL, true, HTTP_REDIRECT_PERM);
        header('Location: https://163.117.142.145/pfc/overview.php');
    } else {
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://163.117.142.145/pfc/index.php?error=1');
    }
?>

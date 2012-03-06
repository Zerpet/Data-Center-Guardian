<?php
    if(!isset($_POST["password"]) || !isset($_POST["username"])) {
        //http_redirect("../index.php", array("error" => TRUE), false, HTTP_REDIRECT_PERM);
        header('Location: https://localhost/pfc/index.php?error=1');
    }
    
    require("../includes/connect_DB.php");
    
    $tbl_name = "allowed_users"; // Table name 
    
    $user = $_POST["username"];
    $pass = sha1($_POST["password"]);
    
    $sql = "SELECT 'X' FROM $tbl_name WHERE name=? AND password=?";
    $statement = $dbh->prepare($sql);
    $statement->execute(array($user, $pass));
    
    $count = $statement->rowCount();
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

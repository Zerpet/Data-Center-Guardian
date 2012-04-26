<?php
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged'] === TRUE) {
    header("Location: https://163.117.142.145/pfc/overview.php");
} else {
    session_destroy();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/jquery-1.7.2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/main.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/header_footer.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/loginpage.css" />
    </head>
    <body>
        <?php include("includes/header.php"); ?>
        <div id="login_page">
            <!--<ul class="leftmenu">
                <li id="gant"  onclick="showHide('gant')"></li>
                <li id="gauge" onclick="showHide('gauge')"></li>
                <li id="line" onclick="showHide('line')"></li>
            </ul>-->
            <div id="login_form">
                <form action="https://163.117.142.145/pfc/logic/check_login.php" name="login_form" method="post">
                    Username<br/>
                    <input id="user" type="text" name="username" maxlength="255"/>
                    <br/><br/>
                    Password<br/>
                    <input id="password" type="password" name="password" maxlength="64"/><br/>
                    <input id="submit" class="medium button blue" type="submit" name="submit" value="Login"/>
                </form>
            </div>
            <?php 
                if(isset($_GET["error"]) AND $_GET["error"] == 1) {
            ?>
                    <div id="login_error">
                        User or password incorrect
                    </div>
            <?php } ?>
        </div>
        
        <?php 
            include("includes/footer.php"); 
        ?>
    </body>
</html>

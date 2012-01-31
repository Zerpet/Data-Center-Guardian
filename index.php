<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <script type="text/javascript" src="js/jquery-1.6.3.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/header_footer.css" />
        <link rel="stylesheet" type="text/css" href="css/loginpage.css" />
    </head>
    <body>
        <?php include("header.php"); ?>
        <div id="login_page">
            <!--<ul class="leftmenu">
                <li id="gant"  onclick="showHide('gant')"></li>
                <li id="gauge" onclick="showHide('gauge')"></li>
                <li id="line" onclick="showHide('line')"></li>
            </ul>-->
            <div id="login_form">
                <form action="logic/check_login.php" name="login_form" method="post">
                    Username<br/>
                    <input id="user" type="text" name="username" maxlength="255"/>
                    <br/><br/>
                    Password<br/>
                    <input id="password" type="password" name="password" maxlength="64"/><br/>
                    <input id="submit" class="button" type="submit" name="submit" value="Login"/>
                </form>
            </div>
        </div>
        <?php 
            if(isset($_GET["error"]) AND $_GET["error"] == 1)
                echo "<h1>Epic Fail!</h1>"
        ?>
        
        <?php include("footer.php") ?>
    </body>
</html>

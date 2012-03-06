<?php require("./logic/check_if_logged.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Overview</title>
        <script type="text/javascript" src="js/jquery-1.6.3.js"></script>
        <script type="text/javascript" src="js/canvas_boxes.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/header_footer.css" />
        <link rel="stylesheet" type="text/css" href="css/overview.css" />
    </head>
    <body onload="drawBoxes(); drawLines();">
        <?php include("includes/header.php"); ?>
        <div class="subheader">
            <p>Home</p>
        </div>
        <?php include("includes/leftmenu.php"); ?>
        <div class="content">
            <div style="float: left;">
                <!-- Left side of wardrobes -->
                <?php
                    require 'includes/connect_DB.php';
                    
                    $responsible = $_SESSION['user'];
                    $responsible = stripslashes($responsible);
                    $responsible = mysql_escape_string($responsible);
                    //echo $responsible;
                    $table_name = "machine";
                    $sql = "SELECT `wardrobe` FROM `$table_name` WHERE `responsible` = '$responsible'";
                    
                    $result = mysql_query($sql, $dbh);
                    $rs = array();
                    $i = 0;
                    while( $rs[$i++] = mysql_fetch_assoc($result) );
                    
                    for($i = 0; $i < 6; $i++) {
                        print('<div class="wardrobe">');
                        
                        if(isset($rs[0])) {
                            
                        }
                    }
                    
                ?>
                <div class="wardrobe">
                    <br/>Lab<br/>
                </div>
            </div>
            <div style="float:right;">
                <!-- Right side of wardrobes position: relative; left: 521px; top: -175px-->
                
            </div>
            
                <!--<canvas id="boxes" width="420" height="522">Your browser does not support canvas element</canvas>-->
                
            
        </div>
        <br style="clear: both;" />
        <?php include("includes/footer.php"); ?>
    </body>
</html>

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
                    
                    $sql = '';
                    $stm = null;
                    $rs = null;
                    $value = null;
                    
                    if(!$_SESSION['user'] == 'admin') {
                        
                        $sql = 'SELECT wardrobe FROM machine WHERE responsible=?';  //Get wardrobes where the user has a machine
                        $stm = $dbh->prepare($sql);

                        if(!$stm->execute(array($_SESSION['user']))) {
                            print_r('Error executing query' + $stm->errorInfo());
                            die();
                        }
                        $rs = $stm->fetchAll(PDO::FETCH_NUM);
                        $sql = 'SELECT name, input1, ip1, input2, ip2, input3, ip3 FROM wardrobe WHERE position=?';
                        
                        $value = array(0); //Need to initialize
                        $stm = $dbh->prepare($sql);
                        $stm->bindParam(1, $value[0], PDO::PARAM_INT);
                    
                    } else {
                        $sql = 'SELECT name, input1, ip1, input2, ip2, input3, ip3 FROM wardrobe';
                        $stm = $dbh->prepare($sql);
                        $rs = array(0);
                    }
                    
                    $stm->execute();
//                    print_r($stm->fetchAll(PDO::FETCH_ASSOC));
                    for($i = 1; $i < 7; $i++) {
                        print('<div class="wardrobe">');
                        
                        foreach ($rs as $value) {
                            if($value[0] - 100 == $i || $_SESSION['user'] == 'admin') {
                                
                                $result = $stm->fetch(PDO::FETCH_ASSOC);
                                
                                print('<br/>' . $result['name'] . '<br/>');
                                
                                if($result['input1'] != null) {
                                    print($result['input1'] . ' -> ' . $result['ip1'] . '<br/>');
                                } else break;
                                
                                
                                if($result['input2'] != null) {
                                    print($result['input2'] . ' -> ' . $result['ip2'] . '<br/>');
                                } else break;
                                
                                
                                if($result['input3'] != null) {
                                    print($result['input3'] . ' -> ' . $result['ip3'] . '<br/>');
                                }
                                break;
                            }
                        }
                        print('</div>');
                    }
                    //print_r($stm->fetchAll(PDO::FETCH_ASSOC));
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

<?php require("./logic/check_if_logged.php");//TODO send user here from index if he's logged ?>
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

                $sql = null;
                $stm = null;
                $rs = null;
                
                if ($_SESSION['user'] == 'administrator') {
                    //Here we are administrator
                    $sql = 'SELECT name, iface1, ip1, iface2, ip2, iface3, ip3 FROM wardrobe';
                    $stm = $dbh->prepare($sql);
                    $stm->execute();
                    
                    for ($i = 1; $i < 7; $i++) { //Printing left side
                        $result = $stm->fetch(PDO::FETCH_ASSOC);    //Fetch next wardrobe

                        if ($result['name'] == "unnamed") { //If there are no wardrobe, print it shady
                            print('<div class="disabled_wardrobe">');
                            print('<br/>');
                        } else {
                            print('<div class="wardrobe">');
                            print('<br/>' . $result['name'] . '<br/>');
                        }


                        if ($result['iface1'] != null) {
                            print($result['iface1'] . ' -> ' . $result['ip1'] . '<br/>');
                        }

                        if ($result['iface2'] != null) {
                            print($result['iface2'] . ' -> ' . $result['ip2'] . '<br/>');
                        }

                        if ($result['iface3'] != null) {
                            print($result['iface3'] . ' -> ' . $result['ip3'] . '<br/>');
                        }
                        
                        print('</div>');
                    }
                    
                } else {
                    //Here we are regular user
                    $sql = 'SELECT wardrobe FROM machine WHERE responsible=?';  //Get wardrobes where the user has a machine
                    $stm = $dbh->prepare($sql);
                    $stm->execute(array($_SESSION['user']));
                    $rs = $stm->fetchAll(PDO::FETCH_NUM);   //Save result for later use
                    
                    
                    $sql = 'SELECT name, iface1, ip1, iface2, ip2, iface3, ip3 FROM wardrobe WHERE position=?';
                    $stm = $dbh->prepare($sql);
                    
                    $i = 101;
                    $stm->bindParam(1, $i, PDO::PARAM_INT);
                    
                    for(; $i < 107; $i++) {
                        
                        if(in_array(array($i), $rs)) {   //Has the user a machine in $i wardrobe?
                            $stm->execute();
                            
                            $result = $stm->fetch(PDO::FETCH_ASSOC);    //Then fetch data of that wardrobe
                            
                            if ($result['name'] == "unnamed") {
                                print('<div class="disabled_wardrobe">');
                                print('<br/>');
                            } else {
                                print('<div class="wardrobe">');
                                print('<br/>' . $result['name'] . '<br/>');
                            }
                            
                            if ($result['iface1'] != null) {
                                print($result['iface1'] . ' -> ' . $result['ip1'] . '<br/>');
                            }

                            if ($result['iface2'] != null) {
                                print($result['iface2'] . ' -> ' . $result['ip2'] . '<br/>');
                            }

                            if ($result['iface3'] != null) {
                                print($result['iface3'] . ' -> ' . $result['ip3'] . '<br/>');
                            }

                            print('</div>');
                            
                        } else {    //Otherwise print en empty one
                            print('<div class="wardrobe">');
                            print('</div>');
                        }
                    }
                    
                }
                ?>
            </div>
            <div style="float:right;">
                <!-- Right side of wardrobes position: relative; left: 521px; top: -175px-->
                <?php
                
                if ($_SESSION['user'] == 'administrator') {
                    //Here we are administrator
                    
                    for ($i = 1; $i < 6; $i++) { //Printing left side
                        $result = $stm->fetch(PDO::FETCH_ASSOC);    //Fetch next wardrobe
                        
                        if ($result['name'] == "unnamed") { //If there are no wardrobe, print it shady
                            print('<div class="disabled_wardrobe">');
                            print('<br/>');
                        } else {
                            print('<div class="wardrobe">');
                            print('<br/>' . $result['name'] . '<br/>');
                        }


                        if ($result['iface1'] != null) {
                            print($result['iface1'] . ' -> ' . $result['ip1'] . '<br/>');
                        }

                        if ($result['iface2'] != null) {
                            print($result['iface2'] . ' -> ' . $result['ip2'] . '<br/>');
                        }

                        if ($result['iface3'] != null) {
                            print($result['iface3'] . ' -> ' . $result['ip3'] . '<br/>');
                        }
                        
                        print('</div>');
                    }
                    
                } else {
                    //Here we are regular user
                    
                    for($i = 201; $i < 206; $i++) {
                        
                        if(in_array(array($i), $rs)) {   //Has the user a machine in $i wardrobe?
                            $stm->execute();
                            
                            $result = $stm->fetch(PDO::FETCH_ASSOC);    //Then fetch data of that wardrobe
                            
                            if ($result['name'] == "unnamed") {
                                print('<div class="disabled_wardrobe">');
                                print('<br/>');
                            } else {
                                print('<div class="wardrobe">');
                                print('<br/>' . $result['name'] . '<br/>');
                            }
                            
                            if ($result['iface1'] != null) {
                                print($result['iface1'] . ' -> ' . $result['ip1'] . '<br/>');
                            }

                            if ($result['iface2'] != null) {
                                print($result['iface2'] . ' -> ' . $result['ip2'] . '<br/>');
                            }

                            if ($result['iface3'] != null) {
                                print($result['iface3'] . ' -> ' . $result['ip3'] . '<br/>');
                            }

                            print('</div>');
                            
                        } else {    //Otherwise print en empty one
                            print('<div class="wardrobe">');
                            print('</div>');
                        }
                    }
                    
                }
                
                $dbh = null;
                ?>
            </div>
            <canvas id="boxes" width="420" height="522">Your browser does not support canvas element</canvas>
        </div>
        <br style="clear: both;" />
<?php include("includes/footer.php"); ?>
    </body>
</html>

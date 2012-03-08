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

                if (!$_SESSION['user'] == 'admin') { //If user is not admin, query where he has machines
                    $sql = 'SELECT wardrobe FROM machine WHERE responsible=?';  //Get wardrobes where the user has a machine
                    $stm = $dbh->prepare($sql);

                    if (!$stm->execute(array($_SESSION['user']))) {
                        print_r('Error executing query' + $stm->errorInfo());
                        die();
                    }
                    $rs = $stm->fetchAll(PDO::FETCH_NUM);
                    $sql = 'SELECT name, input1, ip1, input2, ip2, input3, ip3 FROM wardrobe WHERE position=?';

                    $value = array(0); //Need to initialize, later on will query with different value
                    $stm = $dbh->prepare($sql);
                    $stm->bindParam(1, $value[0], PDO::PARAM_INT);
                } else {
                    $sql = 'SELECT name, input1, ip1, input2, ip2, input3, ip3 FROM wardrobe';
                    $stm = $dbh->prepare($sql);
                }

                $stm->execute();



                if ($_SESSION['user'] == 'admin') {
                    for ($i = 1; $i < 7; $i++) { //Printing left side
                        $result = $stm->fetch(PDO::FETCH_ASSOC);    //Fetch next wardrobe

                        if ($result['name'] == "unnamed") { //If there are no wardrobe, print it shady
                            print('<div class="disabled_wardrobe">');
                            print('<br/>');
                        } else {
                            print('<div class="wardrobe">');
                            print('<br/>' . $result['name'] . '<br/>');
                        }


                        if ($result['input1'] != null) {
                            print($result['input1'] . ' -> ' . $result['ip1'] . '<br/>');
                        }

                        if ($result['input2'] != null) {
                            print($result['input2'] . ' -> ' . $result['ip2'] . '<br/>');
                        }

                        if ($result['input3'] != null) {
                            print($result['input3'] . ' -> ' . $result['ip3'] . '<br/>');
                        }
                        
                        print('</div>');
                    }
                } else {
                    for ($i = 1; $i < 7; $i++) {    //We have to print 7 wardrobes
                        
                        foreach ($rs as $value) {   //Iterate the list of wardrobes we have access
                            if ($value[0] - 100 == $i) {    //Can we see this wardrobe?

                                $result = $stm->fetch(PDO::FETCH_ASSOC);    //Then fetch data

                                if ($result['name'] == "unnamed") {
                                    print('<div class="disabled_wardrobe">');
                                    print('<br/>');
                                } else {
                                    print('<div class="wardrobe">');
                                    print('<br/>' . $result['name'] . '<br/>');
                                }


                                if ($result['input1'] != null) {
                                    print($result['input1'] . ' -> ' . $result['ip1'] . '<br/>');
                                }


                                if ($result['input2'] != null) {
                                    print($result['input2'] . ' -> ' . $result['ip2'] . '<br/>');
                                }


                                if ($result['input3'] != null) {
                                    print($result['input3'] . ' -> ' . $result['ip3'] . '<br/>');
                                }

                                print('</div>');

                                break; //Stop iterating the list
                            } else {    //If we can't see it, print an empty one
                                print('<div class="wardrobe">');
                                print('</div>');
                                break;
                            }
                        }
                        
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

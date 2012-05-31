<?php
require("./logic/check_if_logged.php");

function print_wardrobe(array $info, $position) {
    if ($info['name'] == "unnamed") { //If there are no wardrobe, print it shady
        print('<div class="disabled_wardrobe" onclick="add_new_rack(\'' . $position . '\');">');
        print('<br/>');
    } else {
        print('<div class="wardrobe" onclick="show_rac(\'' . $position . '\')">');
        print('<br/>' . $info['name'] . '<br/>');
    }


    if ($info['iface1'] != null) {
        print($info['iface1'] . ' -> ' . $info['ip1'] . '<br/>');
    }

    if ($info['iface2'] != null) {
        print($info['iface2'] . ' -> ' . $info['ip2'] . '<br/>');
    }

    if ($info['iface3'] != null) {
        print($info['iface3'] . ' -> ' . $info['ip3'] . '<br/>');
    }

    print('</div>');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Overview</title>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/jquery-ui-1.8.19.min.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/canvas_boxes.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/filters.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/show_things.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/rack-tools.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/machine-tools.js"></script>
        <script type="text/javascript">
            
        </script>
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/main.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/header_footer.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/overview.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/jquery-ui-1.8.19.cupertino.css" />
    </head>
    <body onload="drawLines(<?php print("'" . $_SESSION['user'] . "'") ?>); drawBoxes();">
<?php include("includes/header.php"); ?>
        <div class="subheader">
            <p>Welcome Home <?php print $_SESSION['user'] ?></p>
        </div>
<?php include("includes/leftmenu.php"); ?>
        <div class="content">
            <div style="float: left;">
                <!-- Left side -->
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
                        print_wardrobe($result, 100 + $i);
                    }
                } else {
                    //Here we are regular user
                    $sql = 'SELECT wardrobe FROM machine WHERE responsible=?';  //Get wardrobes where the user has a machine
                    $stm = $dbh->prepare($sql);
                    $stm->execute(array($_SESSION['user']));
                    $rs = $stm->fetchAll(PDO::FETCH_NUM);   //Save result for later use
                    // Optimize for scalability
                    $sql = 'SELECT name, iface1, ip1, iface2, ip2, iface3, ip3 FROM wardrobe WHERE position=?';
                    $stm = $dbh->prepare($sql);

                    $i = 101;
                    $stm->bindParam(1, $i, PDO::PARAM_INT);

                    for (; $i < 107; $i++) {

                        if (in_array(array($i), $rs)) {   //Has the user a machine in $i wardrobe?
                            $stm->execute();

                            $result = $stm->fetch(PDO::FETCH_ASSOC);    //Then fetch data of that wardrobe
                            print_wardrobe($result, $i);
                        } else {    //Otherwise print en empty one
                            print('<div class="wardrobe">');
                            print('</div>');
                        }
                    }
                }
                ?>
            </div>
            <div id="rac-view" style="display: none;"></div>
            <div style="float:right;">
                <!-- Right side -->
                <?php
                if ($_SESSION['user'] == 'administrator') {
                    //Here we are administrator

                    for ($i = 1; $i < 6; $i++) { //Printing left side
                        $result = $stm->fetch(PDO::FETCH_ASSOC);    //Fetch next wardrobe
                        print_wardrobe($result, 200 + $i);
                    }
                } else {
                    //Here we are regular user

                    for ($i = 201; $i < 206; $i++) {

                        if (in_array(array($i), $rs)) {   //Has the user a machine in $i wardrobe?
                            $stm->execute();

                            $result = $stm->fetch(PDO::FETCH_ASSOC);    //Then fetch data of that wardrobe
                            print_wardrobe($result, $i);
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
        <div id="machine-view" style="display:none;">
            <div id="machine-view-content" class="ui-dialog-content ui-widget-content">
                <ul id="responsible-information">
                    <li style="list-style:disc outside none;"></li>
                    <li class="machine-tabed-li"></li>
                    <li class="machine-tabed-li"></li>
                    <li class="machine-tabed-li"></li>
                </ul>
                <div id="machine-information" class="ui-dialog-content ui-widget-content">
                    <p class="machine-paragraph"></p>
                    <p class="machine-paragraph"></p>
                    <p class="machine-paragraph"></p>
                    <p class="machine-paragraph"></p>
                    <p class="machine-paragraph"></p>
                    <p class="machine-paragraph"></p>
                </div>
                <br style="clear: both;">
                <p class="machine-paragraph machine-notes"></p>

                <div id="chart_div">

                </div>
            </div>
        </div>
        <div id="dialog-form" style="display:none;" title="Machine Form">
            <form method="post" action="logic/machine_edition.php" id="machine-form">
                <label>Name </label><input type="text" value="" name="name" class="machine-paragraph" required="required"><br>

                Responsible <select form="machine-form" name="responsible" class="machine-paragraph">

                </select><br>

                <label>OS </label><input type="text" value="" name="os" class="machine-paragraph" required="required"><br>
                <label>IP </label><input type="text" value="" name="ip" class="machine-paragraph" required="required"><br>

                Color <select form="machine-form" name="color" class="machine-paragraph">
                    <option value="Bright">Bright</option>
                    <option value="Dark">Dark</option>
                </select><br>

                Type <select form="machine-form" name="type" class="machine-paragraph">
                    <option value="UPS">UPS</option>
                    <option value="Switch">Switch</option>
                    <option value="KVM">KVM</option>
                    <option value="Server">Server</option>
                    <option value="Storage Server">Storage Server</option>
                </select><br>

                <label>Notes </label><br>
                <textarea maxlength="255" name="notes" form="machine-form" class="machine-paragraph" onchange="validate_notes(this.value);">

                </textarea><br>
                
                <b>Starts? </b>
                <input type="number" required="required" max="42" min="0" maxlength="2" style="display: inline; width: 1cm;" value="" name="start" class="machine-paragraph"><br>
                <b>Length? </b>
                <input type="number" required="required" max="9" min="1" maxlength="1" style="display: inline; width: 1cm;" value="" name="us" class="machine-paragraph"><br>
                <input type="text" value="" name="old_name" class="machine-paragraph" required="required" style="visibility: hidden;">
                <input type="text" value="" name="old_resp" class="machine-paragraph" required="required" style="visibility: hidden;">
            </form>
        </div>
        <br style="clear: both;" />
<?php include("includes/footer.php"); ?>
    </body>
</html>

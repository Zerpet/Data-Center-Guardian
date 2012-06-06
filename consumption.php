<?php 
require("./logic/check_if_logged.php"); 
require("includes/connect_DB.php");
include "includes/consumptionRecordClass.php";

if($_SESSION['user'] !== "administrator")
    header ("Location: https://163.117.142.145/pfc/overview.php");

$RECORDS = null;

function getLastConsumptionSet() {
    //Infernal select to obtain, for each RACK, the last consumption record
    $sql = "SELECT phase_id, electric_current, rack_id, rack_name, ocupation FROM "
        . "(SELECT cr.rack, cr.electric_current FROM `consumption_record` cr "
            . "JOIN (SELECT rack , max(`record_timestamp`) maximo "
                . "FROM `consumption_record` group by rack) max "
                . "ON (max.maximo = cr.`record_timestamp` and max.`rack` = cr.`rack`) "
        . ") A "
        . "JOIN (SELECT id AS phase_id, group_name, rack_id, C.name AS rack_name, ocupation FROM phase B "
                . "JOIN (SELECT SUM(num_u)/42*100 AS ocupation, position AS rack_id, name, phase FROM wardrobe E "
                    . "JOIN (SELECT wardrobe, num_u FROM machine) F "
                    . "ON (E.position= F.wardrobe) WHERE name != 'unnamed' GROUP BY position "
            . ") C " 
            . "ON (B.id = C.phase) "
        . ") D ON (A.rack = D.rack_id)";
    
    $stm = prepareStatement($sql);
    
    if($stm->execute() === FALSE) {
        //TODO send to error page
        echo "Execution of query failed";
        die();
    }
    
    $result = $stm->fetchAll(PDO::FETCH_CLASS, "consumption_record");
    
    return $result;
}

function postNewRecord() {
//    print_r($_POST);

    //TODO validate input. Check for admin
    $post = $_POST;
//    var_dump($post);
    
    $sql = "INSERT INTO `test`.`consumption_record` (`rack`, `record_timestamp`, `electric_current`) VALUES (:rack, CURRENT_TIMESTAMP, :current);";
    $stm = prepareStatement($sql);
    
    if($stm === FALSE) {
        echo 'Error preparing statement';
        die();
    }
    
    if($stm->execute($post) === FALSE){
        echo 'Error executing query';
        die();
    }
    
}

if($_SERVER['REQUEST_METHOD'] === 'POST') 
    postNewRecord();


$RECORDS = getLastConsumptionSet();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Consumption</title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages':['corechart']});
        </script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/filters.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/show_things.js"></script>
        <script type="text/javascript" src="https://163.117.142.145/pfc/js/consumption-tools.js"></script>
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/main.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/header_footer.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/jquery-ui-1.8.19.cupertino.css" />
        <link rel="stylesheet" type="text/css" href="https://163.117.142.145/pfc/css/consumption.css" />
    </head>
    <body>
        <?php include("includes/header.php"); ?>
        <div class="subheader">
            <p>Consumption</p>
        </div>
        <?php include("includes/leftmenu.php"); ?>
        <div class="content">
            <!-- Left side -->
            <div id="left-phase-container">
                <div class="phase" id="phaseR">
                    <div class="ui-icon ui-icon-circle-plus consumption_add ui-corner-all" onclick="add_new_record();" title="Add new record">Add new record</div>
                    <!-- Title -->
                    <p class="title">Phase R</p>
                    <ol class="record_name">
                        <?php 
                        for($i = 1; $i < 5; $i++) {
                            $found = FALSE;
                            foreach($RECORDS as $r) {
                                if($r->phase_id == $i) {
                                    echo '<li class="phase_entry">' . $r->rack_name .'</li>';
                                    $found = TRUE;
                                    unset($r);
                                    break;
                                }
                            }
                            if(!$found)
                                echo '<li class="phase_entry"></li>';
                        }
                        ?>
<!--                        <li class="phase_entry"></li> 
                        <li class="phase_entry">Scalab</li>-->
                    </ol>
                    <ul class="record_data">
                        <?php 
                        for($i = 1; $i < 5; $i++) {
                            $found = FALSE;
                            foreach($RECORDS as $r) {
                                if($r->phase_id == $i) {
                                    echo '<li class="phase_entry">' . $r->electric_current . ' (' . round($r->ocupation, 2) . '%) <span title="Show historical" onclick="show_historical(\'' . $r->rack_id . '\', \''. $r->rack_name . '\'); ocupationChart(\'' . $r->rack_name . '\', \'' . round($r->ocupation, 2) . '\');" class="ui-icon ui-icon-calculator ui-corner-all historical_button"></span></li>';
                                    $found = TRUE;
                                    unset($r);
                                    break;
                                }
                            }
                            if(!$found)
                                echo '<li class="phase_entry" style="margin-right: 8%;">(%)</li>';
                        }
                        ?>
<!--                        <li>16.0 (%)</li>-->
                    </ul>
                </div>
                <div class="phase" id="phaseT">
                    <div class="ui-icon ui-icon-circle-plus consumption_add ui-corner-all" onclick="add_new_record();" title="Add new record">Add new record</div>
                    <!-- Title -->
                    <p class="title">Phase T</p>
                    <ol class="record_name" start="9">
                        <?php 
                        for($i = 9; $i < 12; $i++) {
                            $found = FALSE;
                            foreach($RECORDS as $r) {
                                if($r->phase_id == $i) {
                                    echo '<li class="phase_entry">' . $r->rack_name . '</li>';
                                    $found = TRUE;
                                    unset($r);
                                    break;
                                }
                            }
                            if(!$found)
                                echo '<li class="phase_entry"></li>';
                        }
                        ?>
<!--                        <li class="phase_entry"></li> 
                        <li class="phase_entry">Scalab</li>-->
                    </ol>
                    <ul class="record_data">
                        <?php 
                        for($i = 9; $i < 12; $i++) {
                            $found = FALSE;
                            foreach($RECORDS as $r) {
                                if($r->phase_id == $i) {
                                    echo '<li class="phase_entry">' . $r->electric_current . ' (' . round($r->ocupation, 2) . '%) <span title="Show historical" onclick="show_historical(\'' . $r->rack_id . '\', \''. $r->rack_name . '\'); ocupationChart(\'' . $r->rack_name . '\', \'' . round($r->ocupation, 2) . '\');" class="ui-icon ui-icon-calculator ui-corner-all historical_button"></span></li>';
                                    $found = TRUE;
                                    unset($r);
                                    break;
                                }
                            }
                            if(!$found)
                                echo '<li class="phase_entry" style="margin-right: 8%;">(%)</li>';
                        }
                        ?>
<!--                        <li>16.0 (%)</li>-->
                    </ul>
                </div>
            </div>
            <!-- Right side -->
            <div id="right-phase-container">
                <div class="phase" id="phaseS">
                    <div class="ui-icon ui-icon-circle-plus consumption_add ui-corner-all" onclick="add_new_record();" title="Add new record">Add new record</div>
                    <!-- Title -->
                    <p class="title">Phase S</p>
                    <ol class="record_name" start="5">
                        <?php 
                        for($i = 5; $i < 9; $i++) {
                            $found = FALSE;
                            foreach($RECORDS as $r) {
                                if($r->phase_id == $i) {
                                    echo '<li class="phase_entry">' . $r->rack_name . '</li>';
                                    $found = TRUE;
                                    unset($r);
                                    break;
                                }
                            }
                            if(!$found)
                                echo '<li class="phase_entry"></li>';
                        }
                        ?>
<!--                        <li class="phase_entry"></li> 
                        <li class="phase_entry">Scalab</li>-->
                    </ol>
                    <ul class="record_data">
                        <?php 
                        for($i = 5; $i < 9; $i++) {
                            $found = FALSE;
                            foreach($RECORDS as $r) {
                                if($r->phase_id == $i) {
                                    echo '<li class="phase_entry">' . $r->electric_current . ' (' . round($r->ocupation, 2) . '%) <span title="Show historical" onclick="show_historical(\'' . $r->rack_id . '\', \''. $r->rack_name . '\'); ocupationChart(\'' . $r->rack_name . '\', \'' . round($r->ocupation, 2) . '\');" class="ui-icon ui-icon-calculator ui-corner-all historical_button"></span></li>';
                                    $found = TRUE;
                                    unset($r);
                                    break;
                                }
                            }
                            if(!$found)
                                echo '<li class="phase_entry" style="margin-right: 8%;">(%)</li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="phase" id="leyend">
                    <p>Leyend</p>
                    <ul>
                        <li>Phase: RACK ...... Electric current (ocupation %)</li>
                    </ul>
                </div>
            </div>
            <h2 id="chart_title">Historical data for RACK _</h2><div id="close_buton" class="ui-icon ui-icon-closethick" onclick="close_chart();"></div>
            <div id="chart_container" class="chart_div">
                
            </div>
            <div id="ocupation_chart" class="chart_div">
                
            </div>
            <br style="clear: both;">
            <div id="form-container" title="Add new record" style="display: none;">
                <form id="record_form" method="post">
                    <label>RACK</label><select form="record_form" name="rack" class="consumption_input">
                        <?php
                        $result = fastQuery("SELECT name, position FROM wardrobe WHERE name != 'unnamed'");
                        foreach($result as $r)
                            print('<option value="' . $r[1] . '">' . $r[0] . '</option>');

                        unset($result);
                        ?>
                    </select><br>
                    <label>Electric current</label>
                    <input type="number" required="required" mix="0" max="99" maxlength="5" value="" name="current" class="consumption_input" /><br>
                </form>
            </div>
        </div>
        
        <?php include("includes/footer.php"); unset($RECORDS); ?>
    </body>
</html>

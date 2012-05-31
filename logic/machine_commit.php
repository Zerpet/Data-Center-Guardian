<?php
require '../includes/connect_DB.php';
require("check_if_logged.php");

function machine_commit() {
    global $dbh;
    
    $filter = array(
        "name"          => array( "filter" => FILTER_SANITIZE_STRING),
        "responsible"   => array( "filter" => FILTER_SANITIZE_STRING),
        "os"            => array( "filter" => FILTER_SANITIZE_STRING),
        "ip"            => array( "filter" => FILTER_VALIDATE_IP),
        "color"         => array( "filter" => FILTER_SANITIZE_STRING),
        "type"          => array( "filter" => FILTER_SANITIZE_STRING),
        "notes"         => array( "filter" => FILTER_SANITIZE_STRING),
        "start"         => array( "filter" => FILTER_VALIDATE_INT, "options" => array("min" => 1, "max" => 42)),
        "us"            => array( "filter" => FILTER_VALIDATE_INT, "options" => array("min" => 1, "max" => 8)),
        "old_name"      => array( "filter" => FILTER_VALIDATE_INT)
    );

    $post = filter_input_array(INPUT_POST, $filter);
    //TODO if post has false
    
    $sql = "INSERT INTO `machine`(`name`, `responsible`, `wardrobe`, `os`, `ip`, "
        . "`color`, `type`, `notes`, `starting_pos`, `num_u`) VALUES (:name, :responsible, "
        . ":old_name, :os, :ip, :color, :type, :notes, :start, :us)";
    
    $stm = $dbh->prepare($sql);
    
    if($stm->execute($post) === TRUE) {
        echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-highlight ui-corner-all"> 
                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-check"></span>
                <strong>Success!</strong> New machine successfully inserted.</p>
                </div>';
    } else {
        echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-error ui-corner-all"> 
                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                <strong>Ops!</strong> We couldn\'t apply changes. Are you overlapping machines maybe?</p>
                </div>';
    }
    
}

function delete_machine() {
    global $dbh;
    
    $filter = array(
        "name"          => array( "filter" => FILTER_SANITIZE_STRING),
        "responsible"   => array( "filter" => FILTER_SANITIZE_STRING)
    );
    
    $post = filter_input_array(INPUT_POST, $filter);
    //TODO if post has false
    
    $sql = "DELETE FROM `machine` WHERE `name` = :name AND `responsible` = :responsible";
    $stm = $dbh->prepare($sql);
    
    if($stm->execute($post) === TRUE) {
        
        if($stm->rowCount() > 0) {
            echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-highlight ui-corner-all"> 
                    <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-check"></span>
                    <strong>Success!</strong> Machine successfully deleted.</p>
                    </div>';
        } else {
            echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-highlight ui-corner-all"> 
                    <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-check"></span>
                    <strong>Caution!</strong> The statement executed successfully but no rows were deleted.</p>
                    </div>';
        }
        
    } else {
        echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-error ui-corner-all"> 
                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                <strong>Ops!</strong> We couldn\'t delete the machine, something went wrong during the SQL execution</p>
                </div>';
    }
    
    
}

if(isset($_POST['action']) && $_POST['action'] == 'delete')
    delete_machine();
else
    machine_commit();

?>

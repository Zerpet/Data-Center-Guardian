<?php
require 'check_if_logged.php';
require '../includes/connect_DB.php';
include '../includes/filter_functions.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        
        $sql = "SELECT name FROM allowed_users";

        $stm = $dbh->query($sql);

        if ($stm === FALSE) {
            echo 'Error in query at machine_edition';
            die();
        }

        $candidates = $stm->fetchAll(PDO::FETCH_COLUMN);

        $stm = null;
        $dbh = null;

        echo json_encode($candidates);
        break;
    
    case 'POST':
        //TODO Check if administrator
        $filter = array(
            "name" => array( "filter" => FILTER_SANITIZE_STRING),
            "responsible" => array( "filter" => FILTER_SANITIZE_STRING),
            "os" => array( "filter" => FILTER_SANITIZE_STRING),
            "ip" => array ( "filter" => FILTER_VALIDATE_IP),
            "color" => array( "filter" => FILTER_SANITIZE_STRING),
            "type" => array( "filter" => FILTER_SANITIZE_STRING),
            "notes" => array( "filter" => FILTER_SANITIZE_STRING),
            "start" => array( "filter" => FILTER_VALIDATE_INT, "options" => array("min" => 1, "max" => 42)),
            "us" => array( "filter" => FILTER_VALIDATE_INT, "options" => array("min" => 1, "max" => 8)),
            "old_name" => array( "filter" => FILTER_SANITIZE_STRING),
            "old_resp" => array( "filter" => FILTER_SANITIZE_STRING)
        );
        
        $post = filter_input_array(INPUT_POST, $filter);
        
        //TODO if $post has any FALSE, ui-state-error Is the input correct?
        $sql = "UPDATE machine SET name = :name, responsible = :responsible, os = :os, ip = :ip, color = :color, type = :type, "
            . "notes = :notes, starting_pos = :start, num_u = :us "
            . "WHERE name = :old_name AND responsible = :old_resp";
        
        $stm = $dbh->prepare($sql);
        if($stm->execute($post) === TRUE) {
            echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-highlight ui-corner-all"> 
                    <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-check"></span>
                    <strong>Success!</strong> Changes has been successfully applied.</p>
                  </div>';
        } else {
            echo '<div id="machine-commit-state" style="margin-top: 20px; margin-left: 5%; padding: 0 .7em;" class="ui-state-error ui-corner-all"> 
                    <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                    <strong>Ops!</strong> We couldn\'t apply changes. Are you overlapping machines maybe?</p>
                  </div>';
        }
        
        break;
}


?>
<?php
require 'check_if_logged.php';
require '../includes/connect_DB.php';

/*
 * Get wardrobes information
 * Get machines in that wardrobe where USER is responsible
 * Print full schema
 * Print wardrobe information
 */

if(!isset($_POST['wardrobe'])) {
    //Error
    echo 'No POST variable set';
    die();
}

$stm = $dbh->prepare("SELECT name, iface1, iface2, iface3, ip1, ip2, ip3 FROM wardrobe WHERE position=?");
$stm->execute(array($_POST['wardrobe']));

$result = $stm->fetch(PDO::FETCH_ASSOC);
if($result === FALSE) {
    //Error
    echo 'Error fetching object';
    die(1);
}


$stm = $dbh->prepare("SELECT name, color, starting_pos, num_u FROM machine WHERE responsible=? AND wardrobe=?");
$stm->execute(array($_SESSION['user'], $_POST['wardrobe']));

$schema = $stm->fetchAll(PDO::FETCH_ASSOC);
if($schema === FALSE) {
    //Error
    echo 'Error fetching all';
    die(1);
}


unset($stm);
$dbh = NULL;
?>


<p id="war-title"><?php echo $result['name'] ?></p>
<div style="float: left;">
    <table id="wardrobe-schema">
        <tbody>
            <?php
            for($i = 42; $i > 0; $i--) {    //Error checking about overlaped/overflowed/underflowed machines must be done in MySQL
                print("<tr>");

                $found = FALSE;
                foreach ($schema as $machine) {
                    if($machine['starting_pos'] == $i) {
                        $tmp = 20 * $machine['num_u'];
                        print('<td class="' . $machine['color'] . '-machine" style="height: ' . $tmp . 'px">' . $machine['name'] . '</td>');
                        $found = TRUE;
                        break;
                    }
                }

                if(!$found)
                    print("<td class=\"gap\" style=\"height: 20px\"></td>");

                print("</tr>");
            }
            ?>
        </tbody>
    </table>
</div>
<div id="wardrobe-info">
    <ul style="margin-bottom: 20px;">
        <?php 
        if($result['iface1'] !== NULL)
            echo "<li>" . $result['iface1'] . "->" . $result['ip1'] . "</li>";

        if($result['iface2'] !== NULL)
            echo "<li>" . $result['iface2'] . "->" . $result['ip2'] . "</li>";

        if($result['iface3'] !== NULL)
            echo "<li>" . $result['iface3'] . "->" . $result['ip3'] . "</li>";

        unset($result);
        ?>
    </ul>
    <button class="medium button marine" type="button" name="add" onclick="alert('Not implemented yet!');">Add Machine</button>
    <button class="medium button marine" type="button" name="edit" onclick="alert('Not implemented yet!');">Edit Wardrobe</button>
    <button class="medium button marine" type="button" name="back" onclick="hide_view();">Hide this view</button>
</div>
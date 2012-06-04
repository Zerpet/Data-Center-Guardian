<?php
require 'check_if_logged.php';
require '../includes/connect_DB.php';

/*
 * Get wardrobes information
 * Get machines in that wardrobe where USER is responsible
 * Print full schema
 * Print wardrobe information
 */

if(!isset($_POST['rac'])) {
    //Error TODO error page
    echo 'No POST variable set';
    die();
}

$post = filter_var($_POST['rac'], FILTER_VALIDATE_INT);

if($post === FALSE) {
    //TODO send to error frame
    echo 'Invalid input POST';
    die();
}

//Query RACK information
$stm = $dbh->prepare("SELECT name, iface1, iface2, iface3, ip1, ip2, ip3 FROM wardrobe WHERE position=?");
$stm->execute(array($post));

$result = $stm->fetch(PDO::FETCH_ASSOC);
if($result === FALSE) {
    //Error
    echo 'Error fetching object';
    die(1);
}

//Query machines information
if($_SESSION['user'] == "administrator") {
    $stm = $dbh->prepare("SELECT name, color, starting_pos, num_u FROM machine WHERE wardrobe=?");
    $stm->execute(array($post));
} else {
    $stm = $dbh->prepare("SELECT name, color, starting_pos, num_u FROM machine WHERE responsible=? AND wardrobe=?");
    $stm->execute(array($_SESSION['user'], $post));
}


$schema = $stm->fetchAll(PDO::FETCH_ASSOC);
if($schema === FALSE) {
    //Error
    echo 'Error fetching all';
    die(1);
}


unset($stm);
$dbh = NULL;
?>

<div class="ui-icon ui-icon-close close_button" onclick="hide_view('rac-view', 'boxes');"></div>
<p id="war-title"><?php echo $result['name'] ?></p>
<div style="float: left; width: 50%;">
    
    <table id="rac-schema">
        <tbody>
            <?php
            $lastgaps = 0;
            for($i = 42; $i > 0; $i--) {    //Error checking about overlaped/overflowed/underflowed machines must be done in MySQL
                
                $found = FALSE;
                $avoid = FALSE;
                
                foreach ($schema as $machine) {
                    
                    for($a = 1; $a < $machine['num_u']; $a++)   //We need this check to avoid painting slots occupied by multiple U machines
                        if($machine['starting_pos'] + $machine['num_u'] - $a === $i)
                            $avoid = TRUE;
                    
                    if($machine['starting_pos'] == $i) {
                        $tmp = 20 * $machine['num_u'];
                        
                        print("<tr>");
                        print('<td style="height: ' . $tmp . 'px">' . $i . '</td>');
                        print('<td id="' . $i . '" class="' . $machine['color'] . '-machine" style="height: ' . $tmp . 'px" onclick="open_machine_dialog(\'' . $machine['name'] . '\', \'' . $_SESSION['user'] .'\', \'' . $i .'\');">' . $machine['name'] . '</td>');
                        print("</tr>");
                        
                        $found = TRUE;
                        $lastgaps = 0;
                        break;
                    }
                }
                
                if($avoid === TRUE)
                    continue;
                
                if(!$found) {
                    //We only print a gap for every 10 positions. Later on this could be expanded using a button
                    if($lastgaps++ % 10 == 0) {
                        print("<tr>");
                        print('<td style="width: 20px">' . $i . '</td>');
                        print("<td class=\"gap\" style=\"height: 20px\"></td>");
                        print("</tr>");
                    } else {
                        print("<tr class=\"compact\" style=\" display: none;\">");
                        print('<td style="height: 20px">' . $i . '</td>');
                        print("<td class=\"gap\" style=\"height: 20px;\"></td>");
                        print("</tr>");
                    }
                }
                
            }
            unset($lastgaps);
            ?>
        </tbody>
    </table>
</div>

<div id="rac-info">
    <h2>Network</h2>
    <i>Interface -> Subnet</i>
    <ul id="rac-iface" style="margin-bottom: 20px;">
        <?php 
        if($result['iface1'] !== NULL)
            echo "<li>" . $result['iface1'] . " -> " . $result['ip1'] . "</li>";

        if($result['iface2'] !== NULL)
            echo "<li>" . $result['iface2'] . " -> " . $result['ip2'] . "</li>";

        if($result['iface3'] !== NULL)
            echo "<li>" . $result['iface3'] . " -> " . $result['ip3'] . "</li>";

        unset($result);
        ?>
    </ul>
    
    <?php if($_SESSION['user'] == "administrator") { ?>
    <button id="add_machine" class="medium button marine" type="button" name="add" onclick="add_new_machine(<?php echo '\'' . $post . '\'' ?>);">Add Machine</button>
    <button id="edit_rack" class="medium button marine" type="button" name="edit" onclick="edit_rack();">Edit RACK</button>
    <?php } ?>
    
    <button class="medium button marine" type="button" name="expand" onclick="expand_compact_rac();">Expand RACK</button>
    <?php if($_SESSION['user'] == "administrator") { ?>
    <button class="medium button red" type="button" name="delete" onclick="delete_rack('<?php echo $_POST['rac'] ?>');">Delete this RACK</button>
    <?php } ?>
</div>
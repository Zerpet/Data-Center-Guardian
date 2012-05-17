<?php
if(isset($_POST['rack']) === FALSE) {
    //TODO goto error frame
    echo "No post request to this page";
    return;
}
?>

<input id="war-title" style="margin-left: 15%;" type="text" name="rack-title" value="Unnamed" />
<div style="float: left;">
    <table id="rac-schema">
        <tbody>
            <?php
            for($i = 42; $i > 0; $i -= 10) {    //Error checking about overlaped/overflowed/underflowed machines must be done in MySQL
                print("<tr>");
                print('<td style="width: 20px">' . $i . '</td>');
                print("<td class=\"gap\" style=\"height: 20px\"></td>");
                print("</tr>");
            }
            ?>
        </tbody>
    </table>
</div>

<div id="rac-info">
    <h2>Network</h2>
    
    Interface -> IP<br>
    <input type="number" name="iface1" style="width: 40px;" /> 
    -> <input type="number" name="ip1" style="width: 40px;" /> <br>
    <input type="number" name="iface2" style="width: 40px;" /> 
    -> <input type="number" name="ip2" style="width: 40px;" /> <br>
    <input type="number" name="iface3" style="width: 40px;" /> 
    -> <input type="number" name="ip3" style="width: 40px;" /> <br>
    <p>Connected to 
    <select id="phases" name="connected">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
    </select>
    </p>
    <!-- <?php echo $_POST['rack'] ?> -->
    <button id="save_rack" class="medium button marine" type="submit" name="rack" onclick="commit_rack()">Save RACK</button>
    <button id="discard_rack" class="medium button marine" type="button" name="discard" onclick="hide_view('rac-view', 'boxes')">Discard RACK</button>

</div>
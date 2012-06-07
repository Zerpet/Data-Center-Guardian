<div class="leftmenu">
    <a href="https://163.117.142.145/pfc/overview.php"><button class="medium button blue" name="overview" type="button" value="Overview">Overview</button></a>
    <!--a href="https://163.117.142.145/pfc/usermanagement.php"><button class="medium button blue" name="usermanagement" type="button" value="UserManagement">User Management</button></a-->
    <?php if($_SESSION['user'] === "administrator"){ ?>
    <a href="https://163.117.142.145/pfc/consumption.php"><button class="medium button blue" name="consumption" type="button" value="Consumption">Consumption</button></a>
    <?php } ?>
    <a href="https://163.117.142.145/pfc/static/User_Manual.pdf"><button class="medium button blue" name="usermanual" type="button" value="usermanual">User Manual</button></a>
    <a href="https://163.117.142.145/pfc/logic/logout.php"><button class="medium button blue" name="logout" type="button" value="Logout" onclick="logout()">Logout</button></a>
</div>
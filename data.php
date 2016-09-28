<?php
require ("functions.php");
//kas on sisseloginud, kui ei ole siis
//suunata login lehele

//kas ?logout on aadressireal
if (isset($_GET['logout'])){
    session_destroy();
    header("Location: login.php");
}

if (!isset ($_SESSION["userId"])){
    header("Location: login.php");
}

?>


<html>

<style>
    @import "styles.css";
</style>



<table class="table1"">
    <tr>
        <td><h1>Data</h1></td>
    </tr>
    <tr>
        <td>
            <table class="table2">
                <tr>
                    <td colspan="3"">Tere tulemast <?=$_SESSION['email'];?>!</td>
                </tr>
                <tr>
                    <td colspan="3"><a href="?logout=1">Logi välja</a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</html>
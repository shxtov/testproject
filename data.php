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
    * {font-family: "Calibri Light"; vertical-align:top; font-size:14px;margin:auto; padding:auto;}
    h1 {font-size: 30px; font-weight: bolder}
    .redtext {color:#f00b0b; font-weight: bolder}
    .table1  {border-collapse:collapse;border-spacing:0}
    .table1 td{padding:5px;border-style:none;overflow:hidden;word-break:normal}

</style>



<table class="table1" style="border-style: solid">
    <tr>
        <td style="text-align:center"><h1>Data</h1></td>
    </tr>
    <tr>
        <td>
            <table class="table1">
                <tr>
                    <td></td>
                    <td>Tere tulemast <?=$_SESSION['email'];?>!</td>
                    <td</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align:center"><a href="?logout=1">Logi välja</a></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</html>
<?php
// MVP idee - autotöökoda veebileht. Kaks kasutajat - klient ja töökoda administraator.
// Esimene avaldab soove veebivormi kaudu, täidab informatsiooni endast (nimi, kontakt),sõidukist (mudel, mootor)
// ning valib, milliseid teenuseid soovib (checkboxidega, näiteks). Programm siis arvutab, palju umbes aega selle jaoks vaja on
// hiljem administraator pakub täpsemat aega kliendile ja, kui kõik soovib, määrab töökoda ja meistrit.
// lisada võib ka  näiteks kliendikaarte/boonuspunkte, võimalust vaadata statistikat jne.

$loginEmailError ="";
$loginPasswordError='';
$loginNotice = "";


//võtab ja kopeerib faili sisu
require ("../../config.php");
require ("functions.php");

if (isset ($_SESSION["userId"])){
    header("Location: data.php");
}


if(isset($_POST["loginEmail"]) && isset($_POST['loginPassword']) && !empty($_POST["loginEmail"]) && !empty($_POST['loginPassword'])){
    $loginNotice = login($_POST["loginEmail"], $_POST['loginPassword']);
}

if (isset($_POST['loginEmail'])){
    if (empty($_POST['loginEmail'])){
        $loginEmailError = "See väli on kohustuslik!";
    }
}


if (isset($_POST['loginPassword'])){
    if (empty($_POST['loginPassword'])){
        $loginPasswordError = "See väli on kohustuslik!";
    }
}


?>



<html>
<style>
    * {font-family: "Calibri Light"; vertical-align:top; font-size:14px;margin:auto}
    h1 {font-size: 30px; font-weight: bolder}
    .redtext {color:#f00b0b; font-weight: bolder}
    .table1  {border-collapse:collapse;border-spacing:0;}
    .table1 td{padding:5px;border-style:none;overflow:hidden;word-break:normal}
</style>

<head>
    <title>Sisselogimise lehekülg</title>
</head>

<body>



<form method ="post">

    <table class="table1" style="border-style: solid">
        <tr>
            <td style="text-align:center"><h1>Logi sisse</h1></td>
        </tr>
        <tr>
            <td style="text-align:center"><a href="register.php">Pole kasutajat? Suuna registreerimise lehele...</a></td>
        </tr>
        <tr>
            <td>
            <table class="table1">
                <tr>
                    <td>E-post:<span class = 'redtext'>*</span></td>
                    <td><input name = "loginEmail" type ="email" placeholder = "E-post"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="redtext"><?=$loginEmailError;?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Parool:<span class = 'redtext'>*</span></td>
                    <td><input name = "loginPassword" type ="password" placeholder = "Parool"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="redtext"><?=$loginPasswordError;?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type ="submit" value = "Submit"></td>
                    <td><p class = "redtext"><?=$loginNotice;?></p></td>
                    <td></td>
            </table>
            </td>
        </tr>
    </table>




</form>



</body>
</html>
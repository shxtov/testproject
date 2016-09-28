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
        $loginEmailError = "E-mail on kohustuslik!";
    }
}


if (isset($_POST['loginPassword'])){
    if (empty($_POST['loginPassword'])){
        $loginPasswordError = "Parool on kohustuslik!";
    }
}


?>



<html>
<style>
    @import "styles.css";
</style>

<head>
    <title>Sisselogimise lehekülg</title>
</head>

<body>



<form method ="post">

    <table class="table1">
        <tr>
            <td><h1>Logi sisse</h1></td>
        </tr>
        <tr>
            <td>
            <table class="table2">
                <tr>
                    <td>E-post:<span class = 'redtext'>*</span></td>
                    <td colspan="2"  style="text-align:left"><input name = "loginEmail" type ="email" placeholder = "E-post"></td>
                </tr>
                <tr>
                    <td colspan="3"><p class = "redtext"><?=$loginEmailError;?></p></td>
                </tr>
                <tr>
                    <td>Parool:<span class = 'redtext'>*</span></td>
                    <td colspan="2"style="text-align:left"><input name = "loginPassword" type ="password" placeholder = "Parool"></td>
                </tr>
                <tr>
                    <td colspan="3"><p class = "redtext"><?=$loginPasswordError;?></p></td>
                </tr>
                <tr>
                    <td colspan="3" ><input type ="submit" value = "Logi sisse"></td>
                </tr>
                <tr>
                    <td colspan="3"><p class = "redtext"><?=$loginNotice;?></p></td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td><a href="register.php">Pole kasutajat?..</a></td>
        </tr>
    </table>




</form>



</body>
</html>
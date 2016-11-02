<?php
// MVP idee - autotöökoda veebileht. Kaks kasutajat - klient ja töökoda administraator.
// Esimene avaldab soove veebivormi kaudu, täidab informatsiooni endast (nimi, kontakt),sõidukist (mudel, mootor)
// ning valib, milliseid teenuseid soovib (checkboxidega, näiteks). Programm siis arvutab, palju umbes aega selle jaoks vaja on
// hiljem administraator pakub täpsemat aega kliendile ja, kui kõik soovib, määrab töökoda ja meistrit.
// lisada võib ka  näiteks kliendikaarte/boonuspunkte, võimalust vaadata statistikat jne.


$loginEmail = "";
$loginEmailError ="";
$loginPasswordError='';
$loginNotice = "";


//võtab ja kopeerib faili sisu
require ("functions.php");

if (isset ($_SESSION["userId"])){
    header("Location: data.php");
}


if(isset($_POST["loginEmail"]) && isset($_POST['loginPassword']) && !empty($_POST["loginEmail"]) && !empty($_POST['loginPassword'])){
    $loginNotice = $Users->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST['loginPassword']));
}



if (isset ($_POST ["loginEmail"])){

    if (empty ($_POST ["loginEmail"])){
        $loginEmailError = "Please enter your e-mail!";
    } else {
        $loginEmail = $_POST["loginEmail"];
    }
}



if (isset($_POST['loginPassword'])){
    if (empty($_POST['loginPassword'])){
        $loginPasswordError = "Please enter your password!";
    }
}


?>



<html>
<style>
    @import "styles.css";
</style>

<head>
    <title>Log in page</title>
</head>

<body>



<form method ="post">

    <table class="table1">
        <tr>
            <td style="text-align:center"><h1>Log in:</h1></td>
        </tr>
        <tr>
            <td>
            <table class="table2">
                <tr>
                    <td>E-mail:<span class = 'redtext'>*</span></td>
                    <td colspan="2"  style="text-align:left"><input name = "loginEmail" type ="email" value="<?=$loginEmail;?>"></td>
                </tr>
                <tr>
                    <td colspan="3"  style="text-align:center"><p class = "redtext"><?=$loginEmailError;?></p></td>
                </tr>
                <tr>
                    <td>Password:<span class = 'redtext'>*</span></td>
                    <td colspan="2"style="text-align:left"><input name = "loginPassword" type ="password"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center"><p class = "redtext"><?=$loginPasswordError;?></p></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center"><input type ="submit" value = "Submit"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center"><p class = "redtext"><?=$loginNotice;?></p></td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center"><a href="register.php">Don't have an account?..</a></td>
        </tr>
    </table>




</form>



</body>
</html>
<?php
// MVP idee - autotöökoda veebileht. Kaks kasutajat - klient ja töökoda administraator.
// Esimene avaldab soove veebivormi kaudu, täidab informatsiooni endast (nimi, kontakt),sõidukist (mudel, mootor)
// ning valib, milliseid teenuseid soovib (checkboxidega, näiteks). Programm siis arvutab, palju umbes aega selle jaoks vaja on
// hiljem administraator pakub täpsemat aega kliendile ja, kui kõik soovib, määrab töökoda ja meistrit.
// lisada võib ka  näiteks kliendikaarte/boonuspunkte, võimalust vaadata statistikat jne.


//võtab ja kopeerib faili sisu
require ("../../config.php");
require ("functions.php");


if (isset ($_SESSION["userId"])){
    header("Location: data.php");
}

//var_dump($_POST);

$signupEmailError = "";
$signupPasswordError = "";
$signupBdayError = "";
$signupCarPrefError ="";
$signupEmail = "";
$signupBday = "1995-02-25";
$signupGender = "male";
$signupCarPref_items = [];
$signupNotice = "";




// kas epost oli olemas
if (isset ($_POST ["signupEmail"])){

    if (empty ($_POST ["signupEmail"])){

        //oli email, kuigi see oli tühi
        $signupEmailError = "E-mail on kohustuslik!";

    } else {

        //email on õige, salvestan väärtuse muutujasse
        $signupEmail = $_POST["signupEmail"];

    }

}

if (isset ($_POST ["signupBday"])){

    if (empty ($_POST ["signupBday"])){

        // if bday wasnt set
        $signupBdayError = "Sünnipäev on kohustuslik!";

    }else{
        $signupBday = $_POST["signupBday"];
    }

}



if (isset ($_POST ["signupPassword"])){

    if (empty ($_POST ["signupPassword"])){

        //oli password, kuigi see oli tühi
        $signupPasswordError = "Parool on kohustuslik!";

    }else{
        // tean et oli parool ja see ei olnud tühi
        // vähemalt 8 sümbolit

        if (strlen($_POST["signupPassword"])< 8){
            $signupPasswordError = "Parool peab olema >8 tähemärki!";
        }


    }

}


if (isset ($_POST['signupGender'])){
    $signupGender = $_POST["signupGender"];
}


if (isset($_POST['signupCarPref_items'])){
    if (!in_array("eucars", $_POST['signupCarPref_items']) &&
        !in_array("uscars",$_POST['signupCarPref_items']) &&
        !in_array("japcars",$_POST['signupCarPref_items']) &&
        !in_array("ruscars",$_POST['signupCarPref_items']) &&
        !in_array("korcars",$_POST['signupCarPref_items'])){
        $signupCarPrefError = 'Vali vähemalt üks valik!';
    } else {
        $signupCarPref_items = $_POST["signupCarPref_items"];
    }


}



// tean et ühtegi viga ei olnud ja saan &&med salvestatud
if (empty ($signupEmailError)&& empty($signupPasswordError) && empty($signupCarPrefError)
    && empty($signupBdayError) &&  isset ($_POST['signupPassword'])
    && isset ($_POST['signupEmail']) && isset ($_POST['signupBday'])
    && isset ($_POST['signupGender']) && !empty ($_POST['signupCarPref_items'])){

    
    $signupCarPref_todatabase = implode ($_POST['signupCarPref_items'], " ");
    $password = hash("sha512", $_POST["signupPassword"]);


    $signupNotice = signup($signupEmail, $password, $signupBday, $signupGender, $signupCarPref_todatabase);
}


?>



<html>
<style>
    @import "styles.css";
</style>

<head>
    <title>Registreerimise lehekülg</title>
</head>

<body>




<form method ="post">


    <table class="table1">
        <tr>
            <td><h1>Registreeri</h1></td>
        </tr>
        <tr>
            <td>
    <table class="table2">
        <tr>
            <td style="width: 70px">E-post:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left"><input name = "signupEmail" type ="email" value = "<?=$signupEmail;?>" placeholder = "E-post"></td>
        </tr>
        <tr>
            <td colspan="3"><p class = "redtext"><?=$signupEmailError;?></p></td>
        </tr>
        <tr>
            <td style="width: 70px">Parool:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left"><input name = "signupPassword" type ="password" placeholder = "Parool"></td>
        </tr>
        <tr>
            <td colspan="3"><p class = "redtext"><?=$signupPasswordError;?></p></td>
        </tr>
        <tr>
            <td style="width: 70px">Sünnipäev:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left"><input name="signupBday" type ="date" min="1900-01-01" max = "<?=date('Y-m-d'); ?>" placeholder="YYYY-MM-DD"></td>
        </tr>
        <tr>
            <td colspan="3"><p class = "redtext"><?=$signupBdayError;?></p></td>
        </tr>
        <tr>
            <td style="width: 70px">Sugu:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left">
                <?php if($signupGender == "male") { ?>
                    <label><input type="radio" name="signupGender" value="male" checked> Mees</label><br>
                <?php } else { ?>
                    <label><input type="radio" name="signupGender" value="male"> Mees</label><br>
                <?php } ?>

                <?php if($signupGender ==  "female") { ?>
                    <label><input type="radio" name="signupGender" value="female" checked> Naine</label><br>
                <?php } else { ?>
                    <label><input type="radio" name="signupGender" value="female"> Naine</label><br>
                <?php } ?>

                <?php if($signupGender ==  "unspecified") { ?>
                    <label><input type="radio" name="signupGender" value="unspecified" checked> Ei soovi avaldada</label><br>
                <?php } else {?>
                    <label><input type="radio" name="signupGender" value="unspecified"> Ei soovi avaldada</label><br>
                <?php } ?>

        </tr>
        <tr>
            <td style="width: 70px">Autohuvid:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left; height:40px">
                <input type="hidden" name="signupCarPref_items[]"  value="">

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("eucars", $_POST['signupCarPref_items'])){?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="eucars" checked> Euroopa autod</label><br>
                <?php } else { ?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="eucars"> Euroopa autod</label><br>
                <?php } ?>

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("uscars", $_POST['signupCarPref_items'])){?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="uscars" checked> Ameerika autod</label><br>
                <?php } else { ?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="uscars"> Ameerika autod</label><br>
                <?php } ?>

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("japcars", $_POST['signupCarPref_items'])){?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="japcars" checked>Jaapani autod</label><br>
                <?php } else { ?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="japcars"> Jaapani autod</label><br>
                <?php } ?>

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("ruscars", $_POST['signupCarPref_items'])){?>
                <label><input type="checkbox" name="signupCarPref_items[]" value="ruscars" checked> Vene autod</label><brc>
                    <?php } else { ?>
                        <label><input type="checkbox" name="signupCarPref_items[]" value="ruscars"> Vene autod</label><br>
                    <?php } ?>

                    <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("korcars", $_POST['signupCarPref_items'])){?>
                        <label><input type="checkbox" name="signupCarPref_items[]" value="korcars" checked> Korea autod</label><br>
                    <?php } else { ?>
                        <label><input type="checkbox" name="signupCarPref_items[]" value="korcars">  Korea autod</label><br>
                    <?php } ?>
        </tr>
        <tr>
            <td colspan="3"><p class = "redtext"><?=$signupCarPrefError;?></p></td>
        </tr>
        <tr>
            <td colspan="3" ><input type ="submit" value = "Registreeri"></td>
        </tr>
        <tr>
            <td colspan="3"><p class = "redtext"><?=$signupNotice;?></p></td>
        </tr>
    </table>
        </td>
        </tr>
        <tr>
            <td><a href="login.php">Kasutaja olemas?..</a></td>
        </tr>
        </table>
</form>

</body>
</html>
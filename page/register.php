<?php
// MVP idee - autotöökoda veebileht. Kaks kasutajat - klient ja töökoda administraator.
// Esimene avaldab soove veebivormi kaudu, täidab informatsiooni endast (nimi, kontakt),sõidukist (mudel, mootor)
// ning valib, milliseid teenuseid soovib (checkboxidega, näiteks). Programm siis arvutab, palju umbes aega selle jaoks vaja on
// hiljem administraator pakub täpsemat aega kliendile ja, kui kõik soovib, määrab töökoda ja meistrit.
// lisada võib ka  näiteks kliendikaarte/boonuspunkte, võimalust vaadata statistikat jne.


//võtab ja kopeerib faili sisu
require ("../functions.php");


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
        $signupEmailError = "Please enter your e-mail!";

    } else {

        //email on õige, salvestan väärtuse muutujasse
        $signupEmail = $_POST["signupEmail"];

    }

}

if (isset ($_POST ["signupBday"])){

    if (empty ($_POST ["signupBday"])){

        // if bday wasnt set
        $signupBdayError = "Please enter your birthday!";

    }else{
        $signupBday = $_POST["signupBday"];
    }

}



if (isset ($_POST ["signupPassword"])){

    if (empty ($_POST ["signupPassword"])){

        //oli password, kuigi see oli tühi
        $signupPasswordError = "Please enter a password!";

    }else{
        // tean et oli parool ja see ei olnud tühi
        // vähemalt 8 sümbolit

        if (strlen($_POST["signupPassword"])< 8){
            $signupPasswordError = "Password must be >8 symbols!";
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
        $signupCarPrefError = 'Please choose atleast one!';
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


    $signupNotice = $Users->signup($Helper->cleanInput($signupEmail), $Helper->cleanInput($password), $signupBday, $signupGender, $signupCarPref_todatabase);
}


?>



<?php require ("../header.php");?>



<form method ="post">


    <table class="table1">
        <tr>
            <td style="text-align:center"><h1>Create an account:</h1></td>
        </tr>
        <tr>
            <td>
    <table class="table2">
        <tr>
            <td style="width: 70px">E-mail:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left"><input name = "signupEmail" type ="email" value = "<?=$signupEmail;?>"></td>
        </tr>
        <tr>
            <td colspan="3"style="text-align:center"><p class = "redtext"><?=$signupEmailError;?></p></td>
        </tr>
        <tr>
            <td style="width: 70px">Password:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left"><input name = "signupPassword" type ="password"></td>
        </tr>
        <tr>
            <td colspan="3"style="text-align:center"><p class = "redtext"><?=$signupPasswordError;?></p></td>
        </tr>
        <tr>
            <td style="width: 70px">Birthday:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left"><input name="signupBday" type ="date" min="1900-01-01" max = "<?=date('Y-m-d'); ?>" placeholder="YYYY-MM-DD"></td>
        </tr>
        <tr>
            <td colspan="3"style="text-align:center"><p class = "redtext"><?=$signupBdayError;?></p></td>
        </tr>
        <tr>
            <td style="width: 70px">Gender:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left">
                <?php if($signupGender == "male") { ?>
                    <label><input type="radio" name="signupGender" value="male" checked> Male</label><br>
                <?php } else { ?>
                    <label><input type="radio" name="signupGender" value="male"> Male</label><br>
                <?php } ?>

                <?php if($signupGender ==  "female") { ?>
                    <label><input type="radio" name="signupGender" value="female" checked> Female</label><br>
                <?php } else { ?>
                    <label><input type="radio" name="signupGender" value="female"> Female</label><br>
                <?php } ?>

                <?php if($signupGender ==  "unspecified") { ?>
                    <label><input type="radio" name="signupGender" value="unspecified" checked> Doesn't matter...</label><br>
                <?php } else {?>
                    <label><input type="radio" name="signupGender" value="unspecified"> Doesn't matter...</label><br>
                <?php } ?>

        </tr>
        <tr>
            <td style="width: 70px">Preferences:<span class = 'redtext'>*</span></td>
            <td colspan="2" style="text-align:left; height:40px">
                <input type="hidden" name="signupCarPref_items[]"  value="">

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("eucars", $_POST['signupCarPref_items'])){?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="eucars" checked> European cars</label><br>
                <?php } else { ?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="eucars"> European cars</label><br>
                <?php } ?>

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("uscars", $_POST['signupCarPref_items'])){?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="uscars" checked> USA cars</label><br>
                <?php } else { ?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="uscars"> USA cars</label><br>
                <?php } ?>

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("japcars", $_POST['signupCarPref_items'])){?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="japcars" checked>Japanese cars</label><br>
                <?php } else { ?>
                    <label><input type="checkbox" name="signupCarPref_items[]" value="japcars"> Japanese cars</label><br>
                <?php } ?>

                <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("ruscars", $_POST['signupCarPref_items'])){?>
                <label><input type="checkbox" name="signupCarPref_items[]" value="ruscars" checked> Russian cars</label><br>
                    <?php } else { ?>
                        <label><input type="checkbox" name="signupCarPref_items[]" value="ruscars"> Russian cars</label><br>
                    <?php } ?>

                    <?php if(isset($_POST['signupCarPref_items']) && is_array($_POST['signupCarPref_items'])&& in_array("korcars", $_POST['signupCarPref_items'])){?>
                        <label><input type="checkbox" name="signupCarPref_items[]" value="korcars" checked> Korean cars</label><br>
                    <?php } else { ?>
                        <label><input type="checkbox" name="signupCarPref_items[]" value="korcars">  Korean cars</label><br>
                    <?php } ?>
        </tr>
        <tr>
            <td colspan="3"style="text-align:center"><p class = "redtext"><?=$signupCarPrefError;?></p></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center" ><input type ="submit" value = "Create account" class = "btn btn-default btn-md"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center"><p class = "redtext"><?=$signupNotice;?></p></td>
        </tr>
    </table>
        </td>
        </tr>
        <tr>
            <td style="text-align:center"><a href="login.php">Already have an account?..</a></td>
        </tr>
        </table>
</form>


<?php require ("../footer.php");?>

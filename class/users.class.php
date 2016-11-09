<?php
class Users{
    private $connection;
    function __construct($mysqli){
        $this->connection = $mysqli;
    }
    function signup ($email, $password, $bday, $gender, $carpref){

        $stmt = $this->connection->prepare("INSERT INTO user_table (email, password, bday, gender, carpref) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $email, $password, $bday, $gender, $carpref);

        if($stmt->execute()){
            $signupNotice ="Account created! Redirecting...";
            header('Refresh: 3;login.php');
        }else{
            $signupNotice ="Account not created! Try another e-mail...";
        }
        return $signupNotice;
    }
    function login ($email, $password){

        $loginNotice = "";

        $stmt = $this->connection->prepare("SELECT id, email, password, created FROM user_table WHERE email=?");
        $stmt->bind_param("s", $email);

        //määran tulpadele muutujad
        $stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase, $created);
        $stmt->execute();

        //küsin rea andmeid
        if($stmt->fetch()){
            //oli rida siis võrdlen paroole
            $hash = hash("sha512", $password);
            if ($hash == $passwordFromDatabase){
                echo "Kasutaja".$email." logis sisse!";
                $_SESSION["userId"] = $id;
                $_SESSION['email'] = $emailFromDatabase;

                //suunaks uuele lehele
                header("Location: data.php");
            }else{
                $loginNotice = "Incorrect password!";
            }

        }else{
            //ei olnud
            $loginNotice ="Such account doesn't exist!";
        }
        return $loginNotice;
    }
}
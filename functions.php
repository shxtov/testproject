<?php

require_once("/home/vladsuto/config.php");


session_start();

$dbName = "if16_vladsuto_1";
$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $dbName);

require("../class/users.class.php");
$Users = new Users($mysqli);
require("../class/events.class.php");
$Events = new Events($mysqli);
require("../class/helper.class.php");
$Helper = new Helper();





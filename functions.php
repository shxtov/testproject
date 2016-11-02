<?php

require_once("../../config.php");


session_start();

$dbName = "if16_vladsuto_1";
$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $dbName);

require("users.class.php");
$Users = new Users($mysqli);
require("events.class.php");
$Events = new Events($mysqli);
require("helper.class.php");
$Helper = new Helper();





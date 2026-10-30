<?php

require_once "app/php/includes/config.php";

loadAll();

if(!isset($_REQUEST["manage"])){
    $_REQUEST["manage"] = "Home";
}

$_REQUEST["manage"] .= "Controller";
$controller = new $_REQUEST["manage"]();

$controller->checkAction();
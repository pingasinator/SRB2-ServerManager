<?php

require_once "app/php/includes/config.php";

loadAll();

if(!isset($_REQUEST["gestion"])){
    $_REQUEST["gestion"] = "Accueil";
}

$_REQUEST["gestion"] .= "Controller";
$controller = new $_REQUEST["gestion"]();

$controller->checkAction();
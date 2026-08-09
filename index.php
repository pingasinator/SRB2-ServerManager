<?php

require_once "app/php/includes/config.php";

/*
function installSRB2(){
    $command = "flatpak install org.srb2.SRB2";
    $output = shell_exec($command);
    echo $output . "<br>";
    $command = "flatpak remote-add --if-not-exists flathub https://dl.flathub.org/repo/flathub.flatpakrepo";
    $output = shell_exec($command);
    echo $output . "<br>";
}
*/

loadAll();

if(!isset($_REQUEST["gestion"])){
    $_REQUEST["gestion"] = "Accueil";
}

$_REQUEST["gestion"] .= "Controller";
$controller = new $_REQUEST["gestion"]();

$controller->checkAction();

<?php

require_once '../modele/server.php';

if(isset($_POST['action'])){

    $modele = new ServerModele();

    switch($_POST['action']){
        case "install_SRB2":

            break;

        case "start_server":

            break;

        case "list_servers":
            echo json_encode($modele->ListServers());
            break;

        case "kill_server":
            echo $modele->killServer($_POST['Name']);
            break;

        case "delete_server":
            echo $modele->deleteServer($_POST['Name']);
            break;
    }
}





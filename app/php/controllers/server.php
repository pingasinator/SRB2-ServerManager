<?php

class ServerController {

    private $modele;
    function checkAction(){
        if(isset($_POST['action'])){
            switch($_POST['action']){
                case "install_SRB2":

                    break;

                case "list_servers":
                    listServers();
                    break;

                case "create_server":
                    createServer();
                    break;

                case "start_server":
                    startServer($_POST['Name']);
                    break;

                case "kill_server":
                    killServer($_POST['Name']);
                    break;

                case "delete_server":
                    deleteServer($_POST['Name']);
                    break;
            }
        }else{
            include("index.html");
        }
    }
}
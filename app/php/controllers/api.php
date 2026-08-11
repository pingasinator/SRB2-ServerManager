<?php

class APIController{

    public $model;
    function __construct(){
        $this->model = new ServerModele();
    }

    function checkAction()
    {
        if(isset($_POST['action'])){
            switch($_POST['action']){
                case "install_SRB2":

                    break;

                case "start_server":
                    echo json_encode($this->model->startServer($_POST['Name']));
                    break;

                case "restart_server":
                    echo json_encode($this->model->restartServer($_POST['Name']));
                    break;

                case "list_servers":
                    echo json_encode($this->model->ListServers());
                    break;

                case "kill_server":
                    echo json_encode( $this->model->killServer($_POST['Name']));
                    break;

                case "delete_server":
                    echo $this->model->deleteServer($_POST['Name']);
                    break;

                case "set_map":
                    echo json_encode($this->model->changeMap($_POST['Name'],$_POST['Map'],json_decode($_POST['GameType'],true)['name']));
                    break;

                case "send_command":
                    echo json_encode($this->model->sendCommand($_POST['Name'],$_POST['Command']));
                    break;

                case "list_maps":
                    echo json_encode(loadDefaultMaps());
                    break;

                case 'list_server_maps':
                    echo json_encode($this->model->listServerMaps($_POST['Name']));
                    break;

                case 'list_server_addons':
                    echo json_encode($this->model->listServerAddons($_POST['Name']));
                    break;

                case 'remove_server_addon':
                    echo json_encode($this->model->removeServerAddon($_POST['Name'],$_POST['AddonName']));
                    break;

                case "list_addons":
                    $this->model = new AddonModel();
                    echo json_encode($this->model->listAddons());
                    break;

                case "list_server_characters":
                    echo json_encode($this->model->listServerCharacters($_POST['Name']));
                    break;

                case "list_server_gametypes":
                    echo json_encode($this->model->listServerGametypes($_POST['Name']));
                    break;
            }
        }
    }
}







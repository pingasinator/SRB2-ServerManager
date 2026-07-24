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
                    echo $this->model->startServer($_POST['Name']);
                    break;

                case "list_servers":
                    echo json_encode($this->model->ListServers());
                    break;

                case "kill_server":
                    echo $this->model->killServer($_POST['Name']);
                    break;

                case "delete_server":
                    echo $this->model->deleteServer($_POST['Name']);
                    break;

                case 'set_map':
                    echo $this->model->changeMap($_POST['Name'],$_POST['Map'],$_POST['GameType']);
                    break;
            }
        }
    }
}







<?php

class ServerController {

    public $model;
    public $view;

    function __construct(){
        $this->view = new ServerView();
        $this->model = new ServerModele();
        return $this;
    }

    function checkAction(){
        if(isset($_POST['action'])){
            switch($_POST['action']){
                case 'start_server':
                    $this->model->startServer($_POST['Name']);
                    break;

                    case 'restart_server':
                    $this->model->restartServer($_POST['Name']);
                    break;

                case 'kill_server':
                    $this->model->killServer($_POST['Name']);
                    break;

                case 'delete_server':
                    $this->model->deleteServer($_POST['Name']);
                    break;

                case 'add_addon':
                    $this->model->addAddon($_POST['Name'], $_POST['Addon']);
                    break;

                case 'force_character':
                    $this->model->forceCharacter($_POST['Name'],$_POST['Skin']);
                    break;
            }
        }

        $this->view->display();
    }
}
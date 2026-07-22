<?php

class AccueilController{

    public $model;
    public $view;

    function __construct(){
        $this->view = new AccueilView();
        $this->model = new ServerModele();
        return $this;
    }
    function checkAction(){
        if(isset($_POST["action"])){
            switch($_POST["action"]){
                case "create_server":
                    $this->model->createServer();
                    break;
            }
        }
        $this->view->display();
    }

}
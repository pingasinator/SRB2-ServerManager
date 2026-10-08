<?php

class AccueilController{

    public $model;
    public $view;

    function __construct(){
        $this->view = new AccueilView();
        $this->model = new AccueilModel();
        return $this;
    }
    function checkAction(){
        if(isset($_POST["action"])){
            switch($_POST["action"]){
                case "import_addon":
                    $this->model->importAddon();
                    break;

                case "update_addon":
                    $this->model->updateAddon($_POST["addonName"]);
                    break;

            }
        }
        $this->view->display();
    }
}
<?php

class AddonController{

    public $model;
    public $view;

    function __construct(){
        $this->view = new AddonView();
        $this->model = new AddonModel();
        return $this;
    }
    function checkAction(){
        if(isset($_POST["action"])){
            switch($_POST["action"]){
                case "import_addon":
                    $this->model->importAddon();
                    break;
            }
        }
        $this->view->display();
    }
}
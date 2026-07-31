<?php

class AddonController{

    public $model;
    public $view;

    function __construct(){
        $this->view = new AddonView();
        $this->model = new AddonModele();
        return $this;
    }
    function checkAction(){
        if(isset($_POST["action"])){
            switch($_POST["action"]){

            }
        }
        $this->view->display();
    }

}
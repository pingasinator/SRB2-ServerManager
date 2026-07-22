<?php

use Couchbase\View;

class ServerController {

    public $model;
    public $view;

    function __construct(){
        $this->view = new ServerView();
        return $this;
    }

    function checkAction(){
        $this->view->display();
    }
}
<?php

class AccueilController{

    private $model;
    private $view;


    function checkAction(){
        switch($_POST['action']){

        }
    }
    function checkServerState($serverName){
        $command = "sudo tmux list-session | grep 'srb2_{$serverName}'";
        $output = shell_exec($command);
        return $output !== null;
    }
}
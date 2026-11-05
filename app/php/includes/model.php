<?php

abstract class Model{

    private $cnx;

    private function init_DB(): PDO{

        if($this->cnx == null){
            $this->cnx = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
        }

        return $this->cnx;
    }

    public function executeQuery(string $query,$params = null){

        if($params == null){
            $res = $this->init_DB()->query($query);
        }else{
            $res = $this->init_DB()->prepare($query);
            $res->execute($params);
        }

        return $res;
    }
};
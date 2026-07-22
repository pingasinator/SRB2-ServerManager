<?php

class AccueilModele{

    function InstallAddon(){
        $command = "curl -L --output ". "test.pk3" . " https://mb.srb2.org/addons/rouge-the-bat.8886/download";

        $output = shell_exec($command);
        echo $output . "<br>";
    }

    function killServer($name){
        $command = "sudo tmux kill-session -t srb2_" . $name;
        $output = shell_exec($command);
        echo "success";
    }

    function deleteServer($name){
        $this->killServer($name);
        if(file_exists('app/servers/'. $name .'.json')){
            unlink('app/servers/'. $name .'.json');
            echo "success";
            return;
        }
        echo "file not found";
    }
}
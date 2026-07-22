<?php

class AccueilModele{



    function InstallAddon(){
        $command = "curl -L --output ". "test.pk3" . " https://mb.srb2.org/addons/rouge-the-bat.8886/download";

        $output = shell_exec($command);
        echo $output . "<br>";
    }




}
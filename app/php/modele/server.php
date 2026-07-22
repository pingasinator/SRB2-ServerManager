<?php

class ServerModele {

    /**
     * Creates a server, put it in a json file and starts it.
     *
     * @return void
     */
    function createServer(){
        $server = new server($_POST);

        $data = $server->ToJSON();

        $file = fopen('../../servers/'. $server->getName().'.json',"w");
        fwrite($file, $data);
        fclose($file);

        $this->startServer($server->getName());
    }

    /**
     * Starts a Tmux session
     *
     * @param $name
     * @return string
     */
    function startServer($name){
        $path = '../../servers/'. $name .'.json';

        if(file_exists($path)){
            $file = fopen($path,"r");

            $data = fread($file, filesize($path));

            $server = new server(json_decode($data,true));

            $command = "sudo tmux new-session -d -s srb2_{$server->getName()} 'flatpak run org.srb2.SRB2 -dedicated -port {$server->getPort()} -warp {$server->getMap()} -gametype {$server->getGameType()}' 2>/dev/null";
            $output = shell_exec($command);
        }else{
            return "error : Server file not found";
        }

        return "Success";
    }

    /**
     * Lists all servers and their current states
     *
     * @return array
     */
    function ListServers(){

        $path = '../../servers/';
        $files = scandir($path);
        $servers = array();
        foreach($files as $file){
            if($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) === "json"){
                $server = json_decode(file_get_contents($path. $file), true);
                $servers[] = [
                    "server" => $server,
                    "state" => $this->checkServerState($server['Name'])
                ];
            }
        }

        return $servers;
    }

    /**
     * Checks if a server has a session tmux
     *
     * @param $serverName
     * @return string
     */
    function checkServerState($serverName){
        $command = "sudo tmux list-session | grep 'srb2_{$serverName}'";
        $output = shell_exec($command);
        return $output !== null ? "active" : "inactive";
    }

    /**
     * kill the tmux session
     *
     * @param $name
     * @return string
     */
    function killServer($name){
        $command = "sudo tmux kill-session -t srb2_" . $name;
        $output = shell_exec($command);
        return "success";
    }

    /**
     * kill the tmux session and delete the json file
     *
     * @param $name
     * @return string
     */
    function deleteServer($name){
        $this->killServer($name);
        if(file_exists('../../servers/'. $name .'.json')){
            unlink('../../servers/'. $name .'.json');
            return "success";
        }
        return "file not found";
    }

    /**
     * @param $serverName
     * @param $value
     * @return void
     */
    function changeMap($serverName,$value){
        $command = "sudo tmux send-key -t " . $serverName . " ". escapeshellarg("map " . $value."\n");
        $output = shell_exec($command);
        echo $output . "<br>";
    }

    function getServerConsole($serverName){

    }
}
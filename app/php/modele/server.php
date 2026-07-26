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

        $file = fopen('app/servers/'. $server->getName().'.json',"w");
        fwrite($file, $data);
        fclose($file);

        $this->startServer($server->getName());
    }

    /**
     * Starts a Tmux session
     *
     * @param $name
     * @return array
     */
    function startServer($name){
        $path = 'app/servers/'. $name .'.json';

        if(file_exists($path)){
            $file = fopen($path,"r");

            $data = fread($file, filesize($path));

            $server = new server(json_decode($data,true));

            $command = Perm . " tmux new-session -d -s srb2_{$server->getName()} 'flatpak run org.srb2.SRB2 -dedicated -port {$server->getPort()} -warp {$server->getMap()} -gametype {$server->getGameType()}' 2>/dev/null";
            exec($command,$output,$returncode);

            return array("output" => $output, "code" => $returncode);
        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

    function restartServer($name){
        $this->killServer($name);
         return $this->startServer($name);


    }

    /**
     * Lists all servers and their current states
     *
     * @return array
     */
    function ListServers(){

        $path = 'app/servers/';
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
        $command = Perm . " tmux list-session | grep 'srb2_{$serverName}'";
        exec($command,$output,$returncode);
        return $returncode ? "inactive" : "active";
    }

    /**
     * kill the tmux session
     *
     * @param $name
     * @return array
     */
    function killServer($name){
        $command = Perm . " tmux kill-session -t srb2_" . $name;
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    /**
     * kill the tmux session and delete the json file
     *
     * @param $name
     * @return string
     */
    function deleteServer($name){
        $this->killServer($name);
        if(file_exists('app/servers/'. $name .'.json')){
            unlink('app/servers/'. $name .'.json');
            return "successullly deleted <br>";
        }
        return "file not found";
    }

    function getServer($name){
        $path = 'app/servers/'. $name .'.json';
        if(file_exists($path)){
            $file = fopen($path,"r");
            $data = fread($file, filesize($path));
            fclose($file);
            $server = new server(json_decode($data,true));
            return $server;
        }

        return "error : Server file not found <br>";
    }

    /**
     * @param $serverName
     * @param $map
     * @param $gametype
     * @return array
     */
    function changeMap($serverName,$map,$gametype){
        $command = Perm . " tmux send-key -t srb2_" . $serverName . " ". escapeshellarg("map " . $map. " -gametype " . $gametype ."\n");
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    function sendCommand($serverName,$command)
    {
        $command = Perm . " tmux send-key -t srb2_" . $serverName . " ". escapeshellarg($command ."\n");
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    function getServerConsole($serverName){

    }
}
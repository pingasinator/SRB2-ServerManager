<?php

class ServerModel{

    /**
     * Creates a server, put it in a json file and starts it.
     *
     * @return array
     */
    function createServer(): array{
        $server = new server($_POST);

        $data = $server->ToJSON();
        $path = 'app/servers/'. $server->getName().'.json';
        file_put_contents($path, $data);

        $this->startServer($server->getName());

        return array("output" => "Server successfully created.", "code" => 0);
    }

    /**
     * Starts a Tmux session
     *
     * @param $serverName
     * @return array
     */
    function startServer($serverName): array{
        $path = "app/servers/{$serverName}.json";

        if(file_exists($path)){
            $data = file_get_contents($path);

            $server = new server(json_decode($data,true));

            $command = Perm . " tmux new-session -d -s srb2_{$server->getName()} 'flatpak run org.srb2.SRB2 -dedicated -port {$server->getPort()} -warp {$server->getMap()} -gametype {$server->getGameType()} -room {$server->getRoom()} " . ($server->getAllowDownload() === 'on' ? '' :'-noupload') ;
            if(count($server->getMods()) > 0){
                $command .= " -file ";
                $mods = $server->getMods();
                foreach($mods as $mod){

                    $command .= $mod . ".pk3 ";
                }
            }

            $motd = str_replace("'","'\''",$server->getMOTD());

            $command .= "+servername \"{$server->getDisplayName()}\" +password \"{$server->getPassword()}\" +forceskin {$server->getForceCharacter()} +maxplayers {$server->getMaxPlayers()} +motd \"{$motd}\" +timelimit {$server->getTimelimit()} +pointlimit {$server->getPointlimit()} ";

            if($server->getAllowDownload() === 'on'){
                $var = $server->getDownloadsize() * 1024;
                $command .= "+maxsend {$var}";
            }

            $command .= "' 2>/dev/null";
            exec($command,$output,$returncode);

            foreach($server->getCommands() as $command){
                $this->sendCommand($server->getName(),$command);
            }

            $this->getServerLog($server->getName());

            return array("output" => "Server successfully started", "code" => 0);
        }

        return  array("output" => "error : Server file not found", "code" => 1);

    }

    /**
     * Adds an existing addon to the server
     *
     * @param $serverName
     * @param $addonName
     * @return array
     */
    function addAddon($serverName,$addonName): array{
        $serverFilePath = 'app/servers/'. $serverName .'.json';
        if(file_exists($serverFilePath)){
            $data = file_get_contents($serverFilePath);
            $server = new server(json_decode($data,true));
            $addonFilePath = 'app/addons/'. $addonName .'.json';
            if(file_exists($addonFilePath) && !in_array($addonName,$server->getMods())){

                $addons = $server->getMods();
                $addons[] = $addonName;
                $server->setMods($addons);
                if($this->updateServerConfig($server)){
                    $this->restartServer($server->getName());
                    return array("output" => "Addon successfully added", "code" => 0);
                }

            }else{
                return  array("output" => "error : Addon not found", "code" => 1);
            }

        }

        return  array("output" => "error : Server file not found", "code" => 1);

    }

    /**
     * Lists all the server addons
     *
     * @param $serverName
     * @return array
     */
    function listServerAddons($serverName): array{
        $serverFilePath = 'app/servers/'. $serverName .'.json';
        $addons = array();

        if(file_exists($serverFilePath)){
            $data = file_get_contents($serverFilePath);
            $server = new server(json_decode($data,true));
            foreach($server->getMods() as $mod){
                $addons[] = $this->getAddon($mod)->ToArray();
            }

            return $addons;
        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

    /**
     * restart the tmux session
     *
     * @param $serverName
     * @return array
     */
    function restartServer($serverName): array{
        $this->killServer($serverName);
        if($this->startServer($serverName)["code"] === 0){
            return array("output" => "Server successfully restarted", "code" => 0);
        }
        return array("output" => "Error : Server file not found", "code" => 1);
    }

    /**
     * Lists all servers and their current states
     *
     * @return array
     */
    function ListServers(): array{

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
     * Checks if the server has a session tmux
     *
     * @param $serverName
     * @return string
     */
    function checkServerState($serverName): string{
        $command = Perm . " tmux list-session | grep -w 'srb2_{$serverName}'";
        exec($command,$output,$returncode);
        return $returncode ? "inactive" : "active";
    }

    /**
     * Kills the tmux session
     *
     * @param $serverName
     * @return array
     */
    function killServer($serverName): array{
        $this->getServerLog($serverName);
        $command = Perm . " tmux kill-session -t srb2_{$serverName}";
        exec($command,$output,$returncode);
        return array("output" => "Server successfully killed", "code" => 0);
    }

    /**
     * Kills the tmux session and delete the json file
     *
     * @param $ServerName
     * @return array
     */
    function deleteServer($ServerName): array{
        $this->killServer($ServerName);
        if(file_exists('app/servers/'. $ServerName .'.json')){
            unlink('app/servers/'. $ServerName .'.json');
            unlink('app/logs/'. $ServerName .'.log');
            return array("output" => "Server successfully deleted", "code" => 0);
        }
        return array("output" => "Error : Server file not found", "code" => 1);
    }

    /**
     * Returns an Instance of a server
     *
     * @param $ServerName
     * @return server|string
     */
    function getServer($ServerName): Server | array{
        $path = 'app/servers/'. $ServerName .'.json';
        if(file_exists($path)){
            $data = file_get_contents($path);
            $server = new server(json_decode($data,true));
            return $server;
        }

        return "error : Server file not found <br>";
    }

    /**
     * Changes the current map in the server
     *
     * @param $serverName
     * @param $map
     * @param $gametype
     * @return array
     */
    function changeMap($serverName,$map,$gametype): array{
        if($this->checkServerState($serverName) === "inactive"){
            return array("output" => "Server offline", "code" => 1);
        }
        $command = Perm . " tmux send-key -t srb2_{$serverName} ". escapeshellarg("map {$map}  -gametype \"{$gametype}\"\n");
        exec($command,$output,$returncode);
        return array("output" => "Map set to {$map} with the gametype {$gametype}", "code" => 0);
    }

    /**
     * Sends SRB2 command to the server
     *
     * @param $serverName
     * @param $command
     * @return array
     */
    function sendCommand($serverName,$command):array
    {
        if($this->checkServerState($serverName)){
            return array("output" => "Server offline", "code" => 1);
        }

        if(empty(trim($command))){
            return array("output" => "Command empty", "code" => 1);
        }

        $command = Perm . " tmux send-key -t srb2_{$serverName} " . escapeshellarg("{$command}\n");
        exec($command,$output,$returncode);
        return array("output" => "Command successfully send", "code" => 0);
    }

    /**
     * Updates the server config in the json file
     *
     * @param $server
     * @return array|int
     */
    function updateServerConfig($server): bool | array{
        $path = 'app/servers/'. $server->getName() .'.json';
        if(file_exists($path)){
            file_put_contents($path,$server->toJson());
            return true;
        }
        return array("output" => "error : Server config file not found", "code" => 1);
    }

    /**
     * Returns all the defaults and custom maps of the server
     *
     * @param $serverName
     * @return array
     */
    public function listServerMaps($serverName): array{
        $defaultMaps = loadDefaultMaps();
        $customMaps = array();

        $server = $this->getServer($serverName);
        foreach($server->getMods() as $modName){

           $mod = $this->getAddon($modName);
           foreach($mod->getMaps() as $map){

               $customMap = new map($map);
               $customMaps[] = $customMap->toArray();
           }

        }

        $Maps = array_merge($defaultMaps,$customMaps);

        return $Maps;
    }

    /**
     * Lists the Players in the server
     *
     * @param $serverName
     * @return array
     */
    public function getServerPlayers($serverName): array{

        $this->sendCommand($serverName, "nodes");

        usleep(100000);

        $result =  $this->getServerLog($serverName);

        $lines = explode("\n",$result["output"]);

        $players = array();

        for($i=count($lines) - 1;$i > 0;$i--){
            if(trim($lines[$i]) == "\$nodes"){
                break;
            }

            if(preg_match('/^\d/',$lines[$i])){
                $datas = explode(" - ",$lines[$i]);
                $name = trim(explode(":",$datas[0])[1]);
                $node = intval(explode(" ",$datas[0])[0]);
                if(str_contains($datas[2],"[")){
                    $e = explode("]:",$datas[2]);
                    $ip = substr($e[0],1,strlen($e[0])-1);
                    $port = $e[1];
                }else{
                    $ip = explode(":",$datas[2])[0];
                    $port = explode(":",$datas[2])[1];
                }
                $players[] = ["name" => $name,"node" => $node,"ip" => $ip,"port" => $port];
            }

        }

        return $players;
    }

    /**
     * Lists the IPs banned
     *
     * @param $serverName
     * @return array
     */
    public function getServerBanList($serverName): array{
        $ips = array();
        $this->sendCommand($serverName, "reloadbans");

        $path = addonsFolder . "../ban.txt";
        if(file_exists($path)){
            $contents = file_get_contents($path);
            $lines = explode("\n",$contents);
            foreach($lines as $line){
                if(trim($line) !== ""){
                    $ips[] = explode(" ",$line)[0];
                }
            }
        }
        return $ips;
    }

    /**
     * Sets the point and time limit of the game (time 0 = unlimited time, point 0 = unlimited points)
     *
     * @param $serverName
     * @param $time
     * @param $point
     * @return array
     */
    public function setServerTimeAndPointLimit($serverName,$time,$point): array{
        if($this->checkServerState($serverName) === "inactive"){
            return array("output" => "Server offline", "code" => 1);
        }
        $this->sendCommand($serverName, "timelimit {$time}");
        $this->sendCommand($serverName, "pointlimit {$point}");
        return array("output" => "Time set to " . (empty($time) ? "unlimited" : $time) . "<br> Points set to " . (empty($point) ? 'unlimited' : $point), "code" => 0);
    }

    /**
     * Removes all the IPs banned in the ban.txt
     *
     * @param $serverName
     * @return array
     */
    public function ServerCleanBans($serverName): array{
        if($this->checkServerState($serverName) === "inactive"){
            return array("output" => "Server offline", "code" => 1);
        }
        $this->sendCommand($serverName, "clearbans");
        return array("output" => "banlist Cleared", "code" => 0);
    }

    /**
     * Kicks a player out of the server
     *
     * @param $serverName
     * @param $node
     * @return array
     */
    public function kickServerPlayer($serverName,$node):array{
        $this->sendCommand($serverName, "kick {$node}");
        sleep(1);
        return array("output" => "player {$node} kicked","code" => 0);
    }

    /**
     * Bans a player and add it to banlist.txt
     *
     * @param $serverName
     * @param $node
     * @return array
     */
    public function banServerPlayer($serverName,$node):array{
        $this->sendCommand($serverName, "ban {$node}");
        sleep(1);
        return array("output" => "Player {$node} banned","code" => 0);
    }

    /**
     * Removes an IP in the ban.txt
     *
     * @param $serverName
     * @param $ip
     * @return array
     */
    public function ServerUnbanIP($serverName,$ip): array{
        $path = addonsFolder . "../ban.txt";
        $contents = file_get_contents($path);
        $lines = explode("\n",$contents);
        for($i = 0; $i < count($lines); $i++ ){
            if(str_contains($lines[$i],$ip)){
                unset($lines[$i]);
            }
        }
        file_put_contents($path,implode("\n",$lines));

        $this->sendCommand($serverName, "reloadbans");
        return array("output" => "IP {$ip} unbanned","code" => 0);
    }

    /**
     * Returns an Addon in the addons folder (returns an array if not found)
     *
     * @param $modName
     * @return array|Addon
     */
    public function getAddon($modName):array | Addon{
        $path = 'app/addons/'. $modName .'.json';
        if(file_exists($path)){
            $data = file_get_contents($path);
            $addon = new addon(json_decode($data,true));
            return $addon;
        }

        return array("output" => "addon not found","code" => 1);
    }

    /**
     * Lists all the characters in the server (modded included)
     *
     * @param $serverName
     * @return array
     */
    public function listServerCharacters($serverName):array{
        $server = $this->getServer($serverName);
        $defaultCharacters = loadDefaultCharacters();
        foreach($server->getMods() as $modName){
            $mod = $this->getAddon($modName);
            foreach($mod->getCharacters() as $character){
                $defaultCharacters[] = $character;
            }
        }

        for($i = 0; $i < count($defaultCharacters); $i++){
            $defaultCharacters[$i] = $defaultCharacters[$i]->ToArray();
        }

        return $defaultCharacters;
    }

    /**
     * Forces all the players to have à specific character
     *
     * @param $serverName
     * @param $skin
     * @return array
     */
    public function forceCharacter($serverName,$skin):array{
        $server = $this->getServer($serverName);
        $server->setForceCharacter($skin);
        if($this->updateServerConfig($server)){
            $command = Perm . " tmux send-key -t srb2_{$serverName} " . escapeshellarg("forceskin {$skin }\n");
            exec($command,$output,$returncode);
            return array("output" => "Character {$skin} forced", "code" => 0);
        }
        return array("output" => "error : Server config file not found", "code" => 1);
    }

    /**
     * Lists all the gametypes in the server (modded gametypes included)
     *
     * @param $serverName
     * @return array
     */
    public function listServerGametypes($serverName): array{
        $server = $this->getServer($serverName);
        $addons = $server->getMods();
        $gametypes = loadDefaultGametypes();
        foreach($addons as $addonName){
            $addon = $this->getAddon($addonName);
            foreach($addon->getGametypes() as $gametype){
                $gametypes[] = new Gametype($gametype);
            }
        }

        for($i = 0; $i < count($gametypes); $i++){
            $gametypes[$i] = $gametypes[$i]->ToArray();
        }

        return $gametypes;
    }

    /**
     * Returns a Gametype of the server by its identifier
     *
     * @param $serverName
     * @param $gametypeIdentifier
     * @return mixed
     */
    public function getServerGametype($serverName,$gametypeIdentifier): mixed{
        $gametypes = $this->listServerGametypes($serverName);
        foreach($gametypes as $gametype){
            if($gametype['identifier'] == $gametypeIdentifier){
                return $gametype;
            }
        }

        return array("output" => "Error : Server gametype not found", "code" => 1);
    }

    /**
     * Removes an Addon from the server and restart it
     *
     * @param $serverName
     * @param $addonName
     * @return array
     */
    public function removeServerAddon($serverName,$addonName):array{
        $path = 'app/servers/'. $serverName .'.json';
        if(file_exists($path)){
            $data = file_get_contents($path);
            $server = new server(json_decode($data,true));
            $addons = $server->getMods();
            $addon = $this->getAddon($addonName);

            if(in_array($addonName,$addons)){
                $key = array_search($addonName,$addons);
                array_splice($addons,$key,1);
            }

            foreach($addon->getCharacters() as $character){
                if($character->getSkinName() === $server->getForceCharacter()){
                    $server->setForceCharacter("None");
                }
            }

            $server->setMods($addons);
            $this->updateServerConfig($server);
            $this->restartServer($serverName);
            return array("output" => "Addon removed succesfully ", "code" => 0);
        }

        return array("output" => "error : Server config file not found", "code" => 1);
    }

    /**
     * Returns all the server maps (modded included) that are compatible with a specific gametype
     *
     * @param $serverName
     * @param $gametypeName
     * @return array
     */
    public function getServerMapsWithGameType($serverName,$gametypeName): array{
        $server = $this->getServer($serverName);
        $maps = $this->listServerMaps($serverName);
        $gametype = $this->getServerGametype($serverName,$gametypeName);
        $filteredMaps = array();
        foreach($maps as $map){
            if(is_string($map['TypeOfLevel'])){
                $filteredMaps[] = $map;
            }
            foreach($map['TypeOfLevel'] as $typeOfLevel){
                foreach ($gametype["TypeOfLevel"] as $type){
                    if($typeOfLevel === $type){
                        $filteredMaps[] = $map;
                        break;
                    }
                }
            }
        }
        return $filteredMaps;
    }

    /**
     * Returns the CPU, RAM usage and the time it was up
     *
     * @param $serverName
     * @return array
     */
    public function getServerResources($serverName):array{
        try{
            $command = "tmux list-panes -s -t srb2_{$serverName} -F '#{pane_pid}'";
            exec($command,$output,$returncode);
            if($returncode != 0){
                return array("output" => array("cpu" => 0, "ram" => 0,"time" => "00:00"), "code" => 1);
            }
            $command = "pstree -p {$output[0]}";
            exec($command,$output,$returncode);
            $processes = explode("---",$output[1]);
            $process = str_replace(["lsdlsrb2(",")"],["",""],$processes[2]);
            $command = "ps -o %cpu,rss,etime --ppid {$process}";
            exec($command,$output,$returncode);

            $data = preg_split('/\s+/',trim($output[3]));

            return array ("output" => array("cpu" => $data[0],"ram" => intval(intval($data[1]) / 1024),"time" => $data[2]), "code" => 0);

        }catch(Exception $e){
            return array("output" => array("cpu" => 0, "ram" => 0,"time" => "00:00"), "code" => 1);
        }
    }

    /**
     * Returns the server logs
     *
     * @param $serverName
     * @return array
     */
    function getServerLog($serverName): array{
        if($this->checkServerState($serverName) === "inactive"){
            return array("output" => "server offline", "code" => 1);
        }

        $command = Perm . " tmux capture-pane -t srb2_{$serverName} -S - && " . Perm . " tmux save-buffer app/logs/{$serverName}.log";
        exec($command,$output,$returncode);
        $data = file_get_contents("app/logs/{$serverName}.log");
        return array("output" => $data, "code" => $returncode);

    }

    function sendServerMessage($serverName,$message):array{
        if($this->checkServerState($serverName) === "inactive"){
            return array("output" => "server offline", "code" => 1);
        }

        if(empty($message)){
            return array("output" => "Message empty", "code" => 1);
        }

        $this->sendCommand($serverName,"say {$message}");
        return array("output" => "Message sent", "code" => 0);
    }
}
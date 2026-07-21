<?php


require_once "app/php/modele/server.php";

const srb2_addons_folder = "/root/.var/app/org.srb2.SRB2/.srb2";

/*
function installSRB2(){
    $command = "flatpak install org.srb2.SRB2";
    $output = shell_exec($command);
    echo $output . "<br>";
    $command = "flatpak remote-add --if-not-exists flathub https://dl.flathub.org/repo/flathub.flatpakrepo";
    $output = shell_exec($command);
    echo $output . "<br>";
}
*/

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

    startServer($server->getName());
}


function startServer($name){
    $path = 'app/servers/'. $name .'.json';

    if(file_exists($path)){
        $file = fopen($path,"r");

        $data = fread($file, filesize($path));

        $server = new server(json_decode($data,true));

        $command = "sudo tmux new-session -d -s srb2_{$server->getName()} 'flatpak run org.srb2.SRB2 -dedicated -port {$server->getPort()} -warp {$server->getMap()} -gametype {$server->getGameType()}' 2>/dev/null";
        $output = shell_exec($command);
    }else{
        echo "error : Server file not found";
    }


}

function changeMap($serverName,$value){
    $command = "sudo tmux send-key -t " . $serverName . " ". escapeshellarg("map " . $value."\n");
    $output = shell_exec($command);
    echo $output . "<br>";

}

/**
 *
 *
 * @return array
 */
function ListServers(){

    $files = scandir('app/servers/');
    $servers = array();
    foreach($files as $file){

        if($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) === "json"){
            $server = json_decode(file_get_contents('app/servers/'. $file), true);
            $servers[] = [
                "server" => $server,
                "state" => checkServerState($server['Name'])
            ];
        }
    }

    echo json_encode($servers);

    return $servers;
}

function checkServerState($serverName){
    $command = "sudo tmux list-session | grep 'srb2_{$serverName}'";
    $output = shell_exec($command);
    return $output !== null;
}

function killServer($name){
    $command = "sudo tmux kill-session -t srb2_" . $name;
    $output = shell_exec($command);
    echo "success";
}

function deleteServer($name){
    killServer($name);
    if(file_exists('app/servers/'. $name .'.json')){
        unlink('app/servers/'. $name .'.json');
        echo "success";
        return;
    }
    echo "file not found";
}

function InstallAddon(){
    $command = "curl -L --output ". "test.pk3" . " https://mb.srb2.org/addons/rouge-the-bat.8886/download";

    $output = shell_exec($command);
    echo $output . "<br>";
}

if(isset($_POST['action'])){
    switch($_POST['action']){
        case "install_SRB2":

            break;

        case "list_servers":
            listServers();
            break;

        case "create_server":
            createServer();
            break;

        case "start_server":
            startServer($_POST['Name']);
            break;

        case "kill_server":
            killServer($_POST['Name']);
            break;

        case "delete_server":
            deleteServer($_POST['Name']);
            break;
    }
}else{
    include("index.html");
}

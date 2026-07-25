generate_Map_selector();
generate_gametype_selector();

function action(action,name){

    $.ajax({
        url: host_url + "/index.php",
        method:"post",
        data:{gestion:"API",action: action + '_server',Name:name},
        success:function(data){
            console.log(data);
        },
        error:function (){
            console.log("error");
        }}
    )

}

function setMap(){
    const map = document.getElementById('Map');
    const gameType = document.getElementById('GameType');

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'set_map',Name:name.value,GameType:gameType.value,Map:map.value},
        success:function(data){
            console.log(data);
        },
        error:function (){
            console.log("error");
        }
    })
}

function sendCommand(){
    const command = document.getElementById('command');
    console.log(command.value);
    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'send_command',Name:name.value,Command:command.value},
        success:function(data){
            console.log(data);
        },
        error:function (){
            console.log("error");
        }
    })
}
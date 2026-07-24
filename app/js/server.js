generate_Map_selector();
generate_gametype_selector();



function setMap(){
    const map = document.getElementById('Map');
    const gameType = document.getElementById('GameType');

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{action:'set_map',Name:name.value,GameType:gameType.value,Map:map.value},
        success:function(){
            console.log('E');
        },
        error:function (){
            console.log("error");
        }
    })
}
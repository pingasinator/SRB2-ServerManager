const host_url = "";

const server_form_element = document.getElementById('server');
const server_search_element = document.getElementById("server");
const servers_table_element = document.getElementById('server-table');

const list_servers_element = document.getElementById('list-servers');


const map_selector_element = document.getElementById("Map");
const gametype_selector_element = document.getElementById("GameType");

function create_server() {

    const name = document.getElementById('Name');
    const port = document.getElementById('Port');
    const maxPlayers = document.getElementById('MaxPlayers');
    const map = document.getElementById('Map');
    const gameType = document.getElementById('GameType');

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{action:'create_server',Name:name.value,Port:port.value,MaxPlayers:maxPlayers.value,GameType:gameType.value,Map:map.value},
        success:function(){
            hide_form_server();
        },
        error:function (){
            console.log("error");
        }
    })


    list_Servers();
}

function select_all_servers(value){
    for(let i = 0; i < list_servers_element.childElementCount; i++ ){
        list_servers_element.children[i].children[0].children[0].checked = value.checked;
    }
}

function list_selected_servers(){
    let list_servers = [];

    for(let i = 0; i < list_servers_element.childElementCount; i++ ){
        console.log(list_servers_element.children[i].children[0].children[0].checked);
        if(list_servers_element.children[i].children[0].children[0].checked === true){
            list_servers.push(list_servers_element.children[i].children[1].innerText);
        }
    }

    return list_servers;
}

function generate_Map_selector(){

    map_selector_element.innerHTML = "";
    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_maps'},
        success:function(data){
            console.log(data);
            defaultMaps = JSON.parse(data)

            for(let i = 0; i < defaultMaps.length; i++){
                if(defaultMaps[i].TypeOfLevel.includes(gametype_selector_element.value)){
                    map_selector_element.innerHTML += `<option value="${defaultMaps[i].id}">${defaultMaps[i].levelname} ${defaultMaps[i].ACT != null ? " Act " + defaultMaps[i].ACT : ""}</option>`;
                }
            }

        },
        error:function (){
            console.log("error");
        }
    })


}

function generate_gametype_selector(){
    let defaultGametypes = [
        "Co-op",
        "Competition",
        "Race",
        "Match",
        "Tag",
        "CTF"
    ];

    for(let i = 0; i < defaultGametypes.length; i++){
        gametype_selector_element.innerHTML += `<option value="${defaultGametypes[i]}">${defaultGametypes[i]}</option>`;
    }
}
const host_url = "";

const server_form_element = document.getElementById('server');
const server_search_element = document.getElementById("server");
const servers_table_element = document.getElementById('server-table');

const list_servers_element = document.getElementById('list-servers');
const list_addons_element = document.getElementById('list-addons');

const check_all_element = document.getElementById('check_all');

const map_selector_element = document.getElementById("Map");
const gametype_selector_element = document.getElementById("GameType");

const name = document.getElementById('Name');
const port = document.getElementById('Port');
const maxPlayers = document.getElementById('MaxPlayers');
const map = document.getElementById('Map');
const gameType = document.getElementById('GameType');

function create_server() {

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

function generate_server_map_selector(serverName){

    map_selector_element.innerHTML = "";
    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_maps',Name:serverName},
        success:function(data){
            defaultMaps = JSON.parse(data);
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

function generate_Map_selector(){

    map_selector_element.innerHTML = "";
    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_maps'},
        success:function(data){
            console.log(data);
            defaultMaps = JSON.parse(data);
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


function list_Addons(){

    check_all_element.checked = false;

    list_addons_element.children.innerHTML = `<div>Loading <img id="loading_img" src="app/img/sonic-running.gif" alt="sonic_running"></div>`

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:"API",action:'list_addons'},
        success:function(data){
            let content = "";
            let addons = JSON.parse(data);
            console.log(addons);
            addons.map((value) => {
                content += `<tr>
                                <td><input type="checkbox"></td>
                                <td>${value.name}</td>
                            </tr>`;
            })


            list_addons_element.innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })
}

async function sleep(ms){
    return new Promise((resolve) => {setTimeout(resolve,ms)})
}
listAddonsToAdd();
listCharacters();
list_server_gametypes();

let listAddons = [];

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

function list_server_addons(server){

    const list_server_addons_element = document.getElementById("list-server-addons")
    let content = "";

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_addons',Name:server},
        success:function(data){
            addons = JSON.parse(data);
            addons.map((name) => {
                content += `<tr><td><input type="checkbox"></td><td>${name}</td></td></tr>`;

            })
            list_server_addons_element.innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })


}

function setMap(){
    const map = document.getElementById('Map');
    const gameType = document.getElementById('GameType');
    console.log(name);

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

function listSkins(){
    const skin = document.getElementById('list-skins');

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'force_skin',Name:name.value,Skin:skin.value},
        success:function(data){
            console.log(data);
        },
        error:function (){
            console.log("error");
        }
    })
}

function listAddonsToAdd(){

    const list_addons_to_Add = document.getElementById("list-addons-to-add");

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:"API",action:'list_addons'},
        success:function(data){
            let content = "";
            listAddons = JSON.parse(data);

            listAddons.map((value) => {
                content += `<tr><td><button onclick="loadAddon('${value.name}')">${value.name}</button></td></tr>`;
            })

            list_addons_to_Add.innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })
}

function loadAddon(name){
    const addon_list_map_element = document.getElementById("addon-maps");
    const addon_list_characters_element = document.getElementById("addon-characters");
    const addon_element = document.getElementById("addon");

    let content_maps = "";
    let content_characters = "";

    let addon = listAddons.find((value) => value.name === name);

    console.log(listAddons);

    addon.maps.map((map) => {
        content_maps += `<li>${map.levelname} ${map.ACT !== "0" ? "act " + map.ACT : ""}</li>`;
    })

    addon.characters.map((character) => {
        content_characters += `<li>${character.skinName}</li>`;
    })

    addon_list_characters_element.innerHTML = content_characters;
    addon_list_map_element.innerHTML = content_maps;
    addon_element.value = addon.name;
}

function display_form_addons(){
    const form_addons = document.getElementById("form_addons");

    form_addons.classList.remove("d-none");
}

function hide_form_addons(){
    const form_addons = document.getElementById("form_addons");

    form_addons.classList.add("d-none");
}

function generate_server_map_selector(serverName){

    map_selector_element.innerHTML = "";
    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_maps',Name:serverName},
        success:function(data){
            let Maps = JSON.parse(data);
            let gametypes = JSON.parse(gametype_selector_element.value);
            Maps.map((map) => {
                gametypes.typeoflevel.map((typeoelevel) => {
                    if(map.TypeOfLevel != null && map.TypeOfLevel.includes(typeoelevel)){
                        map_selector_element.innerHTML += `<option value="${map.id}">${map.levelname} ${map.ACT != null ? " Act " + map.ACT : ""}</option>`;
                    }
                })

            })
        },
        error:function (){
            console.log("error");
        }
    })
}


function select_all_addons(value){
    for(let i = 0; i < list_addons_element.childElementCount; i++ ){
        list_addons_element.children[i].children[0].children[0].checked = value.checked;
    }
}

function check_all_elements(checkbox){
    for(let i = 0; i < checkbox.parentElement.parentElement.parentElement.parentElement.children[1].childElementCount; i++ ){
        checkbox.parentElement.parentElement.parentElement.parentElement.children[1].children[i].children[0].children[0].checked = checkbox.checked;
    }
}

function list_selected_addons(){
    list_addons_element.children.map((addon) => {
        console.log()
    })
}

function listCharacters(){

    let content = "";
    const list_skins_elements = document.getElementById("list-skins");

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_characters',Name:name.value},
        success:function(data){
            let characters = JSON.parse(data);

            characters.map((character) => {
                content += `<option value="${character.skinName}">${character.displayName != null ? character.displayName : character.skinName}</option>`;
            })

            list_skins_elements.innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })
}

function list_server_gametypes(){

    const list_gametypes_element = document.getElementById("GameType");

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:"API",action:'list_server_gametypes',Name:name.value},
        success:function(data){
            let content = "";
            listGametypes = JSON.parse(data);
            listGametypes.map((value) => {
                content += `<option value='{"name":"${value.name}","typeoflevel":${JSON.stringify(value.TypeOfLevel)}}'>${value.name}</option>`;
            })

            list_gametypes_element.innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })
}
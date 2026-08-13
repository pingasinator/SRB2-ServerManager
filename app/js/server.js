
display_list_form_gametypes();

list_server_addons();
list_Addons_To_Add();
list_Characters();
list_server_gametypes();
generate_server_map_selector();
get_server_logs();

const list_server_addons_element = document.getElementById('list-server-addons');

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

function list_server_addons(){

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_addons',Name:name.value},
        success:function(data){
            addons = JSON.parse(data);
            display_list_server_addons(addons);
        },
        error:function (){
            console.log("error");
        }
    })
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

function list_Addons_To_Add(){

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:"API",action:'list_addons'},
        success:function(data){
            listAddons = JSON.parse(data);
            display_list_Addons_To_Add(listAddons);

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

function generate_server_map_selector(){

    map_selector_element.innerHTML = "";
    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_maps',Name:name.value},
        success:function(data){
            let Maps = JSON.parse(data);
            let gametypes = JSON.parse(gametype_selector_element.value);
            Maps.map((map) => {
                gametypes.typeoflevel.map((typeofelevel) => {
                    if(map.TypeOfLevel != null && map.TypeOfLevel.includes(typeofelevel)){
                        map_selector_element.innerHTML += `<option value="${map.id}">${map.levelname} ${map.ACT !== null || map.ACT !== '0' ? " Act " + map.ACT : ""}</option>`;
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

function list_Characters(){

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:'API',action:'list_server_characters',Name:name.value},
        success:function(data){
            let characters = JSON.parse(data);
            display_list_Characters(characters);

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
                content += `<option value='{"name":"${value.identifier}","typeoflevel":${JSON.stringify(value.TypeOfLevel)}}'>${value.name}</option>`;
            })

            list_gametypes_element.innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })
}

function removeServerAddons(){
    let list_addons = list_selected_addons();
    console.log(list_addons);

    list_addons.map((addon) => {
        console.log(name.value);
        $.ajax({
            url: host_url + "/index.php",
            method:"POST",
            data:{gestion:"API",action:'remove_server_addon',Name:name.value,AddonName:addon},
            success:function(data){
                console.log(data);
                list_server_addons(name.value);
            },
            error:function (){
                console.log("error");
            }
        })
    })


}

function list_selected_addons(){
    let list_addons = [];

    for(let i = 0; i < list_server_addons_element.childElementCount; i++ ){
        if(list_server_addons_element.children[i].children[0].children[0].checked === true){
            list_addons.push(list_server_addons_element.children[i].children[1].innerText);
        }
    }
    return list_addons;
}

function display_list_form_gametypes(){
    const form_default_gametype = document.getElementById("form_default_gametype");
    const form_list_gametypes = document.getElementById("form_list_gametypes");

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{gestion:"API",action:'list_server_gametypes',Name:name.value},
        success:function(data){
            let content = "";
            let listGametypes = JSON.parse(data);
            listGametypes.map((gametype) => {
                content += `<option ${gametype.identifier === form_default_gametype.value ? "selected" : ""} value="${gametype.identifier}">${gametype.name}</option>`;
            })

            form_list_gametypes.innerHTML = content;
            display_list_form_maps();
        },
        error:function (){
            console.log("error");
        }
    })
}

async function get_server_logs(){
        $.ajax({
            url: host_url + "/index.php",
            method:"POST",
            data:{gestion:"API",action:'get_server_logs',Name:name.value},
            success:async function(data){
                console.log(data);
                let content = JSON.parse(data);
                display_server_logs(content.output);
                await sleep(1000);
                get_server_logs();
            },
            error:function (){
                console.log("error");
            }
        })
}

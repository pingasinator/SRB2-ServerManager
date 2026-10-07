const list_server_addons_element = document.getElementById('list-server-addons');

const form_server_name = document.getElementById('form-server-name');

const config_server_name_element = document.getElementById('config-server-name');
const config_server_displayName_element = document.getElementById('config-server-displayName');
const config_server_motd_element = document.getElementById('config-server-motd');
const config_server_maxplayers_element = document.getElementById('config-server-maxplayers');
const config_server_gametype_element = document.getElementById('config-server-gametype');

const config_server_timelimit_element = document.getElementById('config-server-timelimit');
const config_server_pointlimit_element = document.getElementById('config-server-pointlimit');

const config_server_port_element = document.getElementById('config-server-port');
const config_server_password_element = document.getElementById("config-server-password");
const config_server_masterserver_element = document.getElementById("config-server-masterserver");
const config_server_allowdownload_element = document.getElementById("config-server-allowdownload")
const config_server_downloadsize_element = document.getElementById("config-server-downloadsize");

const config_server_commands_input_element = document.getElementById("config-server-command-input");
const config_server_commands_element = document.getElementById("config-server-commands");
const config_server_commands_table_tbody_element = document.getElementById("config-server-commands-table-tbody");

const list_addons = document.getElementById("config-addons-background");

const gametype_changer_element = document.getElementById('gametype-changer');

let server_name;
let server_displaName;
let default_gametype;
let default_map;
let default_character;
let default_room;
let default_commands = [];
let commands = [];



init_config();
get_server_logs();

let listAddons = [];

async function init_config(){

    return await init_server_config().then(async (value) => {
        document.getElementById("form_server").action = `index.php?gestion=server&Name=${server_name}`;


        await init_server_gametype_selector(config_server_gametype_element,default_gametype,"config-server-map",'').then(async (value) => {
            await init_map_selector('config-server-map',value,default_map);
        });

        await init_server_gametype_selector(gametype_changer_element,'',"map-changer",'').then(async (value) => {
            await init_map_selector('map-changer',value,'');
        });

        await init_server_forcecharacter_selector("config-server-forcecharacter",default_character);

        init_server_addons("server-addons");
        init_addonstoadd();
        init_rooms_selector("config-server-room",default_room);
        init_commands_table();

        return 1;
    })

}

async function init_server_config(){

    const name_element = document.getElementById("config-server-name");
    let url = new URL(window.location);
    let serverName = url.searchParams.get("Name");

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"get_server_config",Name:serverName})
    });

    let data = res.json();
    return await data.then((value) => {

        server_name = value.Name
        server_displaName = value.DisplayName;
        default_gametype = value.GameType;
        default_map = value.Map;
        default_character=value.ForceCharacter;
        default_room = value.Room;
        default_commands = value.Commands;
        commands = default_commands;

        form_server_name.value = value.Name;

        config_server_name_element.value = value.Name;
        config_server_displayName_element.value = value.DisplayName;
        config_server_motd_element.value = value.MOTD;
        config_server_maxplayers_element.value = value.MaxPlayers;

        config_server_timelimit_element.value = value.TimeLimit;
        config_server_pointlimit_element.value = value.PointLimit;
        config_server_allowdownload_element.checked = value.AllowDownload === "on";
        config_server_downloadsize_element.value = value.DownloadSize;

        config_server_port_element.value = value.Port;
        config_server_password_element.value = value.Password;
        config_server_masterserver_element.value = value.MasterServer;


        return 1;
    })
}

async function action(action){

    let res = await fetch(host_url + "/index.php",{
        method:"post",
        body: new URLSearchParams({gestion:"API",action: action + '_server',Name:server_name})
    });

    let result = res.json();

    result.then((data) => {
        console.log(data);
    })
}

async function setMap(){
    const map = document.getElementById('map-changer');
    const gameType = document.getElementById('gametype-changer');

    let data = {gestion:'API',action:'set_map',Name:server_name,GameType:gameType.value,Map:map.value}

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams(data)
    });

    if(res.ok){
        
    }else{
        console.log("error : " + res.status);
    }
}

async function sendCommand(){
    const command = document.getElementById('command');

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:'API',action:'send_command',Name:server_name,Command:command.value})
    });

    let result = res.json();

    result.then((data) => {
        console.log(data);
    });
}

async function add_addons(){

    let tbody = document.getElementById("list-addons-to-add");
    let lines = tbody.childElementCount;

    for(let i = 0;i < lines;i++){
        if(tbody.children[i].children[0].children[0].checked){

            let res = await fetch(host_url + "/index.php",{
                method:"POST",
                body: new URLSearchParams({gestion:"API",action:"add_addon_server",Name:server_name,addon:tbody.children[i].children[2].innerText})
            });

            let result = res.json();

            result.then(async () => {
                init_config();
            })
        }
    }
}

async function remove_Addons(){

    let tbody = document.getElementById("server-addons");
    let lines = tbody.childElementCount;

    for(let i = 0;i < lines;i++){
        if(tbody.children[i].children[0].children[0].checked){

            let res = await fetch(host_url + "/index.php",{
                method:"POST",
                body: new URLSearchParams({gestion:"API",action:"remove_addon_server",Name:server_name,addon:tbody.children[i].children[1].innerText})
            });

            let result = res.json();

            result.then(async () => {
                listAddons.splice(listAddons.indexOf(tbody.children[i].children[1].innerText),1);
                init_config();
            })
        }
    }
}

async function init_server_gametype_selector(selector,selectedValue,mapSelector,mapValue){

    let content = "";

    let data = {gestion:"API",action:"list_server_gametypes",Name:server_name}
            
    const res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams(data)
    });

    if(res.ok){
        let listGametypes = res.json();
        
        let typeSelected = "co-op";
        let e = listGametypes.then((value) =>{
            value.map((gametype) => {
                content += `<option ${gametype.identifier === selectedValue ? "selected" : ""} value="${gametype.identifier}">${gametype.name}</option>`;
                typeSelected = gametype.identifier === selectedValue ? gametype.identifier : typeSelected;               
            });
            selector.innerHTML = content;
            return typeSelected;
        });
        return e;
    }else{
        console.log("error : " + res.status);
    }
}

async function init_map_selector(selectorId,typeSelected,selectedValue){

    map_selector = document.getElementById(selectorId);
    let content = "";
    let data = {gestion:"API",action:"get_server_maps_with_gametype",Name:server_name,TypeOfLevel:typeSelected};

    res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams(data)
    });

    let maps = res.json();

    maps.then((data) => {
        data.map((map) => {
            content += `<option ${ map.id === selectedValue ? "selected" : ""} value="${map.id}">${map.levelname} ${map.ACT !== null && map.ACT !== '0' ? " Act " + map.ACT : ""}</option>`;
        })

        map_selector.innerHTML = content;
    });
}

async function init_server_forcecharacter_selector(selectorID,selectedvalue) {

    const selector = document.getElementById(selectorID);
    let content = "";
            
    const res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:'API',action:"list_server_characters",Name:server_name})
    });
    
    let characters = res.json();
    characters.then((value) =>{
        value.map((character) => {
            content += `<option ${character.skinName === selectedvalue ? "selected" : ""} value="${character.skinName}">${character.displayName != null ? character.displayName : character.skinName}</option>`;
        })
        selector.innerHTML = content;
    });
}

async function init_server_addons(tbodyID){

    let content = "";
    listAddons = [];
    let tbody = document.getElementById(tbodyID);

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"list_server_addons",Name:server_name})
    });

    let addons = res.json();

    addons.then((value) => {
        value.map((addon) => {

            listAddons.push(addon);
            console.log(addon)
            content += `<tr><td><input type="checkbox"></td><td><div class="addon_picture"><img src="app/addons/icons/${addon.icon}" alt="icon"></div></td><td>${addon.name}</td></tr>`;
        })

        tbody.innerHTML = content;
    })
}

async function init_addonstoadd() {

    let content = "";
    const tbody = document.getElementById("list-addons-to-add");

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"list_addons",Name:server_name})
    });

    let addons = res.json();



    addons.then((value) => {
        let addons_left = value.filter((addon) => {
            return !listAddons.includes(addon.name) && addon.name !== null
        });

        addons_left.map((addon) => {
            content += `<tr><td><input type="checkbox"></td><td><div  class="addon_picture"><img src="app/addons/icons/${addon.icon}" alt="icon"></div></td><td>${addon.name}</td></tr>`;
        })

        tbody.innerHTML = content;
    })
}

async function get_server_logs(){
    const console_content_element = document.getElementById("console-content");

    while(1){

        let data = {gestion:"API",action:'get_server_logs',Name:server_name};

        res = await fetch(host_url + "/index.php",{
            method:"POST",
            body: new URLSearchParams(data)
        });

        if(res.ok){
            let returns = res.json();

            returns.then((value) => {
                console_content_element.innerText = value.output;
            })

            
            //display_server_logs(content.output);
        }else{
             console.log("error : " + res.status);
            break;
        }

        await sleep(1000);
    }
}

function add_command(){

    if(config_server_commands_input_element.value !== ""){
        commands.push(config_server_commands_input_element.value);
    }

    init_commands_table();
}

function init_commands_table(){
    let content = "";

    commands.map((command) => {
        content += `<tr >
                        <td><input type="checkbox"></td>
                        <td class="col col-12"><textarea type="hidden" name="commands[]" class="d-none">${command}</textarea>${command}</td><td></td>
                    </tr>`;
    })

    config_server_commands_table_tbody_element.innerHTML = content;
}

function remove_commands(){

    let lines = config_server_commands_table_tbody_element.childElementCount;

    for(let i = lines - 1; i >= 0; i--){
        if(config_server_commands_table_tbody_element.children[i].children[0].children[0].checked){
            commands.splice(i,1);
        }
    }

    init_commands_table();
}
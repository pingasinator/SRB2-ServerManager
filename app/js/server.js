const form_server_name = document.getElementById('form-server-name');

const server_name_element = document.getElementById('server-name')
const server_port_element = document.getElementById('server-port');
const server_time_element = document.getElementById('server-time');

const server_cpu_element = document.getElementById('server-cpu');
const server_ram_element = document.getElementById('server-ram');

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

const list_addons = document.getElementById("config-addons-background");

const gametype_changer_element = document.getElementById('gametype-changer');

let server_name;
let server_state;
let server_displaName;
let default_gametype;
let default_map;
let default_character;
let default_room;
let default_commands = [];


(async () => {
    await init_config();
})();


let listAddons = [];

async function init_config(){

    return await init_server_config().then(async () => {
        document.getElementById("form_server").action = `index.php?gestion=server&Name=${server_name}`;

        await init_server_gametype_selector(config_server_gametype_element,default_gametype).then(async (value) => {
            await init_map_selector('config-server-map',value,default_map);
        });

        await init_server_gametype_selector(gametype_changer_element,'').then(async (value) => {
            await init_map_selector('map-changer',value,'');
        });

        await init_server_forcecharacter_selector("config-server-forcecharacter",default_character);
        await init_server_forcecharacter_selector("character-changer",default_character);

        await init_server_addons("server-addons");
        await init_addonstoadd();
        init_rooms_selector("config-server-room",default_room);
        init_commands_table("config-server-commands-table",default_commands);
        await init_server_state();
         get_server_logs();

         get_server_resources();

        return 1;
    })
}

async function forceCharacter(){

    let character = document.getElementById("character-changer").value;

    let req = await fetch(host_url + "/index.php",{
        method:"post",
        body: new URLSearchParams({gestion:"API",action: 'force_server_character',Name:server_name,Character:character})
    });

    let res = req.json();

    res.then((data) => {
        sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
    })
}

async function set_time_and_point_limits(){

    let time = document.getElementById("timelimit-changer").value;
    let point = document.getElementById("pointlimit-changer").value;

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"set_time_and_point_limit",Name:server_name,Time:time,Point:point})
    })

    let res = req.json();

    res.then((data) => {
        sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
    })
}

async function init_server_config(){

    const name_element = document.getElementById("config-server-name");
    let url = new URL(window.location);
    let serverName = url.searchParams.get("Name");

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"get_server_config",Name:serverName})
    });

    let res = req.json();
    return await res.then((data) => {

        server_name = data.Name
        server_displaName = data.DisplayName;
        default_gametype = data.GameType;
        default_map = data.Map;
        default_character = data.ForceCharacter;
        default_room = data.Room;
        default_commands = data.Commands;
        commands = default_commands;

        form_server_name.value = data.Name;

        server_name_element.innerText = data.Name;
        server_port_element.innerText = data.Port;

        config_server_name_element.value = data.Name;
        config_server_displayName_element.value = data.DisplayName;
        config_server_motd_element.value = data.MOTD;
        config_server_maxplayers_element.value = data.MaxPlayers;

        config_server_timelimit_element.value = data.TimeLimit;
        config_server_pointlimit_element.value = data.PointLimit;
        config_server_allowdownload_element.checked = data.AllowDownload === "on";
        config_server_downloadsize_element.value = data.DownloadSize;

        config_server_port_element.value = data.Port;
        config_server_password_element.value = data.Password;
        config_server_masterserver_element.value = data.MasterServer;


        return 1;
    })
}

async function action(action){

    let req = await fetch(host_url + "/index.php",{
        method:"post",
        body: new URLSearchParams({gestion:"API",action: action + '_server',Name:server_name})
    });

    let res = req.json();

    res.then(async (data) => {
        sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
        await init_server_state();
    })
}

async function setMap(){
    const map = document.getElementById('map-changer');
    const gameType = document.getElementById('gametype-changer');

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:'API',action:'set_map',Name:server_name,GameType:gameType.value,Map:map.value})
    });

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
        });
    }else{
        console.log("error : " + req.status);
    }
}

async function sendCommand(){
    const command = document.getElementById('command');

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:'API',action:'send_command',Name:server_name,Command:command.value})
    });

    let res = req.json();

    if(req.ok){
        res.then((data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
        });
    }else{
        console.error("Error : " + req.status);
    }
}

async function add_addons(){

    let tbody = document.getElementById("list-addons-to-add");
    let lines = tbody.childElementCount;

    for(let i = 0;i < lines;i++){
        if(tbody.children[i].children[0].children[0].checked){

            let req = await fetch(host_url + "/index.php",{
                method:"POST",
                body: new URLSearchParams({gestion:"API",action:"add_addon_server",Name:server_name,addon:tbody.children[i].children[2].innerText})
            });

            if(req.ok){
                let res = req.json();

                res.then(async (data) => {
                    sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
                    await init_config();
                })
            }else{
                console.error("Error : " + req.status);
            }
        }
    }
}

async function remove_Addons(){

    let tbody = document.getElementById("server-addons");
    let lines = tbody.childElementCount;

    for(let i = 0;i < lines;i++){
        if(tbody.children[i].children[0].children[0].checked){

            let req = await fetch(host_url + "/index.php",{
                method:"POST",
                body: new URLSearchParams({gestion:"API",action:"remove_addon_server",Name:server_name,addon:tbody.children[i].children[2].innerText})
            });

            if(req.ok){
                let res = req.json();

                res.then(async (data) => {
                    sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
                    listAddons.splice(listAddons.indexOf(tbody.children[i].children[1].innerText),1);
                    await init_config();
                })
            }else{
                console.error("Error : " + req.status);
            }
        }
    }
}

async function init_server_gametype_selector(selector,selectedValue){

    let content = "";

    const req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"list_server_gametypes",Name:server_name})
    });

    if(req.ok){
        let res = req.json();
        
        let typeSelected = "co-op";
        let listGametypes = res.then((data) =>{
            data.map((gametype) => {
                content += `<option ${gametype.identifier === selectedValue ? "selected" : ""} value="${gametype.identifier}">${gametype.name}</option>`;
                typeSelected = gametype.identifier === selectedValue ? gametype.identifier : typeSelected;               
            });
            selector.innerHTML = content;
            return typeSelected;
        });
        return listGametypes;
    }else{
        console.log("error : " + req.status);
    }
}

async function init_map_selector(selectorId,typeSelected,selectedValue){

    let map_selector = document.getElementById(selectorId);
    let content = "";

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"get_server_maps_with_gametype",Name:server_name,TypeOfLevel:typeSelected})
    });


    if(req.ok){
        let res = req.json();

        res.then((data) => {
            data.map((map) => {
                content += `<option ${ map.id === selectedValue ? "selected" : ""} value="${map.id}">${map.levelname} ${map.ACT !== null && map.ACT !== '0' ? " Act " + map.ACT : ""}</option>`;
            })

            map_selector.innerHTML = content;
        });
    }else{
        console.error("Error : " + req.status);
    }

}

async function init_server_forcecharacter_selector(selectorID,selectedvalue) {

    const selector = document.getElementById(selectorID);
    let content = "";
            
    const req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:'API',action:"list_server_characters",Name:server_name})
    });

    if(req.ok){
        let res = req.json();
        res.then((value) =>{
            value.map((character) => {
                content += `<option ${character.skinName === selectedvalue ? "selected" : ""} value="${character.skinName}">${character.displayName != null ? character.displayName : character.skinName}</option>`;
            })
            selector.innerHTML = content;
        });
    }else{
        console.error("Error : " + req.status)
    }
}

async function init_server_addons(tbodyID){

    let content = "";
    listAddons = [];
    let tbody = document.getElementById(tbodyID);

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"list_server_addons",Name:server_name})
    });


    if(req.ok){
        let res = req.json();

        res.then((data) => {
            if(data.length !== 0){
                data.map((addon) => {

                    listAddons.push(addon);
                    content += `<tr><td><input type="checkbox"></td><td><div class="addon_picture"><img src="app/addons/icons/${addon.icon}" class="w-100" alt="icon"></div></td><td>${addon.name}</td></tr>`;
                })
            }else{
                content += `<tr class="h-100"><td colspan="3" class="text-center">no addons loaded</td></tr>`
            }

            tbody.innerHTML = content;
        })
    }else{
        console.error("Error : " + req.status);
    }
}

async function init_addonstoadd() {

    let content = "";
    const tbody = document.getElementById("list-addons-to-add");

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"list_addons",Name:server_name})
    });

    if(req.ok){
        let res = req.json();

        res.then((data) => {

            let e = listAddons.map((server_addon) => {
                return server_addon.name;
            });

            let addons_left = data.filter((addon) => {
                return !e.includes(addon.name) && addon.name !== null;
            });

            addons_left.map((addon) => {
                content += `<tr><td><input type="checkbox"></td><td><div  class="addon_picture"><img src="app/addons/icons/${addon.icon}" class="w-100" alt="icon"></div></td><td>${addon.name}</td></tr>`;
            })

            tbody.innerHTML = content;
        })
    }else{
        console.error("Error : " + req.status);
    }
}

async function get_server_logs(){
    const console_content_element = document.getElementById("console-content");

    while(1){

        if(server_state !== "inactive"){
            let data = {gestion:"API",action:'get_server_logs',Name:server_name};

            let req = await fetch(host_url + "/index.php",{
                method:"POST",
                body: new URLSearchParams(data)
            });

            if(req.ok){
                let res = req.json();

                res.then((value) => {
                    console_content_element.innerText = value.output;
                })

            }else{
                console.log("error : " + req.status);
                break;
            }
        }



        await sleep(1000);
    }
}

async function init_server_state(){

    const server_state_element = document.getElementById("server-state")

    let req = await fetch(host_url + "/index.php",{
        method: "POST",
        body: new URLSearchParams({gestion:"API",action:"get_server_state",Name:server_name})
    });

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            server_state = data;
            server_state_element.innerText = server_state;
        })
    }else{
        console.error("Error : " + req.status)
    }
}

async function refresh_players(){

    const tbody = document.getElementById("players-body");
    let content = "";

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"get_server_players",Name:server_name})
    });

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            if(data.length > 0){
                data.map((player) => {
                    content += `<tr>
                            <td >${player.node}</td>
                            <td >${player.name}</td>
                            ${player.ip === null || player.port === null ? "<td colspan='2'>disconnected</td>" : `<td>${player.ip}</td>\n<td>${player.port}</td>\n`}
                             <td class="text-end">
                                <button class="btn btn-sm btn-outline-warning" onclick="kick('${player.node}')">Kick</button> 
                                <button class="btn btn-sm btn-outline-danger" onclick="ban('${player.node}')">Ban</button>
                             </td>
                        </tr>`;
                })
            }else{
                content += `<tr><td colspan="5">no players found</td></tr>`
            }
            tbody.innerHTML = content;
        })
    }else{
        console.error("Error : " + req.status);
    }
}

async function refresh_bans(){
    const tbody = document.getElementById("bans-body");
    let content = "";

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"get_server_bans",Name:server_name})
    });

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            if(data.length > 0){
                data.map((ip) => {
                    content += `<tr><td>${ip}</td><td class="text-end"><button class="btn btn-primary" onclick="unban('${ip}')">unban</button></td></tr>`;
                })
            }else{
                content += `<tr><td colspan="2">no bans found</td></tr>`;
            }
            tbody.innerHTML = content;
        });
    }else{
        console.error("Error : " + req.status);
    }
}

async function kick(player){
    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"kick_server_player",Name:server_name,Node:player})
    })

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
            refresh_players();
        })
    }else{
        console.error("Error : " + req.status);
    }
}

async function ban(player){
    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"ban_server_player",Name:server_name,Node:player})
    })

    if(req.ok){

        let res = req.json();

        res.then(async (data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
            await refresh_players();
            await refresh_bans();
        });

    }else{
        console.error("Error : " + req.status);
    }
}

async function unban(ip){

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API", action:"unban", Name:server_name ,ip:ip})
    });

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
            refresh_bans();
        })
    }
}

async function clearBans(){
    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"server_clear_bans",Name:server_name})
    })

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
            refresh_bans();
        })
    }else{
        console.error("Error : " + req.status);
    }
}

async function send_message(){
    const message_element = document.getElementById("message-input");

    let req = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"send_server_message",Name:server_name,Message:message_element.value})
    })

    if(req.ok){
        let res = req.json();

        res.then((data) => {
            sendNotification(`<span>${data.output} <br> Code : ${data.code}</span>`,data.code === 0 ? "valide" : "error");
        })
    }else{
        console.error("Error : " + req.status);
    }
}

async function get_server_resources(){

    while(1){
        if(server_state !== "inactive") {
            let req = await fetch(host_url + "/index.php", {
                method: "POST",
                body: new URLSearchParams({gestion: "API", action: "get_server_resources", Name: server_name})
            });

            if (req.ok) {

                let res = req.json();

                res.then((data) => {
                    server_cpu_element.innerText = data.output.cpu + "%";
                    server_ram_element.innerText = data.output.ram + "MB";
                    server_time_element.innerText = data.output.time;
                })

            } else {
                console.error("Error : " + req.status);
            }
        }else{
            server_cpu_element.innerText = 0.0 + "%";
            server_ram_element.innerText = "0MB";
            server_time_element.innerText = "00:00";
        }

        await sleep(500);
    }

}


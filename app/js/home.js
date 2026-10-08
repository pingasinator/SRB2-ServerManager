
const server_name_element = document.getElementById('config-server-name');
const server_port_element = document.getElementById('config-server-port');
const server_maxplayers_element = document.getElementById('config-server-maxplayers');
const server_map_element = document.getElementById('config-server-map');
const server_gametype_element = document.getElementById('config-server-gametype');
const server_character_element = document.getElementById("config-server-forcecharacter");
const server_motd_element = document.getElementById("config-server-motd");
const server_masterserver_element = document.getElementById("config-server-masterserver");
const server_password_element = document.getElementById("config-server-password");
const server_timelimit_element = document.getElementById("config-server-timelimit");
const server_pointlimit_element = document.getElementById("config-server-pointlimit")
const server_allowdownload_element = document.getElementById("config-server-allowdownload");
const server_downloadsize_element = document.getElementById("config-server-downloadsize");
async function action(e){

    let list  = list_selected_servers();


    if(list.length > 0){
        list.map(async (server) =>{

            let res = await fetch(host_url + "/index.php",{
                method:"POST",
                body: new URLSearchParams({gestion:"API",action: e + '_server',Name:server})
            })

            let result = res.json();

            result.then(() => {
                list_Servers();
            })
        })
    }
}

async function create_server() {

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({
            gestion:"API",
            action:'create_server',
            Name:server_name_element.value,
            Port:server_port_element.value,
            MaxPlayers:server_maxplayers_element.value,
            GameType:server_gametype_element.value,
            Map:server_map_element.value,
            MOTD:server_motd_element.value,
            AllowDownload:server_allowdownload_element.value,
            DownloadSize:server_downloadsize_element.value,
            ForceCharacter:server_character_element.value,
            MasterServer:server_masterserver_element.value,
            Password:server_password_element.value,
            TimeLimit:server_timelimit_element.value,
            PointLimit:server_pointlimit_element.value,
            Commands:JSON.stringify(commands)
        })
    });

    let result = res.json();

    result.then((data) => {
        list_Servers();
    })
}

async function list_Servers(){

    check_all_element.checked = false;
    let content = "";
    servers_table_element.children[1].innerHTML = `<div>Loading <img id="loading_img" src="app/img/sonic-running.gif" alt="sonic_running"></div>`

    let res = await fetch(host_url + "/index.php", {
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:'list_servers'})
    })

    if(res.ok){
        let servers = res.json();

        servers.then((value) => {
            value.map((server) => {
                content += `<tr>
                                <td><input type="checkbox"></td>
                                <td><a href="index.php?gestion=server&Name=${server.server.Name}">${server.server.Name}</a></td>
                                <td>${server.server.DisplayName}</td>
                                <td class="state-${server.state}">${server.state}</td>
                                <td>${server.server.Port}</td>
                                <td>${server.server.Room === "38" ? "Custom" : server.server.Room === "28" ? "Casual" : server.server.Room === "33" ? "Standard" : "None"}</td>
                                <td>${server.server.MaxPlayers}</td>
                                <td>${server.server.Map}</td>
                                <td>${server.server.GameType}</td>
                                <td>${server.server.ForceCharacter}</td>
                            </tr>`;
            })

            servers_table_element.children[1].innerHTML = content;
        })
    }
}

function previewPicture(e){
    const previewImageElement = document.getElementById('previewImage')

    const [picture] = e.files

    if(picture){

        var reader = new FileReader();

        reader.onload = (e) => {
            previewImageElement.src = e.target.result
        }

        reader.readAsDataURL(picture)
    }
}

async function list_addons() {
    let content = "";

    const list_addons_element = document.getElementById("list-addons")

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API",action:"list_addons"})
    });

    let addons = res.json();

    addons.then((data) => {
        data.map((addon) => {
            if(addon.name != null){
                content += `<div class="card card_addon">
                                <div class="card-body d-flex flex-column gap-2">
                                    <div class="d-flex flex-row gap-2">
                                        <div class="addon_picture">
                                            <img src="app/addons/icons/${addon.icon}" alt="icon"/>
                                        </div>
                                        <div class="addon-info d-flex flex-column justify-content-between">
                                            <span><b>${addon.name}</b></span>
                                            <span>size : ${addon.size} MB</span>
                                        </div>
                                    </div>
                                    <div class="addon-description">
                                        ${addon.description}
                                    </div>
                                </div>
                                
                                <div class="card-bottom d-flex justify-content-between">
                                    <button class="btn btn-blue" onclick="Open('card_check_addon_background')">Check</button>
                                    <button class="btn btn-red" onclick="deleteAddon('${addon.name}')">Remove</button>
                                </div>
                            </div>`;
            }
        })

        list_addons_element.innerHTML = content;
    })

}

async function deleteAddon(addonName){

   const notification_element = document.getElementById("notification");
   let content = "";

    let res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams({gestion:"API", action:"delete_addon", Name:addonName})
    });

    let result = res.json();

    result.then(async (value) => {
        if(value.list_servers){
            Open("notification");
            content = `<span>you can't delete this addon ! <br>
                             you need to remove it from the servers : </span>
                            <ul>`;

            value.list_servers.map((server) => {
                content += `<li>${server}</li>`;
            })

            content += "</ul>";

            notification_element.innerHTML = content;
        }

        await sleep(5000).then(() => {
            Close("notification");
        });

        list_addons();
    })
}

list_Servers();
list_addons();
init_gametype_selector();
init_forcecharacter_selector("config-server-forcecharacter");
init_rooms_selector("config-server-room", '');
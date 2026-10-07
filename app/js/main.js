const host_url = "http://" + window.location.host + "/SRB2-ServerManager";

const servers_table_element = document.getElementById('server-table');

const list_servers_element = document.getElementById('list-servers');
const list_addons_element = document.getElementById('list-addons');

const check_all_element = document.getElementById('check_all');

function Open(containerId){
    let container = document.getElementById(containerId);
    container.classList.remove("d-none");
}

function Close(containerID){
    let container = document.getElementById(containerID);
    container.classList.add("d-none");
}

function SwitchContainer(containerId){
    let container = document.getElementById(containerId);
    Array.from(container.parentElement.children).map((child) => {
        child.classList.add("d-none");
    })

    container.classList.remove("d-none");
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

function init_gametype_selector(){
    let defaultGametypes = [
        "co-op",
        "competition",
        "race",
        "match",
        "tag",
        "ctf"
    ];

    for(let i = 0; i < defaultGametypes.length; i++){
        server_gametype_element.innerHTML += `<option value="${defaultGametypes[i]}">${capitalize(defaultGametypes[i])}</option>`;
    }

    init_map_selector("config-server-map",server_gametype_element.value,"");
}

async function init_map_selector(selectorId,typeSelected,selectedValue){

    map_selector = document.getElementById(selectorId);
    let content = "";
    let data = {gestion:"API",action:"list_maps"};

    res = await fetch(host_url + "/index.php",{
        method:"POST",
        body: new URLSearchParams(data)
    });

    let maps = res.json();

    maps.then((data) => {
        data.map((map) => {
            if(map.TypeOfLevel.includes(capitalize(typeSelected))){
                content += `<option ${ map.id === selectedValue ? "selected" : ""} value="${map.id}">${map.levelname} ${map.ACT !== null && map.ACT !== '0' ? " Act " + map.ACT : ""}</option>`;
            }
        })

        map_selector.innerHTML = content;
    });
}

function init_rooms_selector(selectorId,selectedValue){

    let rooms = [
        {value:"00",name:"None"},
        {value:"33",name:"Standard"},
        {value:"28",name:"Casual"},
        {value:"38",name:"Custom Gametype"}
    ]

    let content = "";

    room_selector = document.getElementById(selectorId);

    rooms.map((room) => {
        content += `<option value='${room.value}' ${selectorId === room.value ? "selected" : ""}>${room.name}</option>`;
    });

    room_selector.innerHTML = content;
}

function check_all_table_datas(value,tbodyID){
    const tbody = document.getElementById(tbodyID);

    let childcount = tbody.childElementCount;


    for(let i = 0; i < childcount; i++){
        tbody.children[i].children[0].children[0].checked = value;
        console.log(value);
    }
}

async function init_forcecharacter_selector(selectorID,selectedvalue) {

    const selector = document.getElementById(selectorID);

    let defaultCharacters = [
        "None",
        "Sonic",
        "Tails",
        "Knuckles",
        "Amy",
        "Fang",
        "MetalSonic"
    ]

    let content = "";

    defaultCharacters.map((character) => {
        content += `<option value='${character}'>${character}</option>`
    })

    selector.innerHTML = content;
}

function capitalize(string){
    let first = string.charAt(0);

    return first.toUpperCase() + string.slice(1);
}

async function sleep(ms){
    return new Promise((resolve) => {setTimeout(resolve,ms)})
}
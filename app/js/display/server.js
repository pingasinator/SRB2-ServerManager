function display_list_server_addons(addons){

    let content = "";

    console.log(addons);

    addons.map((name) => {
        content += `<tr><td><input type="checkbox"></td><td>${name}</td></td></tr>`;

    })
    list_server_addons_element.innerHTML = content;
}

function display_list_Addons_To_Add(listAddons){
    const list_addons_to_Add_element = document.getElementById("list-addons-to-add");

    let content = "";

    listAddons.map((value) => {
        content += `<tr><td><button onclick="loadAddon('${value.name}')">${value.name}</button></td></tr>`;
    })

    list_addons_to_Add_element.innerHTML = content;
}

function display_list_Characters(characters){

    let content = "";
    const list_characters_element = document.getElementById("form_list_characters");
    const default_characters_element = document.getElementById("form_default_character");

    characters.map((character) => {
        content += `<option ${character.skinName === default_characters_element.value ? "selected" : ""} value="${character.skinName}">${character.displayName != null ? character.displayName : character.skinName}</option>`;
    })

    list_characters_element.innerHTML = content;
}

function display_form_addons(){
    const form_addons = document.getElementById("form_addons");

    form_addons.classList.remove("d-none");
}

function hide_form_addons(){
    const form_addons = document.getElementById("form_addons");

    form_addons.classList.add("d-none");
}

function display_list_form_maps(){

    const form_list_gametypes = document.getElementById("form_list_gametypes");
    const form_list_maps = document.getElementById("form_list_maps");
    const form_default_map = document.getElementById("form_default_map");

    if(form_list_gametypes.value !== ""){
        $.ajax({
            url: host_url + "/index.php",
            method:"POST",
            data:{gestion:'API',action:'get_server_maps_with_gametype',Name:name.value,TypeOfLevel:form_list_gametypes.value},
            success:function(data){
                let Maps = JSON.parse(data);
                let content = "";

                Maps.map((map) => {
                    content += `<option ${map.id === form_default_map.value ? "selected" : ""} value="${map.id}">${map.levelname} ${map.ACT !== null && map.ACT !== '0' ? " Act " + map.ACT : ""}</option>`;
                });
                form_list_maps.innerHTML = content;
            },
            error:function (){
                console.log("error");
            }
        })
    }
}

function display_server_logs(logs){
    const console_content_element = document.getElementById("console-content");
    console_content_element.innerText = logs;
}

function display_server_rooms(){
    const form_element = document.getElementById("form_room");
    let content = "";
    let Rooms = [
        {name:"None",value:"00"},
        {name:"Standard",value:"33"},
        {name:"Casual",value:"28"},
        {name:"None",value:"31"},
        {name:"Custom Gametypes",value:"38"}
    ]

    Rooms.map((room) => {
        content += `<option value="${room.value}">${room.name}</option>`;
    })

    form_element.innerHTML = content;
}

display_server_rooms();
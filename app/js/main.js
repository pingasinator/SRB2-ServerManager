const host_url = "";

const server_form_element = document.getElementById('server');
const server_search_element = document.getElementById("server");
const servers_table_element = document.getElementById('server-table');

const list_servers_element = document.getElementById('list-servers');

const check_all_element = document.getElementById('check_all');

function display_form_server()
{
    server_form_element.classList.remove("hidden");
}

function hide_form_server()
{
    server_form_element.classList.add("hidden");
}

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

function action(e){

    let list  = list_selected_servers();

    if(list.length > 0){
        list.map((server) =>{
            $.ajax({
                url: host_url + "/index.php",
                method:"post",
                data:{action: e + '_server',Name:server},
                success:function(data){
                    console.log(data);
                },
                error:function (){
                    console.log("error");
                }
            })
        })
    }

    list_Servers();
}

function list_Servers(){

    check_all_element.checked = false;

    $.ajax({
        url: host_url + "/index.php",
        method:"POST",
        data:{action:'list_servers'},
        success:function(data){
            let content = "";
            let servers = JSON.parse(data);
            servers.map((value) => {
                content += `<tr>
                            <td><input type="checkbox"></td>
                            <td>${value.server.Name}</td>
                            <td>${value.state ? 'active' : 'inactive'}</td>
                            <td>${value.server.Port}</td>
                            <td>${value.server.MaxPlayers}</td>
                            <td>${value.server.Map}</td>
                            <td>${value.server.GameType}</td>
                    </tr>`;
            })

            servers_table_element.children[1].innerHTML = content;
        },
        error:function (){
            console.log("error");
        }
    })
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

list_Servers();
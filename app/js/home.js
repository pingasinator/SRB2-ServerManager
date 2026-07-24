
const check_all_element = document.getElementById('check_all');


function action(e){

    let list  = list_selected_servers();

    if(list.length > 0){
        list.map((server) =>{
            $.ajax({
                url: host_url + "index.php",
                method:"post",
                data:{gestion:"API",action: e + '_server',Name:server},
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

    servers_table_element.children[1].innerHTML = `<div>Loading <img id="loading_img" src="app/img/sonic-running.gif" alt="sonic_running"></div>`

    $.ajax({
        url: host_url + "index.php",
        method:"POST",
        data:{gestion:"API",action:'list_servers'},
        success:function(data){
            console.log(data);
            let content = "";
            let servers = JSON.parse(data);
            servers.map((value) => {
                content += `<tr>
                                <td><input type="checkbox"></td>
                                <td><a href="index.php?gestion=server&Name=${value.server.Name}">${value.server.Name}</a></td>
                                <td>${value.state}</td>
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




function display_form_server()
{
    server_form_element.classList.remove("hidden");
}

function hide_form_server()
{
    server_form_element.classList.add("hidden");
}

list_Servers();
generate_Map_selector();
generate_gametype_selector();
$(document).ready(() => {
    let received_object = null;

    $("#get_data_btn").on("click", () => {
        $.ajax({
            url: "https://jsonplaceholder.typicode.com/albums",
            method: "GET",
            success: data => {
                try{
                    if(!data) throw new Error("No data was retrieved. Please try again.");
                    received_object = data;
                
                    let placeholder = $("#data_output");
                    let out = "";
                    console.log(received_object);

                    for(let obj of received_object){
                        out += `
                            <tr>
                                <td>${obj.userId}</td>
                                <td>${obj.id}</td>
                                <td>${obj.title}</td>
                            </tr>
                        `
                        //console.log(out);
                    }

                    console.log(out);

                    placeholder.html(out);

                }catch(e){
                    console.log(e);
                    alert(e);
                }
            }
        });
    });

    $("#clear_data_btn").on("click", () => {
        $("#data_output").html("");
    })

})
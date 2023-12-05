$(document).ready(function() {
    let index;
    let received_object = null;
    let key;

    $("#page_2").hide();
    
    $(".input_button").on("click", function(){
        index = $("#input_box1").val();
        key = $("#input_box2").val();
        console.log(index);
        console.log(key);

    
    //     fetch("https://jsonplaceholder.typicode.com/comments")
    //         .then(response => {
    //             return response.json();
    //         })

    //         .then(data => {
    //             console.log(typeof data);
    //             received_object = data;
    //             console.log(received_object);

    //             if(index < 0 || index >= received_object.length){
    //                 alert("Index out of range. Please enter another.");
    //                 //backToHome();
    //                 throw new Error("Please enter a valid index");
    //             }

    //             if(!(key in received_object[index])){
    //                 alert("Key not in the object. Please enter another.");
    //                 //backToHome();
    //                 throw new Error("Please enter a valid key");
    //             }

    //             $(".content").html(received_object[index][key]);
    //             goToPage2();
    //             //alert("mana og fetch");
    //         })
    //         .catch(e => {
    //             console.log(e);
    //             //backToHome();
    //         })
        $.ajax({
            url: "https://jsonplaceholder.typicode.com/comments",
            method: "GET",
            success: data => {
                received_object = data;
                try{
                    alert("kasulod");
                    if(index < 0 || index >= received_object.length){
                        throw new Error("Index out of range. Please enter another.");
                    }

                    if(!(key in received_object[index])){
                        throw new Error("Key not in object. Please enter another.");
                    }
                    
                    console.log(received_object);
                    $(".content").html(received_object[index][key]);
                    goToPage2();

                }catch(e){
                    console.log(e);
                }
            }
        });
    });


    $(".counter").click(function() {
        index++;
        if(!received_object) alert("naay something wrong...")
        if (index < received_object.length) {
            $(".content").html(received_object[index][key]);
        } else {
            console.log("Index out of bounds");
        }
        
      });

});

function backToHome(){
    $("#page_2").hide();
    $("#page_1").show();
}

function goToPage2(){
    $("#page_1").hide();
    $("#page_2").show();
}


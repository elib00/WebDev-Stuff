$(document).ready(() => {
    $(function(){
        let game_code;
        let card_token;
        let received_object;
    
        $(".page_2").hide();
    
        $("#verify").on("click", function(){
    
            game_code = $("#get_game_code").val();
            $.ajax({
                url: `http://www.hyeumine.com/getcard.php?bcode=${game_code}`,
                method: "GET",
                success: (data)=>{
                    try{
                        received_object = JSON.parse(data);
                        if (!received_object) throw new Error("Invalid Code");
                        card_token = received_object.playcard_token;
                        console.log(card_token);
                        console.log(data);
                        console.log(received_object);
                        $(".page_1").hide();
                        $("#display_gcode").text(`Game Code: ${game_code}`);
                        createTable();
                        $(".page_2").fadeIn();
                    }catch(e){
                        alert(e.message);
                    }        
                }
            });    
        }); 
    
        $("#get_new_code").on("click", function(){
            $(".page_2").fadeOut();
            setTimeout(() => {
                $(".page_1").fadeIn("slow");
                $("#get_game_code").val("");
                // $("#card").html("");
                $("tbody td").removeClass("color_changer");
            }, 800);
        });
    
        $("#get_new_card").on("click", function(){
            $("#game_grid").fadeOut();
            $.ajax({
                url: `http://www.hyeumine.com/getcard.php?bcode=${game_code}`,
                method: "GET",
                success: (data)=>{
                    try{
                        received_object = JSON.parse(data);
                        if (!received_object) throw new Error("Invalid Code");
                        card_token = received_object.playcard_token;
                        console.log(card_token);
                        console.log(data);
                        console.log(received_object);
                        // $("#card").html("");
                        $("tbody td").removeClass("color_changer");
                    }catch(e){
                        alert(e.message);
                    }        
                }
            });
    
            setTimeout(() => {
                createTable();
                $("#game_grid").fadeIn("slow");
            }, 300);
        });
    
        $("#check_win").on("click", function(){
            $.ajax({
                url: `http://www.hyeumine.com/checkwin.php?playcard_token=${card_token}`,
                method: "GET",
                success: (data)=>{
                    try{
                        if(data){
                            alert("BINGO! CONGRATULATIONS!");
                        }else{
                            alert("Sorry. Better luck next time, pal.");
                        }
                        
                    }catch(e){
                        alert(e.message);
                    }        
                }
            });
    
        });
    
    
        $("#go_to_dashboard").click(function(e){
            e.preventDefault();
            window.open(`http://www.hyeumine.com/bingodashboard.php?bcode=${game_code}`);
        });
    
    
    
        function createTable(){
            let bingo_num = document.querySelectorAll("#card td:not(#card_header)");
            let i = 0;
            let data = received_object;
            bingo_card = [
                data.card.B,
                data.card.I,
                data.card.N,
                data.card.G,
                data.card.O,
            ];
    
            for (let y = 0; y < 5; y++) {
                for (let x = 0; x < 5; x++) {
                    bingo_num[i].innerHTML = bingo_card[y][x];
                    i++;
                }
            }
        }
    
        $("tbody td").on("click", function(){
            $(this).toggleClass("color_changer");
        });
    
    
    });
})

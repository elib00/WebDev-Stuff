$(document).ready(() => {
    $("#submit_btn").on("click", () => {
        
        let choice = $("#drop_down").val();
        console.log(choice);
        console.log(typeof choice);

    });
});
let user_id = null;
let posts = null;
let username = null;
let current_page = 1;

let page_count = 20;
let max_pages = 0;

function getPostsSize(){
    $.ajax({
        url: "http://hyeumine.com/forumGetPosts.php",
        method: "GET",
        success: (data) => {
            data = JSON.parse(data);
            max_pages = Math.round(data.length / page_count);
            console.log(max_pages);
        }
    });
}

function getPosts(){
    if(current_page <= 0){
        current_page++;
    }else if(current_page > max_pages){
        current_page--;
    } 

    obj = {page: current_page};

    $.ajax({
        url: "http://hyeumine.com/forumGetPosts.php",
        data: obj,
        method: "GET",
        success: (data) => {
            data = JSON.parse(data);
            posts = data;
            generatePostBox();
        }
    });
}

function generatePostBox(){
    $("#posts-container").html("");
    let layout = ``;
    console.log(posts);

    for(let i = 0; i < posts.length; i++){
        if(posts[i].post.length <= 0){
            continue;
        }

        let buff = ``;
        
        if(posts[i]?.reply){
            for(let j = posts[i].reply.length - 1; j >= 0; j--){
                buff += `
                    <div id="reply-wrapper-${posts[i].reply[j].id}" class="reply-wrapper">
                        <p><b>${posts[i].reply[j].user}</b><p>
                        <p id="rel-${posts[i].reply[j].id}">${posts[i].reply[j].reply}</p>
                        <button id="delreply-${posts[i].reply[j].id}" type="button" class="btn btn-success" onclick="deleteReply()">Delete</button>
                    </div>
                `
            }
        }

        layout += `
                <div id="post_${posts[i].id}" class="post-box">
                    <div style="flex: 1;">
                        <p><b>${posts[i].user}</b><p>
                        <p>${posts[i].post}</p>
                    </div>
                    <div class="reply-box">${buff}</div>

                    <div class="form-floating mb-3" style="width: 100%;">
                        <input id="reply-box-${posts[i].id}" type="text" class="form-control" placeholder="">
                        <label>What are your thoughts?</label>
                    </div>
                    <button id="reply-${posts[i].id}" type="button" class="btn btn-success" onclick="replyPost()">Reply</button>
                    <div    
                        style="height: 60px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="margin-left: 10px;">${posts[i].date}</div>
                    
            ` 
                    
            if(user_id == posts[i].uid){
                layout +=  `<button id="${posts[i].id}" class="btn btn-success delete-btn" type="button" onclick="deletePost()">Delete Post</button>`
            }
            
            layout += ` 
                    </div>
                </div>
            `
    }

    $("#posts-container").html(layout);
}

function changeInputToError(id1, id2){
    $(`#${id1}`).addClass("is-invalid");
    $(`#${id2}`).addClass("is-invalid");
}

function changeInputToSuccess(id1, id2){
    $(`#${id1}`).removeClass("is-invalid");
    $(`#${id2}`).removeClass("is-invalid");
}

function goToHomePage(){
    $("#login-page").hide();
    $("#home-page").show();
}


function validateUser(){
    let firstname = $("#login-firstname-input").val();
    let lastname = $("#login-lastname-input").val();
    username = firstname + " " + lastname;

    let obj = {username: firstname + " " + lastname};
    $.ajax({
        url: "http://hyeumine.com/forumLogin.php",
        method: "POST",
        data: obj,
        success: (data) => {
            data = JSON.parse(data);
            if(data.success){
                console.log(data);
                user_id = data.user.id;
                changeInputToSuccess("login-firstname-input", "login-lastname-input");
                $("#welcome-message").html(
                `<p style="text-align: center; font-size: 30px; margin-top: 20px"><b>Hello, ${data.user.username}!</b></p>`
                );
                getPosts();
                goToHomePage();
            }else{
                changeInputToError("login-firstname-input", "login-lastname-input");
            }
        }

    });
}

function createUser(){
    let firstname = $("#signup-firstname-input").val();
    let lastname = $("#signup-lastname-input").val();

    let obj = {username: firstname + " " + lastname};

    //check if user already exists
    $.ajax({
        url: "http://hyeumine.com/forumLogin.php",
        method: "POST",
        data: obj,
        success: (data) => {
            data = JSON.parse(data);
            let output = ``;
            if(data.success){
                output = `
                    <div class="alert alert-danger" role="alert"
                    style="margin-top: 10px; text-align: center;">
                    User Already Exists!
                    </div>
                `;
                changeInputToError("signup-firstname-input", "signup-lastname-input");
            }else{
                //create the user if it doesn't exist
                output = `
                    <div class="alert alert-success" role="alert"
                    style="margin-top: 10px; text-align: center">
                    User Created Successfully!
                    </div>
                `;

                $.ajax({
                    url: "http://hyeumine.com/forumCreateUser.php",
                    method: "POST",
                    data: obj,
                    success: () => {
                        changeInputToSuccess("signup-firstname-input", "signup-lastname-input");
                    }
                });
            }

            $("#feedback-message").html(output);
            $("#feedback-message").fadeIn();
            setInterval(() => {
                $("#feedback-message").fadeOut();
            }, 3000);

           
        }

    });
}

function createNewPost(){
    let post = $("#post-textarea").val();
    let obj = {id: user_id, post: post};
    $.ajax({
        url: "http://hyeumine.com/forumNewPost.php",
        method: "POST",
        data: obj,
        success: (data) => {
            data = JSON.parse(data);
            console.log(data);
            current_page = 1
            getPosts();
        }
    });
}


function deletePost(){
    let btn_id = event.target.id;
    console.log(typeof btn_id);
    let target = event.target;
    $.ajax({
        url: `http://hyeumine.com/forumDeletePost.php?id=${btn_id}`,
        method: "GET",
        success: (data) => {
            console.log(data);
            target.closest(".post-box").remove();
            // $(`#post_${btn_id}`).remove();
            getPosts();
        }
    });
  
}

function deleteReply(){
    let btn_id = event.target.id;
    btn_id = btn_id.split("-")[1];
    let target = $(event.target)
    $.ajax({
        url: `http://hyeumine.com/forumDeleteReply.php?id=${btn_id}`,
        method: "GET",
        success: (data) => {
            console.log(data);
            target.parent(".reply-wrapper").remove();
            // $(`#reply-wrapper-${btn_id}`).remove();
        }
    });
    
    
}

function replyPost(){
    let reply_id = event.target.id;
    reply_id = reply_id.split("-")[1];
    let reply_text = $(`#reply-box-${reply_id}`).val(); 

    obj = {user_id: user_id, post_id: reply_id, reply: reply_text};
    $.ajax({
        url: "http://hyeumine.com/forumReplyPost.php",
        method: "POST",
        data: obj,
        success: (data) => {
            console.log(data);
            getPosts();
            generatePostBox();
        }
    });
   
}

//main function

$(function() {
    $("#home-page").hide();
    getPostsSize();

    $("#login-btn").click(() => {
        validateUser();
    });

    $("#create-user-btn").click(() => {
        createUser();
    });

    $("#signup-btn").click(() => {
        changeInputToSuccess("signup-firstname-input", "signup-lastname-input");
    });

    $("#upload-post-btn").click(() => {
        createNewPost();
    });

    $("#prev-btn").on("click", function(){
        current_page--;
        getPosts();
    });

    $("#next-btn").on("click", function(){
        current_page++;
        getPosts();
    });
});



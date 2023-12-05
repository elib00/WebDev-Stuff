<?php
ini_set("session.gc_maxlifetime", 3600);
session_start();

include("api.php");
//verify if the user is already in users.json
function getUser($username){
    $usersData = getUsersData();
    foreach($usersData as $user){
        if($user["username"] == $username){
            return $user;
        }
    }

    return null;
}


//save the current user in the session
function permitLogin($user){
    $_SESSION["user"] = json_encode($user, true);
}

//end the session
function logoutUser(){
    unset($_SESSION["user"]);
    session_destroy();
}

function createNewUserID(){
    $id = 0;
    $data = getUsersData();
    foreach($data as $userData){
        $id = $userData["id"];
    }

    return $id + 1;
}

function createNewPostID(){
    $id = 0;
    $data = getPostsData();
    foreach($data as $postData){
        $id = $postData["id"];
    }

    return $id + 1;
}

function createNewCommentID(){
    $id = 0;
    $data = getCommentsData();
    foreach($data as $commentData){
        $id = $commentData["id"];
    }

    return $id + 1;
}

function deletePost($post_id){
    global $postsJSON, $commentsJSON;
    $postsData = getPostsData();

    foreach($postsData as $index => $post){
        if($post["id"] === intval($post_id)){
            unset($postsData[$index]);
            break;
        }
    }


    $temp = array();
    foreach($postsData as $post){
        $temp[] = $post;
    }

    file_put_contents($postsJSON, json_encode($temp, JSON_PRETTY_PRINT));

    $commentsData = getCommentsData();

    foreach($commentsData as $index => $comment){
        if($comment["postId"] === intval($post_id)){
            unset($commentsData[$index]);
        }
    }
    
    file_put_contents($commentsJSON, json_encode($commentsData, JSON_PRETTY_PRINT));

}

function deleteComment($comment_id){
    global $commentsJSON;
    $commentsData = getCommentsData();

    foreach($commentsData as $index => $comment){
        if($comment["id"] === intval($comment_id)){
            unset($commentsData[$index]);
            break;
        }
    }

    $temp = array();
    foreach($commentsData as $comment){
        $temp[] = $comment;
    }

    file_put_contents($commentsJSON, json_encode($temp, JSON_PRETTY_PRINT));
}
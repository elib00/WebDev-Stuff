<?php
include("utility.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $comment = htmlspecialchars($_POST["comment"]);
    $user = json_decode($_SESSION["user"], true);

    global $commentsJSON;

    $new_comment = [
        "postId" => $_POST["post-id"],
        "id" => createNewCommentID(),
        "name" => $user["name"],
        "email" => $user["email"],
        "body" => $comment
    ];

    $comments_array = getCommentsData();
    $comments_array[] = $new_comment;

    file_put_contents($commentsJSON, json_encode($comments_array, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit();

}
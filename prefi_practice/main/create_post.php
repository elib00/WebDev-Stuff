<?php
include("utility.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $post_title = htmlspecialchars($_POST["post-title"]);
    $post_content = htmlspecialchars($_POST["post-content"]);
    $user = json_decode($_SESSION["user"], true);
    global $postsJSON;
    // global $currentUser;

    $new_post = [
        "uid" => $user["id"],
        "id" => createNewPostID(),
        "title" => $post_title,
        "body" => $post_content
    ];

    $posts_array = getPostsData();
    $posts_array[] = $new_post;
    file_put_contents($postsJSON, json_encode($posts_array, JSON_PRETTY_PRINT));
    header("Location: ?post_successful");
    exit();
}

?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='styles.css'>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <div class="container">
        <?php
        // var_dump($_SESSION["user"]);
        if(isset($_SESSION["user"])){
            if(isset($_SESSION["user"])){
                echo '<form action="create_post.php" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="post-title" name="post-title" placeholder="post-title">
                            <label for="post-title">Post Title</label>
                        </div>
                        <div class="mb-3">
                            <label for="post-content" class="form-label" style="color: white; font-size: 20px">Post Content</label>
                            <textarea class="form-control" id="post-content" name="post-content" 
                            rows="4" style="resize: none" placeholder="Share something..."></textarea>
                        </div>
                        <div style="width: 100%; display: flex; justify-content: center; align-items: center"><button type="submit" class="btn btn-success" style="width: 20%">Post</button></div>
                        <div class="line-divider" style="margin-top: 20px; margin-bottom: 10px; border: solid rgb(113, 121, 126) 5px; border-radius: 10px"></div>
                    </form>';
            }
            
            if(isset($_GET["post_successful"])){
                echo '<div class="alert alert-success mt-3" role="alert">Post Created Successfully.</div>';
                // header("Location: index.php");
            ?>
            
            <script>
                setTimeout(function () {
                    window.location.href="index.php";
                }, 2000);
            </script>

            <?php
                echo getPosts();
            }
        }
        ?>
    </div>
</body>

</html>
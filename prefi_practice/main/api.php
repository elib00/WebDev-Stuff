<?php


// users JSON
$usersJSON = '../data/users.json';

// posts JSON
$postsJSON = '../data/posts.json';

// comments JSON
$commentsJSON = '../data/comments.json';

$currentUser = null;

if (isset($_SESSION["user"])) {
    $currentUser = json_decode($_SESSION["user"], true);
}

// function get users from json
function getUsersData()
{
    global $usersJSON;
    if (!file_exists($usersJSON)) {
        echo 1;
        return [];
    }

    $data = file_get_contents($usersJSON);
    return json_decode($data, true);
}

// function get posts from json
function getPostsData()
{
    global $postsJSON;
    if (!file_exists($postsJSON)) {
        echo 1;
        return [];
    }

    $data = file_get_contents($postsJSON);
    return json_decode($data, true);
}

// function get comments from json
function getCommentsData()
{
    global $commentsJSON;
    if (!file_exists($commentsJSON)) {
        echo 1;
        return [];
    }

    $data = file_get_contents($commentsJSON);
    return json_decode($data, true);
}


function getPosts()
{
    global $currentUser;
    $users = getUsersData();

    $posts = getPostsData();

    $comments = getCommentsData();

    $postsarr = array();

    foreach ($posts as $post) {
        foreach ($users as $user) {
            if ($user['id'] == $post['uid']) {
                $post['uid'] = $user;
                break;
            }
        }
        $post['comments'] = array();
        foreach ($comments as $comment) {
            if ($post['id'] == $comment['postId']) {
                $post['comments'][] = $comment;
            }
        }
        $postarr[] = $post;
    }
    $str = "";

    foreach ($postarr as $parr) {


    $str .= '
    <!-- start of post -->
    <div class="row">
        <div class="col-md-12">
            <div class="post-content">

              <div class="post-container">
                <img src="https://ui-avatars.com/api/?rounded=true&name=' . $parr['uid']['name'] . '" alt="user" class="profile-photo-md pull-left">
                <div class="post-detail">
                  <div class="user-info">
                    <h5><a href="timeline.html" class="profile-link" style="color: black; text-decoration: none; font-size: 20px"; font-weight: bold>' . $parr['uid']['username'] . '</a></h5>' . 
         
                
                '
                </div>
                  <div class="reaction">
                    <a class="btn text-green"><i class="fa fa-thumbs-up"></i> 13</a>
                    <a class="btn text-red"><i class="fa fa-thumbs-down"></i> 0</a>
                  </div> ' . 

                         // continuation
                (($currentUser && $currentUser["id"] === $parr["uid"]["id"]) ?
                '<form action="delete_post.php" method="post" class="delete-post">
                    <input type="hidden" name="post-id" value="' . $parr["id"] . '">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>'
                : "")
                . 
                  '
                  <div class="line-divider"></div>
                  <div class="post-text">
                    <h3>' . $parr['title'] . '</h3>
                    <p>' . $parr['body'] . '</p>
                  </div>
                  <div class="line-divider"></div>';
        foreach ($parr['comments'] as $comm)
        $str .=  '<div class="post-comment">
        <img src="https://ui-avatars.com/api/?rounded=true&name=' . $comm['name'] . '" alt="" class="profile-photo-sm">
        <p>' . $comm['body'] . '</p>' .
    (($currentUser && $currentUser["name"] === $comm["name"]) ?
        '<form class="ms-auto" action="delete_comment.php" method="post">
                <input type="hidden" name="comment-id" value="' . $comm["id"] . '">
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>'
        : "")
    . '</div>';

    if ($currentUser) {
        $str .= '<form action="create_comment.php" method="post">
                    <div class="mb-3">
                        <label for="comment" class="form-label" style="margin-top: 10px">What are your thoughts?</label>
                        <textarea class="form-control" id="commment" name="comment" rows="3" style="resize: none"></textarea>
                        <input type="hidden" name="post-id" value="' . $parr["id"] . '">
                    </div>
                    <button type="submit" class="btn btn-warning">Comment</button>
                </form>';
    }

        $str .= '</div>
              </div>
            </div>

        </div>
    </div>';
    }
    return $str;
}

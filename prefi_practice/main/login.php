<?php
include("utility.php");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $user = getUser(htmlspecialchars($_POST["username-input"]));
    if($user){
        permitLogin($user);
        header("Location: index.php");
        exit();
    }

    header("Location: ?user_not_found");
    exit();
}
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr. net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <?php include("header.php"); ?>
        <div class="container" style="display: flex; flex-direction: column; gap: 10px; justify-content: center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" style="display: flex; flex-direction: column; gap: 10px; align-items: center; padding-bottom: 10px">
                <div class="form-floating mb-3" style="width: 100%">
                    <input type="text" class="form-control" id="username-input" name="username-input" placeholder="Username" required>
                    <label for="username-input">Username</label>
                </div>
                <button type="submit" class="btn btn-success" style="width: 30%">Login</button>
            </form>
            <?php
            if(isset($_GET["user_not_found"])){
                echo '<div class="alert alert-danger style="width: 90%" role="alert">
                    User not found. Please check input details. </div>
                    ';
                ?>
                <script>
                    setTimeout(function() {
                       window.location.href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>";
                    }, 3000);
                </script>

            <?php
                exit();
            }?>

        </div>
    </body>
</html>
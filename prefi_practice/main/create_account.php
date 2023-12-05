<?php
include("utility.php");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = htmlspecialchars($_POST["username-input"]);
    $user = getUser($username);
    if($user === null){
        $new_user = [
            "id" => createNewUserID(),
            "name" => htmlspecialchars($_POST["name-input"]),
            "username" => htmlspecialchars($_POST["username-input"]),
            "address" => [
                "street" => htmlspecialchars($_POST["street-input"]),
                "barangay" => htmlspecialchars($_POST["barangay-input"]),
                "city" => htmlspecialchars($_POST["city-input"])
            ]

        ];
        
        global $usersJSON;
        $users_array = getUsersData();
        $users_array[] = $new_user;
        //save the current user
        $_SESSION["newly_created_user"] = $new_user;
        file_put_contents($usersJSON, json_encode($users_array, JSON_PRETTY_PRINT));
        header("Location: ?create_account_success");
        exit();
    }

    header("Location: ?create_account_error");
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name-input" name="name-input" placeholder="Name" required>
                <label for="name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username-input" name="username-input" placeholder="Username" required>
                <label for="username-input">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email-input" name="email-input" placeholder="Email" required>
                <label for="email-input">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="street-input" name="street-input" placeholder="Street" required>
                <label for="street-input">Street</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="barangay-input" name="barangay-input" placeholder="Barangay" required>
                <label for="barangay-input">Barangay</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="city-input" name="city-input" placeholder="City" required>
                <label for="city-input">City</label>
            </div>
            <button type="submit" class="btn btn-success">Create Account</button>
            <?php
            if (isset($_GET["create_account_error"])) {
                echo '<div class="alert alert-danger mt-3" role="alert">User already exists.</div>';
            } elseif (isset($_GET["create_account_success"])) {
                echo '<div class="alert alert-success mt-3" role="alert">User Created Successfully.</div>';
                permitLogin($_SESSION["newly_created_user"]);
            ?> 

            <script>
                setTimeout(function() {
                    window.location.href="index.php";
                }, 3000);
            </script>

            <?php
            }
            ?>
        </form>
    </div>
</body>

</html>
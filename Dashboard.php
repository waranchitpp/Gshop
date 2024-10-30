<?php
session_start();
require "connect_db.php";

if (!isset($_SESSION['User_login'])) {
    // Redirect to login if User_Id is not set in the session
    header("Location: login.php");
    //exit();
}

$User_Id = $_SESSION['User_login'];

//try {
// $stmt = $pdo->prepare("SELECT * FROM users WHERE Id = ?");
// $stmt->execute([$User_Id]);
// $userData = $stmt->fetch(PDO::FETCH_ASSOC);

//if (!$userData) {
//      // Handle case where user is not found
//     echo "User not found.";
//     exit();
//  }
//} catch (PDOException $e) {
//echo "Error: " . $e->getMessage();
//exit();
//}
//
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>

    <!-- Navbar -->
    <?php include('nav.php'); ?>

    <!-- Heroes -->
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4" src="path_to_logo/bootstrap-logo.svg" alt="" width="72" height="57">
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <h1 class="display-5 fw-bold">Welcome </h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4"></p>
            <?php

            if (isset($_SESSION['User_login'])) {
                $userId = $_SESSION['User_login'];

                // Prepare and execute the SQL query
                try {
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE Id = ?");
                    $stmt->execute([$userId]);

                    // Fetch and display the data
                    while ($row = $stmt->fetch()) {
                        echo "User ID: " . $row['Id'] . "<br>";
                        echo "Email: " . $row['Email'] . "<br>";
                        // Display other desired data from the database
                    }
                } catch (PDOException $e) {
                    // Handle any errors
                    echo "Error: " . $e->getMessage();
                }
            }

            ?>
            </p>
        </div>
    </div>
    </div>
    </div>

    <!-- Album content -->
    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
<?php
session_start();
require "connect.php";

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

$User_Id = $_SESSION['admin_login'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE Id = ?");
                $stmt->execute([$User_Id]);
                while ($row = $stmt->fetch()) {
                    echo "admin: " . $row['Id'] . "<br>";
                    echo "Email: " . $row['Email'] . "<br>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </div>
    <!-- Album content -->
    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>

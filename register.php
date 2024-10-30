<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Custom Login & Register CSS -->
    <link rel="stylesheet" href="custom.css">
</head>
<body>
<?php include('nav.php');?>

<main class="form-signin w-100 m-auto">
    <form action="register_db.php" id="registerForm" method="POST">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <?php if(isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>

        <?php if(isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <div class="form-floating my-2">
            <input type="text" class="form-control" name="Username" placeholder="Username">
            <label for="username">Username</label>
        </div>

        <div class="form-floating my-2">
            <input type="email" class="form-control" name="Email" id="floatingInput" placeholder="Email address">
            <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating my-2">
            <input type="password" class="form-control" name="Password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-floating my-2">
            <input type="password" class="form-control" name="Confirm_Password" id="floatingPassword" placeholder="Confirm Password">
            <label for="floatingPassword">Confirm Password</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>

        <button class="btn btn-primary w-100 py-2" name="register" type="submit">Sign in</button>
    </form>
</main>

<div class="container">
    <footer class="text-center py-3 my-4 border-top">
        <span class="mb-3 mb-md-0 text-body-secondary">© 2023 Company, Inc</span>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#registerForm").submit(function (e){
            e.preventDefault();
            let formUrl = $(this).attr("action");
            let reqMethod = $(this).attr("method");
            let formData = $(this).serialize();
            $.ajax({
                url: formUrl,
                type: reqMethod,
                data: formData,
                success: function(data){
                    let result = JSON.parse(data);
                    if (result.status == "success"){
                        console.log("Success", result);
                        Swal.fire("Ok", result.msg, result.status).then(function(){
                            location.reload(); // Reload the page after the alert
                        });
                    }
                    else {
                        console.log("Error", result);
                        Swal.fire("Error", result.msg, result.status);
                    }
                }
            });
        });
    });
</script>
</body>
</html>

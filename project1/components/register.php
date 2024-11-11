<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Michroma&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Michroma", system-ui;
        }

        html,
        body {
            height: 100%;
        }

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;




        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #2c3e50;
           

            padding: 1rem;
            margin-bottom: 2rem;
        }

        .navbar .logo_nav .LoGO {

            font-size: 3rem;
            color: #ffffff;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;

        }



        .navbar .logo_nav span {

            color: #0066ff;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;

        }

        .navbar .logo_nav h3 {

            font-size: 3rem;
            font-weight: bold;
            color: #ffffff;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;

        }

        .navbar .logo_nav a {

            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="navbar">
        <section class="logo_nav">
            <a href="index.php" class="LoGO"> <!-- chages-->
                <h3>G<span>shop</span></h3>
            </a>
        </section>
    </div>


<main class="form-signin w-100 m-auto">
    <form action="registerDB.php" id="registerForm" method="POST">
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
            <input type="password" class="form-control" name="Confirm_Password" id="floatingConfirmPassword" placeholder="Confirm Password">
            <label for="floatingConfirmPassword">Confirm Password</label>
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
        <span class="mb-3 mb-md-0 text-body-secondary">© 2024 Gshop Company</span>
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
                    try {
                        let result = JSON.parse(data);
                        if (result.status == "success"){
                            Swal.fire("Success", result.msg, "success").then(function(){
                                location.reload(); // Reload the page after the alert
                            });
                        } else {
                            Swal.fire("Error", result.msg, "error");
                        }
                    } catch (e) {
                        console.error("Unexpected response format:", data);
                        Swal.fire("Error", "Unexpected response from the server", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    Swal.fire("Error", "An error occurred while processing your request", "error");
                }
            });
        });
    });
</script>
</body>
</html>

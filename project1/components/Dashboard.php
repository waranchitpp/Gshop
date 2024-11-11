<?php
session_start();
require "connect.php";

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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black&display=swap" rel="stylesheet">
    <style>
        /* The footer is fixed to the bottom of the page */


        @import url('https://fonts.googleapis.com/css2?family=Michroma&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Michroma", system-ui;
        }

        body {
            background-image: url("https://images5.alphacoders.com/867/867979.jpg");
        }

        @media (max-height:800px) {
            footer {
                font-family: "Michroma", sans-serif;
                position: static;
            }

        }

        .footer-distributed {
            font-family: "Michroma", sans-serif;
            background-color: #010101;
            box-sizing: border-box;
            width: 100%;
            text-align: left;
            font-size: 16px;
            padding: 50px 50px 60px 50px;
            margin-top: 80px;
        }

        .footer-company-about strong {
            font-family: "Michroma", sans-serif;
        }

        .footer-distributed .footer-left,
        .footer-distributed .footer-center,
        .footer-distributed .footer-right {
            font-family: "Michroma", sans-serif;
            display: inline-block;
            vertical-align: top;
        }

        /* Footer left */

        .footer-distributed .footer-left {
            font-family: "Michroma", sans-serif;
            width: 30%;
        }

        .footer-distributed h3 {
            font-family: "Michroma", sans-serif;
            color: #ffffff;
            font-size: 36px;
            margin: 0;
        }


        .footer-distributed h3 span {
            color: #001aff;
        }

        /* Footer links */

        .footer-distributed .footer-links {
            color: #ffffff;
            margin: 20px 0 12px;
        }

        .footer-distributed .footer-links a {
            font-family: "Michroma", sans-serif;
            display: inline-block;
            line-height: 1.8;
            text-decoration: none;
            color: inherit;
        }

        .footer-distributed .footer-company-name {
            font-family: "Michroma", sans-serif;
            color: #8f9296;
            font-size: 17px;
            font-weight: normal;
            margin: 0;
        }

        /* Footer Center */

        .footer-distributed .footer-center {
            width: 35%;
        }

        .footer-distributed .footer-center i {
            font-family: "Michroma", sans-serif;
            background-color: #33383b;
            color: #ffffff;
            font-size: 25px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            text-align: center;
            line-height: 42px;
            margin: 10px 15px;
            vertical-align: middle;
        }

        .footer-distributed .footer-center i.fa-envelope {
            font-family: "Michroma", sans-serif;
            font-size: 17px;
            line-height: 38px;
        }

        .footer-distributed .footer-center p {
            font-family: "Michroma", sans-serif;
            display: inline-block;
            color: #ffffff;
            vertical-align: middle;
            margin: 0;
        }

        .footer-distributed .footer-center p span {
            font-family: "Michroma", sans-serif;
            display: block;
            font-weight: normal;
            font-size: 14px;
            line-height: 2;
        }

        .footer-distributed .footer-center p a {
            font-family: "Michroma", sans-serif;
            color: #4000ff;
            text-decoration: none;
            ;
        }

        /* Footer Right */

        .footer-distributed .footer-right {

            width: 30%;
        }

        .footer-distributed .footer-company-about {
            font-family: "Michroma", sans-serif;
            line-height: 20px;
            color: #ffffff;
            font-size: 13px;
            font-weight: normal;
            margin: 0;
        }

        .footer-distributed .footer-company-about span {
            font-family: "Michroma", sans-serif;
            display: block;
            color: #ffffff;
            font-size: 20px;

            margin-bottom: 20px;
        }

        .footer-distributed .footer-company-about p {
            font-family: "Michroma", sans-serif;
        }

        .footer-distributed .footer-icons {
            margin-top: 25px;
        }

        .footer-distributed .footer-icons a {
            display: inline-block;
            width: 35px;
            height: 35px;
            cursor: pointer;
            background-color: #33383b;
            border-radius: 2px;
            font-size: 20px;
            color: #ffffff;
            text-align: center;
            line-height: 35px;
            margin-right: 3px;
            margin-bottom: 5px;
        }

        .footer-distributed .footer-icons a:hover {
            background-color: #3F71EA;
        }

        .footer-links a:hover {
            color: #0050a6;
        }

        @media (max-width: 880px) {

            .footer-distributed .footer-left,
            .footer-distributed .footer-center,
            .footer-distributed .footer-right {
                font-family: "Michroma", sans-serif;
                display: block;
                width: 100%;
                margin-bottom: 40px;
                text-align: center;
            }

            .footer-distributed .footer-center i {
                margin-left: 0;
            }
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
        
        .heroe .head1{
            height: 50vh;
            display: flex;
            font-size: 30px;


            justify-content: center;
            align-items: center;


        }

        .heroe .head1 h1 {
            font-size: 72px;
            color: rgba(0, 229, 255);
            text-shadow: 0px 2px 2px rgba(255, 255, 255, 0.4); 
            font-weight: 600;
        }

        .parent-h {
           
            display: flex;

            flex-direction: column;
            align-items: center;
            

        }
        @media (max-height:800px) {
            .heroe .head1{
            height: 50vh;
            display: flex;
            flex-direction: column;
            font-size: 30px;


            justify-content: center;
            align-items: center;


        }
        }
        

        div[class*=box] {
  height: 10%;
  width: 100%; 
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn {
  line-height: 50px;
  height: 50px;
  text-align: center;
  width: 250px;
  cursor: pointer;
}
.btn-two   {
  color: #FFF;
  transition: all 0.5s;
  position: relative; 
}
.btn-two a {
    color: #FFF;
}
.btn-two  span  {
  z-index: 2; 
  display: block;
  position: absolute;
  width: 100%;
  height: 100%; 
}
.btn-two::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  transition: all 0.5s;
  border: 1px solid rgba(255,255,255,0.2);
  background-color: rgba(255,255,255,0.1);
}
.btn-two::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  transition: all 0.5s;
  border: 1px solid rgba(255,255,255,0.2);
  background-color: rgba(255,255,255,0.1);
}
.btn-two:hover::before {
  transform: rotate(-45deg);
  background-color: rgba(255,255,255,0);
}
.btn-two:hover::after {
  transform: rotate(45deg);
  background-color: rgba(255,255,255,0);
}
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <section class="logo_nav">
            <a href="/phpbasic/project/view_products.php" class="LoGO">
                <h3>G<span>shop</span></h3>
            </a>
        </section>
    </div>

    <!-- Heroes -->

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php } ?>


    <div class="heroe">
        
        <div class="head1">
        <h1>Welcome </h1>


        <?php

        if (isset($_SESSION['User_login'])) {
            $userId = $_SESSION['User_login'];

            // Prepare and execute the SQL query
            try {
                $stmt = $conn->prepare("SELECT * FROM users WHERE Id = ?");
                $stmt->execute([$userId]);

                // Fetch and display the data
                while ($row = $stmt->fetch()) {
                    echo "<h1> : " . $row['Username'] . "<br> <h1>";
                    //echo "<h1> Email: " . $row['Email'] . "<br> <h1>";
                    // Display other desired data from the database
                }
            } catch (PDOException $e) {
                // Handle any errors
                echo "Error: " . $e->getMessage();
            }
        }

        ?>
        <p>&#128075;</p>
        </div>
        
        
        

    </div>
    

    <div class="box-2">
  <div class="btn btn-two">
    <a href="/phpbasic/project/view_products.php"><span>Return To Homepage</span></a>
  </div>
</div>

      





    <!-- Album content -->
    <?php
    include 'footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>







<?php 
    session_start();
    include 'connect_db.php';
    $minLength = 2;

    //if (isset($_POST['register'])){//
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $Confirm_Password = $_POST['Confirm_Password'];
      
    // } //

    if (!($Username)){
        echo json_encode(array("status" => "error","msg" => "โปรดใส่ชื่อขdddองคุณ"));
        //$_SESSION['error'] = "โปรดใส่ชื่อขdddองคุณ";
        //header("location: register.php");
    }else if (!filter_var($Email,FILTER_VALIDATE_EMAIL)){
        //$_SESSION['error'] = "Email ของคุณไม่ถูกต้อง";
        //header("location: register.php");
        echo json_encode(array("status" => "error","msg" => "Email ของคุณไม่ถูกต้อง"));
    }else if (strlen($Password) < $minLength){
        //$_SESSION['error'] = "Password ต้องใช้อย่างน้อย 6 ตัวอักษร";
        //header("location: register.php");
        echo json_encode(array("status" => "error","msg" => "กรุณาใส่ Password 22"));
    }
     else if (!preg_match('/[A-Z]/', $Password)) {
        //$_SESSION['error'] = "Your password must have a capital characters";
        //header('location: register.php');
        echo json_encode(array("status" => "error","msg" => "ต้องมีตัวอักษรพิมพ์ใหญ่"));
    } else if (!preg_match('/[a-z]/', $Password)) {

        //$_SESSION['error'] = "Your password must have a lowercase characters";
        //header('location: register.php');
        echo json_encode(array("status" => "error","msg" => "ต้องมีตัวอักษรพิมพ์เล็ก"));
    } else if (!preg_match('/\d/', $Password)) {

        //$_SESSION['error'] = "Your password must have contain a digit numbers";
        //header('location: register.php');
        echo json_encode(array("status" => "error","msg" => "ต้องมีตัวตัวเลข"));
        
    }   else if($Password !== $Confirm_Password){
        //$_SESSION['error'] = "รหัสไม่ตรงกัน";
        //header("location: register.php");
        echo json_encode(array("status" => "error","msg" => "รหัสไม่ตรงกัน"));
    }
    else{

        $checkUsername = $pdo->prepare("SELECT COUNT(*) FROM users WHERE Username = ?");
        $checkUsername->execute([$Username]);
        $usernameExists = $checkUsername->fetchColumn();

        $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM users WHERE Email = ?");
        $checkEmail->execute([$Email]);
        $userEmailExists = $checkEmail->fetchColumn();

        if($usernameExists){
            //$_SESSION['error'] = "มีชื่ออยู่ในระบบแล้ว";
            //header("location: register.php");

            echo json_encode(array("status" => "error","msg" => "มีชื่ออยู่ในระบบแล้ว"));

        }else if($userEmailExists){
            //$_SESSION['error'] = "มี Email อยู่ในระบบแล้ว";
            //header("location: register.php");

            echo json_encode(array("status" => "error","msg" => "มีชื่ออยู่ในระบบแล้ว"));

        }else{

            $hashPassword = password_hash($Password, PASSWORD_DEFAULT);

            try {

                $stmt = $pdo->prepare("INSERT INTO users(Username , Email , Password) VALUE(?, ?, ?)");
                $stmt->execute([$Username , $Email , $hashPassword]);

                // $_SESSION['success'] = "ลงทะเบียนสำเร็จ";
                //header("location: register.php");
                echo json_encode(array("status" => "success","msg" => "ลงทะเบียนสำเร็จ"));

            } catch (PDOException $e){
                //$_SESSION['error'] = "โปรดรองใหม่";
                //header("location: register.php");
                echo json_encode(array("status" => "error","msg" => "โปรดรองใหม่"));
            }
        }
    }
    
?>
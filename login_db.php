<?php 
session_start();
require "connect_db.php";

// Retrieve form data
$Email = $_POST['Email'];
$Password = $_POST['Password'];

// Validate email format
if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array("status" => "error", "msg" => "โปรดใส่ Email ที่ถูกต้อง"));
    exit();
}

// Check if password is empty
else{


// Try to fetch the user from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->execute([$Email]);

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $hashedPassword = $row['Password'];

        // Verify the password
        if (password_verify($Password, $hashedPassword)) {
            $_SESSION['User_login'] = $row['Id'];
            echo json_encode(array("status" => "success", "msg" => "Login สำเร็จ"));
            exit();
        } else {
            echo json_encode(array("status" => "error", "msg" => "Password ไม่ถูกต้อง"));
            exit();
        }
    } else {
        echo json_encode(array("status" => "error", "msg" => "ไม่พบ Email ในระบบ"));
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(array("status" => "error", "msg" => "เกิดข้อผิดพลาดในระบบ"));
    exit();
}
}
?>

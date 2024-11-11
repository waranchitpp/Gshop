<?php 
session_start();
require "connect.php";

// Retrieve form data
$Email = $_POST['Email'];
$Password = $_POST['Password'];

// Validate email format
if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array("status" => "error", "msg" => "โปรดใส่ Email ที่ถูกต้อง"));
    exit();
}

// Check if password is empty
if (empty($Password)) {
    echo json_encode(array("status" => "error", "msg" => "โปรดใส่ Password"));
    exit();
}

try {
    // Try to fetch the user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->execute([$Email]);

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $hashedPassword = $row['Password'];

        // Verify the password
        if ($row['urole'] == 'admin') {
            $_SESSION['admin_login'] = $row['Id'];
            echo json_encode(array("status" => "success", "msg" => "Login สำเร็จ", "redirect" => "admin.php"));
            exit();
        } else {
            $_SESSION['User_login'] = $row['Id'];
            echo json_encode(array("status" => "success", "msg" => "Login สำเร็จ", "redirect" => "Dashboard.php"));
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
?>

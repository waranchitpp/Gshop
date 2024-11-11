<?php
session_start();
require 'connect.php';
$minLength = 6;

$Username = $_POST['Username'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$Confirm_Password = $_POST['Confirm_Password'];
$urole = 'user'; // Set default role as 'user'

if (!$Username) {
    echo json_encode(array("status" => "error", "msg" => "โปรดใส่ชื่อของคุณ"));
} else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array("status" => "error", "msg" => "Email ของคุณไม่ถูกต้อง"));
} else if (strlen($Password) < $minLength) {
    echo json_encode(array("status" => "error", "msg" => "กรุณาใส่ Password"));
} else if (!preg_match('/[A-Z]/', $Password)) {
    echo json_encode(array("status" => "error", "msg" => "ต้องมีตัวอักษรพิมพ์ใหญ่"));
} else if (!preg_match('/[a-z]/', $Password)) {
    echo json_encode(array("status" => "error", "msg" => "ต้องมีตัวอักษรพิมพ์เล็ก"));
} else if (!preg_match('/\d/', $Password)) {
    echo json_encode(array("status" => "error", "msg" => "ต้องมีตัวเลข"));
} else if ($Password !== $Confirm_Password) {
    echo json_encode(array("status" => "error", "msg" => "รหัสไม่ตรงกัน"));
} else {
    $checkUsername = $conn->prepare("SELECT COUNT(*) FROM users WHERE Username = ?");
    $checkUsername->execute([$Username]);
    $usernameExists = $checkUsername->fetchColumn();

    $checkEmail = $conn->prepare("SELECT COUNT(*) FROM users WHERE Email = ?");
    $checkEmail->execute([$Email]);
    $userEmailExists = $checkEmail->fetchColumn();

    if ($usernameExists) {
        echo json_encode(array("status" => "error", "msg" => "มีชื่ออยู่ในระบบแล้ว"));
    } else if ($userEmailExists) {
        echo json_encode(array("status" => "error", "msg" => "มี Email อยู่ในระบบแล้ว"));
    } else {
        $hashPassword = password_hash($Password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (Username, Email, Password, urole) VALUES (?, ?, ?, ?)");
            $stmt->execute([$Username, $Email, $hashPassword, $urole]);

            echo json_encode(array("status" => "success", "msg" => "ลงทะเบียนสำเร็จ"));
        } catch (PDOException $e) {
            error_log($e->getMessage()); // Log the error for debugging
            echo json_encode(array("status" => "error", "msg" => "โปรดลองใหม่"));
        }
    }
}
?>

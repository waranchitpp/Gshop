<?php
$host = "localhost";
$dbname = "memberf_db";
$username = "root";
$password = "";


try {
  $pdo = new PDO("mysql:host=$host;dbname=memberf_db", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function create_unique_id(){
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < 20; $i++) {
      $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>
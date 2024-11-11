<?php

   $db_host = 'localhost';
   $db_name = 'shop_db';
   $db_user_name = 'root';
   $db_user_pass = '';

   try {
      $conn = new PDO("mysql:host=$db_host;dbname=shop_db", $db_user_name, $db_user_pass);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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

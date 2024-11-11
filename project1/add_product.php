<?php
session_start();
include 'components/connect.php';
if (!isset($_SESSION['admin_login'])) {
   // Redirect to login if User_Id is not set in the session
   header("Location: components/login.php");
   //exit();
}
if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

if (isset($_POST['add'])) {

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id() . '.' . $ext;
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_size = $_FILES['image']['size'];
   $image_folder = 'uploaded_files/' . $rename;

   if ($image_size > 2000000) {
      $warning_msg[] = 'Image size is too large!';
   } else {
      try {
         $add_product = $conn->prepare("INSERT INTO `products`(id, name, price, image) VALUES(?,?,?,?)");
         $add_product->execute([$id, $name, $price, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);
         $success_msg[] = 'Product added!';
      } catch (Exception $e) {
         $warning_msg[] = 'Failed to add product!';
      }
   }
}

if (isset($_POST['delete'])) {
   $product_id = $_POST['product_id'];

   try {
      $fetch_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
      $fetch_image->execute([$product_id]);
      $image_data = $fetch_image->fetch(PDO::FETCH_ASSOC);
      $image = $image_data['image'];

      $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
      $delete_product->execute([$product_id]);

      if ($image && file_exists('uploaded_files//' . $image)) {
         unlink('uploaded_files/' . $image);
      }

      $success_msg[] = 'Product deleted!';
   } catch (Exception $e) {
      $warning_msg[] = 'Failed to delete product!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

   <link rel="stylesheet" href="css/style.css">
   
   <style>
      #customers {
         font-family: Arial, Helvetica, sans-serif;
         border-collapse: collapse;
         width: 100%;
      }

      #customers td {
         font-size: 16px;
      }

      #customers td,
      #customers th {
         border: 1px solid #ddd;
         padding: 8px;
      }

      #customers tr:nth-child(even) {
         background-color: #f2f2f2;
      }

      #customers tr:hover {
         background-color: #ddd;
      }

      #customers th {
         font-size: 20px;
         padding-top: 12px;
         padding-bottom: 12px;
         text-align: left;
         background-color: #04AA6D;
         color: white;
      }
   </style>
</head>

<body>

   <?php include 'components/header.php'; ?>

   <section class="product-form">
      <form action="" method="POST" enctype="multipart/form-data">
         <h3>product info</h3>
         <p>product name <span>*</span></p>
         <input type="text" name="name" placeholder="enter product name" required maxlength="50" class="box">
         <p>product price <span>*</span></p>
         <input type="number" name="price" placeholder="enter product price" required min="0" max="9999999999" maxlength="10" class="box">
         <p>product image <span>*</span></p>
         <input type="file" name="image" required accept="image/*" class="box">
         <input type="submit" class="btn" name="add" value="add product">
      </form>
   </section>

   <?php
   // Display success or warning messages
   if (!empty($success_msg)) {
      foreach ($success_msg as $msg) {
         echo '<p class="success">' . $msg . '</p>';
      }
   }
   if (!empty($warning_msg)) {
      foreach ($warning_msg as $msg) {
         echo '<p class="warning">' . $msg . '</p>';
      }
   }

   // Fetch products from the database
   $fetch_products = $conn->prepare("SELECT * FROM `products`");
   $fetch_products->execute();
   if ($fetch_products->rowCount() > 0) {
   ?>
      <table id="customers">
         <thead>
            <tr>
               <th>Image</th>
               <th>Name</th>
               <th>Price</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($product = $fetch_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
               <tr>
                  <td><img src="uploaded_files/<?= $product['image']; ?>" alt="" style="width: 100px; height: auto;"></td>
                  <td><?= $product['name']; ?></td>
                  <td>$<?= $product['price']; ?></td>
                  <td>
                     <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <input type="submit" name="delete" value="Delete" class="btn">
                     </form>
                  </td>
               </tr>
            <?php
            }
            ?>
         </tbody>
      </table>
   <?php
   } else {
      echo '<p class="empty">No products added yet!</p>';
   }
   ?>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
   <script src="js/script.js"></script>

   <?php include 'components/alert.php';
          ?>

</body>

</html>
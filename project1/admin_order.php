<?php
session_start();
include 'components/connect.php';
if ( !isset($_SESSION['admin_login'])){
  
    header("Location: components/register.php");
   
 }
// Check if user_id cookie exists; if not, set a new one
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    
    // Update the order status in the database
    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_order->execute([$new_status, $order_id]);

    // Redirect to avoid resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
         integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="css/style.css">
   <style>
       .update-form {
           margin-top: 10px;
       }

       .update-form select {
           padding: 5px;
       }

       .update-form button {
           padding: 5px 10px;
           background-color: #007bff;
           color: white;
           border: none;
           border-radius: 4px;
           cursor: pointer;
       }

       .update-form button:hover {
           background-color: #0056b3;
       }
   </style>
</head>
<body>
   
<?php include 'components/header.php'; ?>

<section class="orders">
   <h1 class="heading">Admin Orders</h1>
   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
      $select_orders->execute([$user_id]);
      if ($select_orders->rowCount() > 0) {
         while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$fetch_order['product_id']]);
            if ($select_product->rowCount() > 0) {
               while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <div class="box" <?php if ($fetch_order['status'] == 'canceled') { echo 'style="border:.2rem solid red";'; } ?>>
      <a href="view_order.php?get_id=<?= htmlspecialchars($fetch_order['id']); ?>">
         <p class="date"><i class="fa fa-calendar"></i><span><?= htmlspecialchars($fetch_order['date']); ?></span></p>
         <img src="uploaded_files/<?= htmlspecialchars($fetch_product['image']); ?>" class="image" alt="">
         <h3 class="name"><?= htmlspecialchars($fetch_product['name']); ?></h3>
         <p class="price"><i class="fa-solid fa-baht-sign"></i> <?= htmlspecialchars($fetch_order['price']); ?> x <?= htmlspecialchars($fetch_order['qty']); ?></p>
         <p class="status" style="color:<?php if ($fetch_order['status'] == 'delivered') { echo 'green'; } elseif ($fetch_order['status'] == 'canceled') { echo 'red'; } else { echo 'orange'; } ?>"><?= htmlspecialchars($fetch_order['status']); ?></p>
      </a>
      <form action="" method="POST" class="update-form">
         <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_order['id']); ?>">
         <select name="status" required>
            <option value="pending" <?= ($fetch_order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="delivered" <?= ($fetch_order['status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
            <option value="canceled" <?= ($fetch_order['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
         </select>
         <button type="submit" name="update_status">Update Status</button>
      </form>
   </div>
   <?php
               }
            }
         }
      } else {
         echo '<p class="empty">No orders found!</p>';
      }
   ?>

   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>

<?php include 'components/alert.php'; ?>

</body>
</html>

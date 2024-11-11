<?php 
session_start();
require "components/connect.php";
if (!isset($_SESSION['User_login'])) {
  
    header("Location: components/register.php");
   
 }
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = create_unique_id();
    setcookie('user_id', $user_id, time() + 60 * 60 * 24 * 30, "/"); // Added "/" path to ensure cookie works globally
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    if ($qty <= 0) {
        echo json_encode(array("status" => "error", "msg" => "Quantity must be at least 1"));
        exit();
    }

    // Check if the cart item exists
    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
    $verify_cart->execute([$cart_id, $user_id]);

    if ($verify_cart->rowCount() > 0) {
        $update_qty = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ? AND user_id = ?");
        $update_qty->execute([$qty, $cart_id, $user_id]);
        $success_msg[] = 'Cart quantity updated!';
    } else {
        $warning_msg[] = 'Item not found in cart!';
    }
}

// Delete cart item
if (isset($_POST['delete_item'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);

    // Check if the cart item exists
    $verify_delete_item = $conn->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
    $verify_delete_item->execute([$cart_id, $user_id]);

    if ($verify_delete_item->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $delete_cart_id->execute([$cart_id, $user_id]);
        $success_msg[] = 'Cart item deleted!';
    } else {
        $warning_msg[] = 'Item already deleted or not found!';
    }
}

// Empty the entire cart
if (isset($_POST['empty_cart'])) {
    $verify_empty_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $verify_empty_cart->execute([$user_id]);

    if ($verify_empty_cart->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart_id->execute([$user_id]);
        $success_msg[] = 'Cart emptied!';
    } else {
        $warning_msg[] = 'Cart already empty!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="products">

    <h1 class="heading">shopping cart</h1>

    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {

                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$fetch_cart['product_id']]);
                if ($select_products->rowCount() > 0) {
                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
    ?>
    <form action="" method="POST" class="box">
        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
        <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
        <h3 class="name"><?= $fetch_product['name']; ?></h3>
        <div class="flex">
            <p class="price"><i class="fa-solid fa-baht-sign"></i> <?= $fetch_cart['price']; ?></p>
            <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">
            <button type="submit" name="update_cart" class="fas fa-edit"></button>
        </div>
        <p class="sub-total">sub total : <span><i class="fa-solid fa-baht-sign"></i> <?= $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']); ?></span></p>
        <input type="submit" value="delete" name="delete_item" class="delete-btn" onclick="return confirm('delete this item?');">
    </form>
    <?php
                    $grand_total += $sub_total;
                } else {
                    echo '<p class="empty">Product not found!!</p>';
                }
            }
        } else {
            echo '<p class="empty">Your cart is empty!</p>';
        }
    ?>

    </div>

    <?php if ($grand_total != 0) { ?>
        <div class="cart-total">
            <p>grand total : <span><i class="fa-solid fa-baht-sign"></i> <?= $grand_total; ?></span></p>
            <form action="" method="POST">
                <input type="submit" value="empty cart" name="empty_cart" class="delete-btn" onclick="return confirm('Empty your cart?');">
            </form>
            <a href="checkout.php" class="btn">Proceed to checkout</a>
        </div>
    <?php } ?>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>

</body>
</html>

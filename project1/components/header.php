<header class="header">

   <section class="flex">
   <a href="#" class="logo"><h3>G<span>shop</span></h3></a>

      <nav class="navbar">
      
         <?php if (isset($_SESSION['User_login'])): ?>
           
            <a href="index.php">view products</a>
            <a href="orders.php">my orders</a>

            <?php
               // Display cart only if user is logged in
               $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $count_cart_items->execute([$user_id]);
               $total_cart_items = $count_cart_items->rowCount();
            ?>
            <a href="shopping_cart.php" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i><span><?= $total_cart_items; ?></span></a></i>
         <?php endif; ?>

         <?php
            if (isset($_SESSION['User_login']) || isset($_SESSION['admin_login'])) {
                // User is logged in
                if (isset($_SESSION['admin_login'])) {
                    // Admin user
                  
                    echo ' <a href="add_product.php">add product</a>';
                    echo ' <a href="admin_order.php">order</a>';
                }
                echo '<a href="components/logout.php">logout</a>';
            } else {
                // User is not logged in
                echo '<a href="components/login.php">login</a>';
                echo '<a href="components/register.php">sign up</a>';
            }
         ?>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>
   </section>

</header>

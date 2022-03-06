<?php 
    $pageTitle = "TecHunt - Cart Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
        <link rel="stylesheet" href="./assets/css/cart.css">
    </head>
<body>
<?php 
    $currentPage = "cart";
    $logged = false;
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }
    include('./includes/navbar.php');
?>

<main>

    <?php
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $deleteQuery = "DELETE FROM cart WHERE cart_id = $id";
            if (!isset($connection))
                include_once('./database/database.php');
            $deleteResult = mysqli_query($connection, $deleteQuery);
            if ($deleteResult) {
                echo "<script>alert('Cart item is deleted');</script>";
            } else {
                echo "<script>alert('Cart item is not deleted');</script>";
            }
        }
    ?>

    <?php
        require_once('./database/database.php');
        
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $cartQuery = "SELECT * FROM cart WHERE user_id = $id";
            $cartResult = mysqli_query($connection, $cartQuery);
    
            if (mysqli_num_rows($cartResult) > 0) {
                $subCost = 0;

                echo '
                <div class="container">
                <div class="cart-container">
                    <h2>Cart</h2>
                    <div class="card-container">
                ';
                        while ($row = mysqli_fetch_array($cartResult)) {
                            $productId = $row['product_id'];

                            $productQuery = "SELECT *, product_cost as cost FROM products WHERE product_id = $productId";
                            $productResult = mysqli_query($connection, $productQuery);

                            if ($row2 = mysqli_fetch_array($productResult)) {
                                    global $subCost;
                                    global $row;
                                    $productCost = $row['quantity'] * $row2['product_cost'];
                                    $subCost += $productCost;
                                    $productCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productCost);
                                    echo '
                                    <div class="card">
                                        <div class="card-info">
                                            <img src="'.$row2['product_url']. '" alt="">
                                            <h3>' .$row2['product_name']. '</h3>
                                        </div>
                                        <div class="cart-manage">
                                            <form action="" method="post">
                                                <h3>₹ '.$productCost.'</h3>
                                                <div class="quantity">
                                                    <input type="number" name="quantity" id=" " value="'.$row['quantity'].'" min="1" max="10">
                                                </div>
                                            </form>
                                            <form action="./cart" method="POST">
                                                <input hidden name="id" value="'.$row['cart_id'].'"  />
                                                <button type="submit" name="delete">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    ';
                            }
                                
                        }
                        $shippingCost = 999;
                        $totalCost = $subCost + $shippingCost;
                        $subCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $subCost);
                        $shippingCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $shippingCost);
                        $totalCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $totalCost);
                        echo '
                        </div>
                        </div>
                                    
                        <div class="payment-summary">
                            <h2>Payment Summary</h2>
                            <div class="payment-container">
                                <h3>Total Amount</h3>
                                <hr />
                                <div class="payment-display">
                                    <h4>Sub-Total</h4>
                                    <h4>₹ ' .$subCost. '</h4>
                                </div>
                                <hr />
                                <div class="payment-display">
                                    <h4>Shipping Charges</h4>
                                    <h4>₹ '.$shippingCost.'</h4>
                                </div>
                                <hr />
                                <div class="payment-display">
                                    <h4>Total Payment</h4>
                                    <h4>₹ '.$totalCost.'</h4>
                                </div>
                                <form action="./action" method="POST">
                                    <button type="submit" name="checkout">Proceed to Checkout</button>
                                </form>
                            </div>
                        </div>
                        </div>
               ';
            } else {
                echo '
                <div class="empty-container">
                    <h2>Cart</h2>
                    <img src="./assets/img/empty_cart.png" alt="">
                    <span>
                        Looks like you don\'t have any item here...!<br>
                        Your Cart is Empty
                    </span>
                    <form action="./store" method="post">
                        <button type="submit">Return to Store</button>
                    </form>
                </div>
                ';
            }
        }  else {
            echo '
            <div class="empty-container">
                <h2>Cart</h2>
                <img src="./assets/img/empty_cart.png" alt="">
                <span>
                    Looks like you don\'t have any item here...!<br>
                    Your Cart is Empty
                </span>
                <form action="./store" method="post">
                    <button type="submit">Return to Store</button>
                </form>
            </div>
            ';
        }
    ?>
    
    

</main>


<?php include('./includes/footer.php') ?>
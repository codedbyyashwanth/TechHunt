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
        if (isset($_POST['checkout'])) {
            require_once('./database/database.php');
        
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
                $cartQuery = "SELECT * FROM cart WHERE user_id = $id";
                $cartResult = mysqli_query($connection, $cartQuery);
                $orderPlaced = true;
        
                if (mysqli_num_rows($cartResult) > 0) {

                            while ($row = mysqli_fetch_array($cartResult)) {
                                $productId = $row['product_id'];
                                $userId = $row['user_id'];
                                $quantity = $row['quantity'];
                                $paymentStatus = "Not Paid";
                                $deliverTime = (rand(1,5)) ." days";

                                $orderQuery = "INSERT INTO orders (`user_id`, `product_id`, `quantity`, `payment_status`, `delivery_time`) VALUES ('$userId','$productId','$quantity','$paymentStatus','$deliverTime')";
                                $orderResult = mysqli_query($connection, $orderQuery);

                                if (!$orderResult) {
                                    $orderPlaced = false;
                                }
                            }

                            if ($orderPlaced) {
                                $cartRemoveQuery = "DELETE FROM cart WHERE user_id = $id";
                                $removeResult = mysqli_query($connection, $cartRemoveQuery);

                                if ($removeResult) {
                                    echo "<script>alert('Order has been Placed');</script>";
                                } else {
                                    echo "<script>alert('Order not Placed');</script>";
                                }

                                header('Location: cart');
                            }
                }
            }  
        }

        if(isset($_POST['addtocart'])) {
            if (isset($_SESSION['id'])) {
                require_once('./database/database.php');
                $uid = $_POST['uid'];
                $pid = $_POST['pid'];
                $quantity = $_POST['quantity'];

                $query = "INSERT INTO `cart`(`product_id`, `user_id`, `quantity`) VALUES ('$pid','$uid','$quantity')";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    echo "<script>alert('Added to Cart');</script>";
                } else {
                    echo "<script>alert('Unable to Cart');</script>";
                }
                header('Location: cart');
            } else {
                header('Location: account');
            }
        }

        if(isset($_POST['logout'])) {
            session_destroy();
            header("Location: index");
        }

        if(isset($_POST['deactivate'])) {
            $id = $_SESSION['id'];
            $query = "DELETE FROM user WHERE user_id = '$id'";
            require_once("./database/database.php");
            $result = mysqli_query($connection, $query);

            if ($result) {
                echo "<script>alert('Your Account is deleted');</script>";
                session_destroy();
                header("Location: index");
            } else {
                echo "<script>alert('Your Account is not deleted');</script>";
            }
        }
    ?>

</main>


<?php include('./includes/footer.php') ?>
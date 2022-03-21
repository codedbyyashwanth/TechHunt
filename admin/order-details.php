<?php 
    $pageTitle = "TecHunt Admin - Orders Page ";
    include('../includes/header.php');
    $logged = false;
    if(!isset($_SESSION)) {
        session_start();
    }

    
    if ((isset($_SESSION['email']) && isset($_SESSION['vendor_password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['vendor_password']))) {
        $logged = true;
    }

    if (!$logged) {
        header("Location: login"); 
    } 
?>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./styles/product.css">

</head>

<?php 
    $currentPage = "orders";
    include('../includes/adminNav.php');
?>

<main>
    <?php 
        require_once('../database/database.php');

        if (isset($_POST['forward'])) {
            $userId = $_POST['id'];
            $vendorId = $_SESSION['vendor_id'];
            $query = "SELECT product_id, quantity FROM orders WHERE user_id = '$userId' and vender_id = '$vendorId'";
            $result = mysqli_query($connection, $query);
            $productCount = mysqli_num_rows($result);

            if ($productCount > 0) {
                echo '
                <div class="container">
                <div class="product-container">
                    <div class="container-head">
                        <div>
                        <h2>Ordered Products</h2>
                        </div>
                    </div>
                    <div class="card-container">
                ';
                while($ids = mysqli_fetch_assoc($result)) {
                    $productId = $ids['product_id'];
                    $productQty = $ids['quantity'];

                    $productDetails = "SELECT * FROM products WHERE product_id = '$productId'";
                    $detailsResult = mysqli_query($connection, $productDetails);

                    while ($row = mysqli_fetch_assoc($detailsResult)) {
                        $productName = $row['product_name'];
                        $productPrice = $row['product_cost'];
                        $productPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productPrice);
                        $productImageURL = $row['product_url'];
                        $productQuantity = $row['product_quantity'];

                        echo '
                            <div class="card">
                                <div class="card-info">
                                    <img src="'.$productImageURL. '" alt="">
                                    <h3>' .$productName. '</h3>
                                </div>
                                <div class="cart-manage">
                                    <form action="" method="post">
                                        <h3>₹ '.$productPrice.'</h3>
                                    </form>
                                    <form action="" method="post">
                                        <h3>Qty: '.$productQty.'</h3>
                                    </form>
                                </div>
                            </div>
                            ';
                    }
                }

                echo '</div>
                    </div>';

                $userQuery = "SELECT * FROM user WHERE user_id = '$userId'";
                $userResult = mysqli_query($connection, $userQuery);
                $row = mysqli_fetch_assoc($userResult);

                echo '
                    <div class="payment-summary">
                        <h2>User Summary</h2>
                        <div class="payment-container">
                            <h3>User Details</h3>
                            <hr />
                            <div class="payment-display">
                                <h4>Fullname</h4>
                                <h4>'.$row['name'].'</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>E-mail Id</h4>
                                <h4>'.$row['email'].'</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>Address</h4>
                                <h4>' .$row['address']. '</h4>
                            </div>
                        </div>
                        </div>
                </div>';
            } else {
                echo '
                <div class="container">
                <div class="product-container">
                    <div class="container-head">
                        <div>
                        <h2>Products</h2>
                        </div>
                        <div class="add-btn">
                            <form action="./product" method="POST" >
                                <button name="AddProduct" type="submit">Add Product</button>
                            </form>
                        </div>
                    </div>
                    <h3>There is no product to display</h3>
                </div>
                </div>'
                    ;
            }
        }
    ?>
    
</main>
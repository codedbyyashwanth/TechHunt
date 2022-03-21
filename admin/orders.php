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

        if (isset($_SESSION['vendor_id'])) {
            $vendorId = $_SESSION['vendor_id'];
            $query = "SELECT product_id, user_id FROM orders WHERE vender_id = '$vendorId'";
            $result = mysqli_query($connection, $query);
            $productCount = mysqli_num_rows($result);
            $EstProfit = 0;

            if ($productCount > 0) {
                echo '
                <div class="container">
                <div class="product-container">
                    <div class="container-head">
                        <div>
                        <h2>Orders</h2>
                        </div>
                    </div>
                    <div class="card-container">
                ';
                while($row = mysqli_fetch_assoc($result)) {
                    $productId = $row['product_id'];
                    $userId = $row['user_id'];

                    $productDetails = "SELECT * FROM products WHERE product_id = '$productId'";
                    $detailsResult = mysqli_query($connection, $productDetails);

                    if ($row2 = mysqli_fetch_assoc($detailsResult)) {
                        $productName = $row2['product_name'];
                        $productPrice = $row2['product_cost'];
                        $EstProfit += (int) $productPrice;
                        $productPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productPrice);
                        $productImageURL = $row2['product_url'];
                        $productQty = $row2['product_quantity'];

                        echo '
                            <div class="card">
                                <div class="card-info">
                                    <img src="'.$productImageURL. '" alt="">
                                    <h3>' .$productName. '</h3>
                                </div>
                                <div class="cart-manage">
                                    <form action="" method="post">
                                        <h3>User Id: ' .$userId.'</h3>
                                    </form>
                                    <form action="./order-details" method="POST">
                                        <input hidden name="id" value="'.$userId.'"  />
                                        <button type="submit" name="forward">
                                            <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                                        </button>
                                    </form>
                                    <form action="./action" method="POST">
                                        <input hidden name="pid" value="'.$row2['product_id'].'"  />
                                        <input hidden name="vid" value="'.$row2['vender_ids'].'"  />
                                        <button type="submit" name="deleteOrders">
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            ';
                    }
                }

                echo '</div>
                    </div>';

                $detailsQuery = "SELECT COUNT(*) AS totalOrders, COUNT(DISTINCT user_id) AS totalUsers FROM orders WHERE vender_id = '$vendorId'";
                $detailsResult = mysqli_query($connection, $detailsQuery);
                $row = mysqli_fetch_assoc($detailsResult);
                $EstProfit = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $EstProfit);

                echo '
                    <div class="payment-summary">
                        <h2>Order Summary</h2>
                        <div class="payment-container">
                            <h3>Order Details</h3>
                            <hr />
                            <div class="payment-display">
                                <h4>No. of Orders</h4>
                                <h4>'.$row['totalOrders'].'</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>Users Ordered</h4>
                                <h4>'.$row['totalUsers'].'</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>Estimated Profit</h4>
                                <h4>₹ ' .$EstProfit. '</h4>
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
                        <h2>Orders</h2>
                        </div>
                        
                    </div>
                    <h3>There is no orders to display</h3>
                </div>
                </div>'
                    ;
            }
        }
    ?>
</main>
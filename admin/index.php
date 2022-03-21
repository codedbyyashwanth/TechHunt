<?php 
    $pageTitle = "TecHunt Admin - Products Page ";
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
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/THLogo.png" type="image/x-icon">  

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./styles/product.css">

    <!-- bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
</head>

<?php 
    $currentPage = "home";
    include('../includes/adminNav.php');
?>

<main>
    <?php 
        require_once('../database/database.php');

        if (isset($_SESSION['vendor_id'])) {
            $vendorId = $_SESSION['vendor_id'];
            $query = "SELECT * FROM products WHERE vender_ids = '$vendorId'";
            $result = mysqli_query($connection, $query);
            $productCount = mysqli_num_rows($result);

            if ($productCount > 0) {
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
                    <div class="card-container">
                ';
                while($row = mysqli_fetch_assoc($result)) {
                    $productName = $row['product_name'];
                    $productPrice = $row['product_cost'];
                    $productPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productPrice);
                    $productImageURL = $row['product_url'];
                    $productQty = $row['product_quantity'];

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
                                <form action="./product" method="POST">
                                    <input hidden name="id" value="'.$row['product_id'].'"  />
                                    <button type="submit" name="edit">
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
                                </form>
                                <form action="./action" method="POST">
                                    <input hidden name="id" value="'.$row['product_id'].'"  />
                                    <button type="submit" name="delete">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </div>
                        ';
                }

                echo '</div>
                    </div>';

                $detailsQuery = "SELECT COUNT(*) AS totalProducts, SUM(product_cost)  AS totalCost FROM products WHERE vender_ids = '$vendorId'";
                $detailsQuery2 = "SELECT COUNT(DISTINCT product_brand) AS totalBrand, COUNT(DISTINCT product_category) AS totalCategory FROM products WHERE vender_ids = '$vendorId'";
                $detailsResult = mysqli_query($connection, $detailsQuery);
                $detailsResult2 = mysqli_query($connection, $detailsQuery2);
                $row = mysqli_fetch_assoc($detailsResult);
                $row2 = mysqli_fetch_assoc($detailsResult2);
                $totalProductPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $row['totalCost']);
                echo '
                    <div class="payment-summary">
                        <h2>Product Summary</h2>
                        <div class="payment-container">
                            <h3>Product Details</h3>
                            <hr />
                            <div class="payment-display">
                                <h4>Brands</h4>
                                <h4>'.$row2['totalBrand'].'</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>Categories</h4>
                                <h4>'.$row2['totalCategory'].'</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>Products Available</h4>
                                <h4>' .$row['totalProducts']. '</h4>
                            </div>
                            <hr />
                            <div class="payment-display">
                                <h4>Cost of Products</h4>
                                <h4>₹ '.$totalProductPrice.'</h4>
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
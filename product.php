<?php 
    $pageTitle = "TecHunt - Store Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
    <link rel="stylesheet" href="./assets/css/product.css">
    </head>
<body>
<?php 
    $currentPage = "store";
    $logged = false;
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }
    include('./includes/navbar.php');
?>

<main>
    <div class="product-container">
        <?php
            $pid = $_GET['pid'];
            require_once('./database/database.php');
            $query = "SELECT * FROM products WHERE product_id = '$pid'";
            $result = mysqli_query($connection, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $productURL  = $row['product_url'];
                $vid  = $row['vender_ids'];
                $productName  = $row['product_name'];
                $productCost  = $row['product_cost'];
                $productDesc  = $row['product_description'];
                $productQuantity  = $row['product_quantity'];
                $pid  = $row['product_id'];
                $priceValue = $productCost;
                if (isset($_SESSION['id'])) {
                    $uid = $_SESSION['id'];
                } else {
                    $uid = -1;
                }
                
                echo '<div class="product-image">
                    <img src="'.$productURL.'" alt="">
                </div>
                <div class="product-details">
                    <form action="./action" method="POST">
                    <h1>'.$productName.'</h1>
                    <p>
                        <b>Description: </b>
                        '.$productDesc.'
                    </p>';
                    echo    "<div class='stars'><b>Ratings: </b>";
                                    for($i = 1; $i<=5; $i++) {
                                        if ($i <= $row['rating'])
                                            echo "<ion-icon style='margin: -2px 4px;' name='star' class=' star checked'></ion-icon>";
                                        else
                                            echo "<ion-icon style='margin: -2px 4px;' name='star' class='star'></ion-icon>";
                                    }
                    echo '</div>';
                    $productCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productCost);
                    echo '<span><b>Available in stock: </b> '.$productQuantity.' pieces</span>
                    <h3 id="priceDisplay">₹ '.$productCost.'</h3>
                    <div class="cart-manage">
                            <div class="quantity">
                                <input type="number" name="quantity" id="quantitySelector" value="1" min="1" max="10">
                            </div>
                    </div>
                    <input name="pid" hidden  value="'.$pid.'" />
                    <input name="uid" hidden  value="'.$uid.'" />
                    <input name="vid" hidden  value="'.$vid.'" />
                    <button type="submit" name="addtocart">Add to Cart</button>
                 </form>
                </div>
                <script>
                    const quantitySelector = document.getElementById("quantitySelector");
                    const priceDisplay = document.getElementById("priceDisplay");

                    quantitySelector.addEventListener("change", () => {
                        const quantity = quantitySelector.value;
                        var price = parseInt('.$priceValue.') * parseInt(quantity);
                        priceDisplay.textContent = price.toLocaleString("en-IN", {
                            maximumFractionDigits: 0,
                            style: "currency",
                            currency: "INR"
                        });
                    });
                </script>
                ';
            }
        ?>
    </div>
</main>


<?php include('./includes/footer.php') ?>
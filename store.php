<?php 
    $pageTitle = "TecHunt - Store Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
    <link rel="stylesheet" href="./assets/css/store.css">
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
    <div class="store-layout">
        <div class="product-layout">    
        <?php 
            require_once('./database/database.php');
            
            $query = "SELECT * FROM products";
            
            if (isset($_POST['submit'])) {
                $sorting = $_POST['sorting'];

                if ($sorting === "default") {
                    $query = "SELECT * FROM products";
                    $option = '
                    <option value="default" selected>Default Sorting</option>
                    <option value="lth">Sort by Price: Low to High</option>
                    <option value="htl">Sort by Price: High to Low</option>
                    <option value="rating">Sort by Rating</option>
                    ';
                } else if ($sorting === "lth") {                     
                    $query = "SELECT * FROM products ORDER BY product_cost ASC";

                    $option = '
                    <option value="default">Default Sorting</option>
                    <option value="lth" selected>Sort by Price: Low to High</option>
                    <option value="htl">Sort by Price: High to Low</option>
                    <option value="rating">Sort by Rating</option>
                    ';
                } else if ($sorting === "htl") {
                    $query = "SELECT * FROM products ORDER BY product_cost DESC";

                    $option = '
                    <option value="default">Default Sorting</option>
                    <option value="lth">Sort by Price: Low to High</option>
                    <option value="htl" selected>Sort by Price: High to Low</option>
                    <option value="rating">Sort by Rating</option>
                    ';
                } else {
                    $query = "SELECT * FROM products ORDER BY rating DESC";

                    $option = '
                    <option value="default">Default Sorting</option>
                    <option value="lth">Sort by Price: Low to High</option>
                    <option value="htl">Sort by Price: High to Low</option>
                    <option value="rating" selected>Sort by Rating</option>
                    ';
                }

            } else {
                $query = "SELECT * FROM products";

                $option = '
                    <option value="default" selected>Default Sorting</option>
                    <option value="lth">Sort by Price: Low to High</option>
                    <option value="htl">Sort by Price: High to Low</option>
                    <option value="rating">Sort by Rating</option>
                    ';
            }
            $result = mysqli_query($connection, $query);
            echo    '<div class="meta-info">
            <div class="basic-info">
                <h5>Home / Store </h5>
                <h4>Showing all '. mysqli_num_rows($result) .' Products</h4>
            </div>
            <div class="sorting">
                <form method="POST" action="./store">
                    <select name="sorting" id="options">'
                       . $option .
                    '</select>
                    <input hidden type="submit" name="submit" id="sort-submit" />
                </form>
            </div>
        </div>
        <div class="store-products">
            <div class="product-container">';

    if (mysqli_num_rows($result)>0) {
            while ($row = mysqli_fetch_array($result)) {
                $productURL  = $row['product_url'];
                $productName  = $row['product_name'];
                $productCost  = $row['product_cost'];
                $pid = $row["product_id"];
                echo 
                    ' <div class="product-card">
                        <div class="product-img">';
                        echo  " <img src=" .$productURL."  alt=''>";
                        echo '</div>
                        <div class="product-content">';
                        echo  "<h3>".$productName."</h3>";
                        echo    "<div class='stars'>";
                                for($i = 1; $i<=5; $i++) {
                                    if ($i <= $row['rating'])
                                        echo "<ion-icon style='margin: 2px 4px;' name='star' class=' star checked'></ion-icon>";
                                    else
                                        echo "<ion-icon style='margin: 2px 4px;' name='star' class='star'></ion-icon>";
                                }
                echo '</div>';
                $productCost = $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productCost);
                // echo "<span style='font-size:0.8rem; font-family: 'Montserrat', sans-serif; font-weight:500; text-align:center;'>" .$row['rating']." Ratings</span>";
                echo "<h2 >₹ ". $productCost."</h2>";
                echo  "<form method='GET' action='./product'>
                                    <input hidden value=".$pid." name='pid'  />
                                    <button type='submit'>View Product</button>
                               </form>
                        </div>
                    </div>";
            }
    } else {
        echo "<h2>No Product Data Available</h2>";
    }

        ?>
        </div>
    </div>
</main>

<script>
    const options = document.getElementById("options");
    const sortSubmit = document.getElementById("sort-submit");
    options.addEventListener('change', () => {
        sortSubmit.click();
    });
</script>

<?php include('./includes/footer.php') ?>
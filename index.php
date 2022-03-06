<?php 
    $pageTitle = "TecHunt - Latest Model of Laptops, Phones";
    include('./includes/header.php');
    $logged = false;
    if(!isset($_SESSION)) {
        session_start();
    }

    
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }
?>
        <link rel="stylesheet" href="./assets/css/home.css">

        <!-- Swiper Js -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

        <!-- Script Files -->
        <script defer src="./assets/scripts/home.js" type="text/javascript"></script>
    </head>
    <style>
        .swiper-1 {
            width: 100%;
            height: 700px;
        }

        .slides {
            background-color: #F7F4FF;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .hero-content {
            margin: 10px;
            text-align: center;
        }

        .hero-content h1{
            /* font-size: 3.5rem; */
            color: #191A19;
            font-weight: 600;
        }

        .hero-content p {
            font-weight: 500;
            color: #323232;
            /* font-family: 'Open Sans'; */
            margin-top: 20px;
        }

        .hero-imgs {
            animation: img-anime ease 12s infinite;
        }

        @keyframes img-anime {
            0% {
                transform: translateY(20px) rotate(10deg) skew(0deg, 0deg);
            }

            50% {
                transform: translateY(-30px) rotate(-10deg) ;
            }

            100% {
                transform: translateY(20px) rotate(10deg);
            }
        }

        .hero-imgs img:nth-child(1) {
            width: 250px;
            transform: scale(1.7);
            /* transform: translate(80px, 20px) rotate(-30deg); */
        }

        .hero-imgs img:nth-child(2) {
            width: 300px;
            transform: translate(-60px, -80px) rotate(40deg);
        }

        @media (max-width:600px) {
            .swiper {
                height: 100vh;
            }

            .hero-imgs img:nth-child(1) {
                width: 100%;
                margin: auto;
                transform: scale(1);
            }

            .hero-content {
                margin-top: -50px;
            }
        }
    </style>
<body>
<?php 
    $currentPage = "home";
    include('./includes/navbar.php');
?>

<div class="swiper swiper-1">
    <div class="swiper-wrapper">
        <div class="swiper-slide slides">
            <div class="hero-imgs">
                <!-- <img src="./assets/img/laptop-1.png" alt=""> -->
                <img src="./assets/img/laptop-2.png" alt="">
            </div>
            <div class="hero-content">
                <h1><span style="color: #3167eb;">TecHunt, </span>Modern<br/> E-commerce store</h1>
                <p>Best place to search & shop for latest laptops</p>
            </div>
            <!-- <div class="hero-imgs">
                <img src="./assets/img/laptop-1.png" alt="">
                <img src="./assets/img/laptop-2.png" alt="">
            </div> -->
        </div>
        <div class="swiper-slide slides">

        </div>
        <div class="swiper-slide slides">
            
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<main>
    <div class="store-features">
        <div class="feature">
            <div class="icon">
                <ion-icon name="person-circle"></ion-icon>
            </div>
            <h3>CUSTOMER SUPPORT</h3>
            <p>
                We keep our customers updated with very information needed
            </p>
        </div>
        <div class="feature">
            <div class="icon">
                <ion-icon name="card"></ion-icon>
            </div>
            <h3>SECURED PAYMENT</h3>
            <p>
                All our payments are safe & secured
            </p>
        </div>
        <div class="feature">
            <div class="icon">
                <ion-icon name="arrow-undo"></ion-icon>
            </div>
            <h3>FREE RETURNS</h3>
            <p>
                Free return if you don't like the product
            </p>
        </div>
        <div class="feature">
            <div class="icon">
                <ion-icon name="rocket"></ion-icon>
            </div>
            <h3>FREE SHIPPING</h3>
            <p>
                We offer Free Shipping on all the products
            </p>
        </div>
    </div>

    <div class="featured-products">
        <h1>Featured Products</h1>
        <div class="product-container">
            <?php 
               require_once('./database/database.php');
               $displayQuery = "SELECT * FROM products WHERE product_type = 'featured'";
               $displayResult = mysqli_query($connection, $displayQuery);

               if (mysqli_num_rows($displayResult)>0) {
                    while ($row = mysqli_fetch_array($displayResult)) {
                        $productURL  = $row['product_url'];
                        $productName  = $row['product_name'];
                        $productCost  = $row['product_cost'];
                        $pid  = $row['product_id'];
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

    <div class="product-banner">
        <div class="overlay"></div>
        <div class="banner-content">
            <h4>Limited Time Offer!</h4>
            <h2>ROG Strix G17 G713</h2>
            <p>Amp up your entire Windows 10 Home gaming experience with the slick and sporty new ROG Strix G15 Advantage Edition. Double up on AMD firepower with up to a powerful Ryzen™ 9 5900HX CPU and Radeon™ RX 6800M GPU. </p>
            <!-- <p>Order Now & Get it for <span>₹ 1,67,990.00/- </span><span>₹ 1,29,999.00/-</span>only</p> -->
            <!-- <button id="get">Get it Now</button> -->
        </div>
    </div>

    <div class="brand" style="overflow: hidden;">
        <div class="brand-image">
            <img style="width:100%; max-width: 450px; transform:scale(1.4);" src="./assets/img/brand-slider/img-1.png" alt="">
        </div>
        <div class="brand-content">
            <h4>For Creators</h4>
            <h2>ROG Zephyrus Duo 15 GX550</h2>
            <p>
                Latest 10th Gen Intel Core i7-10875H Processor
                32GB DDR4 3200MHz RAM | 2TB  SSD in RAID | Windows 10 Professional
                ROG Aura Sync System with RGB Keyboard
            </p>
            <a href="./store" style="text-decoration: none; color:#fff;"><button>Order Now</button></a>
        </div>
    </div>

    <div class="sponsor">
        <h1>Sponsors</h1>
        <div class="company-logos">
            <ion-icon name="logo-behance"></ion-icon>
            <ion-icon name="logo-steam"></ion-icon>
            <ion-icon name="logo-xbox"></ion-icon>
            <ion-icon name="logo-playstation"></ion-icon>
            <ion-icon name="logo-soundcloud"></ion-icon>
            <ion-icon name="logo-twitch"></ion-icon>
        </div>
    </div>
</main>

<?php include('./includes/footer.php') ?>
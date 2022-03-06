<?php 
    $pageTitle = "TecHunt - WishList Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
    </head>
<body>
<?php 
    $currentPage = "wishlist";
    $logged = false;
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }
    include('./includes/navbar.php');
?>
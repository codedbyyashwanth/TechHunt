<?php
    if (!isset($_GET['id'])) {
        header("Location: blog");
    }
?>

<?php 
    $pageTitle = "TecHunt - Blog Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
        <link rel="stylesheet" href="./assets/css/blog.css">
    </head>
<body>
<?php 
    $currentPage = "blog";
    $logged = false;
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }
    include('./includes/navbar.php');
?>

<main>
    <?php
        require_once('./database/database.php');
        $id = $_GET['id'];
        $query = "SELECT * FROM blog WHERE blog_id = '$id'";
        $result = mysqli_query($connection, $query);
        $data = mysqli_fetch_array($result);
        
        $title = $data['title'];
        $url = $data['img_url'];
        $description = $data['description'];
    ?>
    <div class="blog-content">
        <h1><?php echo $title; ?></h1>
        <div class="img-container">
            <img src="<?php echo $url; ?>" alt="">
        </div>
        <div class="desc"><?php echo htmlspecialchars_decode($description); ?></div>
    </div>
</main>


<?php include('./includes/footer.php') ?>
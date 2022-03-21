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
    <div class="op-blog">
        <a href="./editor"><button>Create Post</button></a>
        <form action="./blog" method="POST">
            <button name="ViewPost" type="submit">View Post</button>
        </form>
    </div>
    <div class="blog-content-container">
        <?php 
            require_once('./database/database.php');

            $edit = false;

            if (isset($_POST['ViewPost'])) {
                $id = $_SESSION['id'];
                $edit = true;
                $query = "SELECT * FROM blog WHERE user_id = '$id'";
            } else {
                $edit = false;
                $query = "SELECT * FROM blog";
            }

            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    echo '
                    <figure class="blog-content-card">
                    <div class="img-container">
                        <img src=" '.$row['img_url']. ' "  alt="">
                    </div>
                    <div class="text-container">
                        <h2>'.$row['title'].'</h2>
                        <p>'. substr( $row['description'], 0, 280) .'...</p>
                        <form action="./blog-post" method="get">
                            <input hidden value="'. $row['blog_id'] .'" name="id" />
                            <button type="submit">Read More</button>
                        </form>
                    </div>
                </figure>
                    ';
                }
            } else {
                echo "<h4>No data in the database</h4>";
            }
        ?>
    </div>
</main>


<?php include('./includes/footer.php') ?>
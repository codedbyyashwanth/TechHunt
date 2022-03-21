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
        $userId = $data['user_id'];
        $description = $data['description'];

        echo '<div class="blog-content">
        <h1>'.$title.'</h1>
        <div class="img-container">
            <img src="'.$url.'" alt="">
        </div>
        <div class="desc">';
        echo htmlspecialchars_decode($description);
        echo '</div>
        </div>';

        if ($userId == $_SESSION['id']) {
            echo '<div class="edit">
            <form action="./editor" method="POST">
                <input hidden value="'.$id.'" name="bid" />
                <button name="EditPost" type="submit">Edit Post</button>
            </form>
            <form action="./action" method="POST">
                <input hidden value="'.$id.'" name="bid" />
                <button name="DeletePost" type="submit">Delete Post</button>
            </form>
        </div>';
        }

    ?>
    
</main>


<?php include('./includes/footer.php') ?>
<?php 
    $pageTitle = "TecHunt - Editor Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./assets/css/blog.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    </head>
    <style>
        form label {
            font-weight: 600;
        }

        form .editor-btn {
            padding: 5px 10px;
            background-color: #fafafa;
            border: 1px solid rgba(0,0,0,0.3);
            outline: none;
        }

        form .btn-div {
            margin-bottom: 10px;
        }

        form .content {
            border: 1px solid rgba(0, 0, 0, 0.3);
            outline: none;
            padding: 20px;
            height: 500px;
            overflow-y: scroll;
        }
    </style>
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
        $edit = isset($_POST['EditPost']);
        if ($edit) {
            $bid = $_POST['bid'];
            $query = "SELECT * FROM blog WHERE blog_id = '$bid'";
            $result = mysqli_query($connection, $query);

            $row = mysqli_fetch_assoc($result);
            $title = $row['title'];
            $url = $row['img_url'];
            $description = $row['description'];
        }
    ?>
    <div class="container">
        <form action="./action" method="POST" class="row g-3 mt-5">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Blog Title</label>
                <?php
                    if (isset($_POST['EditPost'])) {
                        echo '<input type="text" name="title" class="form-control" id="inputEmail4" placeholder="Top 5 Programming Language 2022" value="'.$title.'">';
                    } else {
                        echo '<input type="text" name="title" class="form-control" id="inputEmail4" placeholder="Top 5 Programming Language 2022">';
                    }
                ?>
            </div>
            <div class="col-md-6">
                <label for="inputEmail5" class="form-label">Featured Image</label>
                <?php
                    if (isset($_POST['EditPost'])) {
                        echo '<input type="text" name="url"  class="form-control" id="inputEmail5" placeholder="Image URL" value="'.$url.'">';
                    } else {
                        echo '<input type="text" name="url"  class="form-control" id="inputEmail5" placeholder="Image URL">';
                    } 
                ?>
                
            </div>
            <div class="col-12">
                <label for="inputEmail2" class="form-label">Blog Content</label>
                <div class="btn-div">
                    <button type="button" class="editor-btn" data-element="bold"><i class="bi bi-type-bold"></i></button>
                    <button type="button" class="editor-btn" data-element="italic"><i class="bi bi-type-italic"></i></button>
                    <button type="button" class="editor-btn" data-element="underline"><i class="bi bi-type-underline"></i></button>
                    <button type="button" class="editor-btn" data-element="strikeThrough"><i class="bi bi-type-strikethrough"></i></button>
                    <button type="button" class="editor-btn" data-element="insertUnorderedList"><i class="bi bi-list-ul"></i></button>
                    <button type="button" class="editor-btn" data-element="insertOrderedList"><i class="bi bi-list-ol"></i></button>
                    <button type="button" class="editor-btn" data-element="createLink"><i class="bi bi-link"></i></button>
                    <!-- <button type="button" class="editor-btn" data-element="insertImage"><i class="bi bi-image"></i></button> -->
                    <button type="button" class="editor-btn" data-element="justifyLeft"><i class="bi bi-text-left"></i></button>
                    <button type="button" class="editor-btn" data-element="justifyCenter"><i class="bi bi-text-center"></i></button>
                    <button type="button" class="editor-btn" data-element="justifyRight"><i class="bi bi-text-right"></i></button>
                </div>
                <?php
                    if (isset($_POST['EditPost'])) {
                        echo '<div class="content" contenteditable="true" id="content">'.$description.'</div>';
                    } else {
                        echo '<div class="content" contenteditable="true" id="content">Your Content</div>';
                    } 
                ?>
                
                <!-- <textarea contenteditable="true"  class="form-control content" name="content"  id="inputEmail2" placeholder="The content of the blog....."></textarea> -->
            </div>
            <script>
                const buttons = document.querySelectorAll(".editor-btn");

                buttons.forEach(button => {
                    button.addEventListener("click", (e) => {
                        const command = button.dataset['element'];
                        document.execCommand(command, false, null);
                    });
                });
            </script>
            <div class="col-12 mt-5">
                <textarea type="text" id="contentValue" name="content" hidden></textarea>
                <?php
                    if (isset($_POST['EditPost'])) {
                        echo '<button id="upload" type="button" class="btn btn-primary">Update</button>';
                    } else {
                        echo '<button id="upload" type="button" class="btn btn-primary">Upload</button>';
                    } 
                ?>
                
                <?php
                    if (isset($_POST['EditPost'])) {
                        echo '
                        <input hidden value="'.$bid.'" name="bid" />
                        <button type="submit" hidden name="edit-content" class="btn btn-primary" id="sendData"></button>';
                    } else {
                        echo '<button type="submit" hidden name="blog-content" class="btn btn-primary" id="sendData"></button>';
                    } 
                ?>
                <a href="./blog" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        <script>
            const upload = document.getElementById("upload");
            const contentDiv = document.getElementById("content");
            const contentVal = document.getElementById("contentValue");
            const sendData = document.getElementById("sendData");

            upload.addEventListener("click", () => {
                let content = contentDiv.innerHTML;
                const check = content.substr(0,5);
                if (check.includes("div"))
                    contentVal.textContent = "<p>" + content + "</p>";
                else
                    contentVal.textContent = content;
                sendData.click();
            });
        </script>
    </div>
</main>
<?php 
    $pageTitle = "TecHunt - Account Page";
    include('./includes/header.php');
    if(!isset($_SESSION)) {
        session_start();
    }
?>
    <link rel="stylesheet" href="./assets/css/account.css">
    </head>
<body>
<?php 
    $currentPage = "account";
    $logged = false;
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }
    include('./includes/navbar.php');
?>

<?php 
    require_once('./database/database.php');
    if (isset($_POST['Sign-Up'])) {
        $name = $_POST['username'];
        $address = $_POST['address'];
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $query = "INSERT INTO user (name, password, address, email) VALUES ('$name','$password','$address','$email')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "
            <script>
                alert('Account has been created');
            </script>";
            header("Location: account");
        } else {
            echo "<script>alert('Account was not created')</script>";
        }
    }

?>

<main>
    <div class="login-container">
        <h3>Register Account</h3>
        <form action="./signup" method="POST">
            <input type="text" placeholder="Username" name="username">
            <input type="mail" placeholder="Email Address" name="mail">
            <input type="password" placeholder="Password" name="password">
            <input type="text" placeholder="Residental Address" name="address">
            <input type="submit" value="Submit" name="Sign-Up">
        </form>
        <a href="./account">Already Registered? Log In</a>
    </div>
</main>

<?php include('./includes/footer.php') ?>
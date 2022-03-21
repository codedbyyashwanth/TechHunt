<?php 
    $pageTitle = "TecHunt Admin - Account Page ";
    include('../includes/header.php');
    $logged = false;
    if(!isset($_SESSION)) {
        session_start();
    }

    
    if ((isset($_SESSION['email']) && isset($_SESSION['password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['password']))) {
        $logged = true;
    }

?>
    <link rel="stylesheet" href="./styles/account.css">
<main>
    <?php
        require_once("../database/database.php");
        if (isset($_POST['Login'])) {
            $email = $_POST['mail'];
            $password = $_POST['password'];

            $query = "SELECT * FROM vendor WHERE email = '$email' AND password = '$password' ";
            $result = mysqli_query($connection, $query);
            $data = mysqli_fetch_array($result);
            $name = $data['vendor_name'];
            $address = $data['area'];
            $id = $data['vendor_id'];

            if (mysqli_num_rows($result) > 0) {
                global $email, $password, $name, $address, $id;

                $_SESSION['email'] = $email;
                $_SESSION['vendor_name'] = $name;
                $_SESSION['address'] = $address;
                $_SESSION['vendor_password'] = $password;
                $_SESSION['vendor_id'] = $id;

                header("Location: index");

            } else {
                header("Location: signup");
            }
        } 
    ?>
<div class="login-container">
    <h3>Login Account</h3>
    <form action="./login" method="POST">
        <input type="mail" placeholder="Email Address" name="mail">
        <input type="password" placeholder="Password" name="password">
        <input type="submit" value="Log In" name="Login">
    </form>
    <a href="./signup">Don't have an Account? Register Now</a>
</div>
</main>

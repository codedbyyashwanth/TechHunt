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
<?php 
    require_once('../database/database.php');
    if (isset($_POST['Sign-Up'])) {
        $name = $_POST['username'];
        $address = $_POST['address'];
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $tod = $_POST['tod'];
        $query = "INSERT INTO vendor (vendor_name, tod, area,email, password) VALUES ('$name','$tod','$address','$email','$password')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "
            <script>
                alert('Account has been created');
            </script>";
            header("Location: index");
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
            <input type="text" placeholder="Max. Time of Delivery" name="tod">
            <input type="submit" value="Submit" name="Sign-Up">
        </form>
        <a href="./login">Already Registered? Log In</a>
    </div>
</main>

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



?>

<main>
    <?php 
        require_once("./database/database.php");
        if (isset($_POST['Login'])) {
            $email = $_POST['mail'];
            $password = $_POST['password'];

            $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password' ";
            $result = mysqli_query($connection, $query);
            $data = mysqli_fetch_array($result);
            $name = $data['name'];
            $address = $data['address'];
            $id = $data['user_id'];

            if (mysqli_num_rows($result) > 0) {
                global $email, $password, $name, $address, $id;

                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                $_SESSION['address'] = $address;
                $_SESSION['password'] = $password;
                $_SESSION['id'] = $id;

                echo '
                            <div class="tab-layout">
                            <ul class="tabs">
                                <p data-tab-target="#account" class="active tab">Account Details</p>
                                <p data-tab-target="#orders" class="tab">Orders</p>
                                <p data-tab-target="#edit" class="tab">Edit Details</p>
                                <p data-tab-target="#logout" class="tab">Logout</p>
                                <p data-tab-target="#deactivate" class="tab" style="color: #ff3333">Deactivate Account</p>
                            </ul>
                    
                            <div class="tab-content">
                                <div id="account" data-tab-content class="active">
                                    <h2>Account Details</h2>
                                    <span><span class="holder" style="font-weight: 600;">Name: </span>'.$name.'</span>
                                    <span><span class="holder" style="font-weight: 600;">Email ID: </span>'.$email.'</span>
                                    <span><span class="holder" style="font-weight: 600;">Address: </span>'.$address.'</span>
                                </div>
                                <div id="orders" data-tab-content>
                                <h2 style=" font-size: 2rem; margin-bottom: 30px;">Your Orders</h2>';
                                if (isset($_SESSION['id'])) {
                                    $id = $_SESSION['id'];
                                    $orderQuery = "SELECT * FROM orders WHERE user_id = $id";
                                    $orderResult = mysqli_query($connection, $orderQuery);
                            
                                    if (mysqli_num_rows($orderResult) > 0) {
                                        $subCost = 0;
                            
                                        echo '
                                        <div class="container">
                                        <div class="order-container">
                                             
                                            <div class="card-container">
                                        ';
                                                while ($row = mysqli_fetch_array($orderResult)) {
                                                    $productId = $row['product_id'];
                            
                                                    $productQuery = "SELECT *, product_cost as cost FROM products WHERE product_id = $productId";
                                                    $productResult = mysqli_query($connection, $productQuery);
                            
                                                    if ($row2 = mysqli_fetch_array($productResult)) {
                                                            global $subCost;
                                                            global $row;
                                                            $subCost += $row2['product_cost'];
                                                            $productCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $row2['product_cost']);
                                                            echo '
                                                            <div class="card">
                                                                <div class="card-info">
                                                                    <img src="'.$row2['product_url']. '" alt="">
                                                                    <h3>' .$row2['product_name']. '</h3>
                                                                </div>
                                                                <div class="cart-manage">
                                                                    <form action="" method="post">
                                                                        <h3>₹ '.$productCost.'</h3>
                                                                        <div class="quantity">
                                                                            <input type="number" readonly name="quantity" id=" " value="'.$row['quantity'].'" min="1" max="10">
                                                                        </div>
                                                                    </form>
                                                                    <form hidden action="" method="POST">
                                                                        <button hidden type="submit">
                                                                            <ion-icon name="trash-outline"></ion-icon>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            ';
                                                    }
                                                }
                            
                                                echo '</div></div></div>';
                                    }
                                }
                                echo '</div>
                                <div id="edit" data-tab-content>
                                    <h2>Edit Account Details</h2>
                                    <form action="./account" method="POST">
                                        <div class="input-fields">
                                            <span style="display: block;">Username: </span>
                                            <input type="text" name="name" placeholder="Name" value="'.$name.'">
                                        </div>
                                        <div class="input-fields">
                                            <span style="display: block;">Email ID: </span>
                                            <input type="text" name="email" placeholder="Email" value="'.$email.'">
                                        </div>
                                        <div class="input-fields">
                                            <span style="display: block;">Residental Address: </span>
                                            <input type="text" name="address" placeholder="Address" value="'.$address.'">
                                        </div>
                                        <input name="id" hidden value="'.$id.'"/>
                                        <button type="submit" name="editinfo">Submit</button>
                                    </form>
                                </div>    
                                <div id="logout" data-tab-content>
                                    <h2>Logout</h2>
                                    <h4>Hello '.$name.', </h3>
                                    <p>Do you want to logout from <span style="font-weight: 600;">'.$email.'</span>  account ?</p>
                                    
                                    <form method="POST" action="./action">
                                        <button name="logout" type="submit">Logout</button>
                                    </form>
                                </div>
                                <div id="deactivate" data-tab-content>
                                    <h2>Deactivate Account</h2>
                                    <h4>Hello '.$name.', </h3>
                                    <p>Do you want to <span style="font-weight: 600;">Deactivate</span>    your account ?</p>
                                    <form action="./action" method="POST">
                                        <button name="deactivate" type="submit">Deactivate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';

            } else {
                header("Location: signup");
            }
        } else if (isset($_POST['editinfo'])) {
            $name = $_POST['name'];
            $id = $_POST['id'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $updateQuery = "UPDATE user SET name = '$name', email = '$email', address ='$address' WHERE user_id = $id";
            $updateResult = mysqli_query($connection, $updateQuery);
            if ($updateResult) {
                echo "<script>alert('Information is Udated');</script>";

                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;  
                    $_SESSION['address'] = $address;
                    $password = $_SESSION['password'];
                    $id = $_SESSION['id'];

                    echo '
                                <div class="tab-layout">
                                <ul class="tabs">
                                    <p data-tab-target="#account" class="active tab">Account Details</p>
                                    <p data-tab-target="#orders" class="tab">Orders</p>
                                    <p data-tab-target="#edit" class="tab">Edit Details</p>
                                    <p data-tab-target="#logout" class="tab">Logout</p>
                                    <p data-tab-target="#deactivate" class="tab" style="color: #ff3333">Deactivate Account</p>
                                </ul>
                        
                                <div class="tab-content">
                                    <div id="account" data-tab-content class="active">
                                        <h2>Account Details</h2>
                                        <span><span class="holder" style="font-weight: 600;">Name: </span>'.$name.'</span>
                                        <span><span class="holder" style="font-weight: 600;">Email ID: </span>'.$email.'</span>
                                        <span><span class="holder" style="font-weight: 600;">Address: </span>'.$address.'</span>
                                    </div>
                                    <div id="orders" data-tab-content>
                                    <h2 style=" font-size: 2rem; margin-bottom: 30px;">Your Orders</h2>';
                                    if (isset($_SESSION['id'])) {
                                        $id = $_SESSION['id'];
                                        $orderQuery = "SELECT * FROM orders WHERE user_id = $id";
                                        $orderResult = mysqli_query($connection, $orderQuery);
                                
                                        if (mysqli_num_rows($orderResult) > 0) {
                                            $subCost = 0;
                                
                                            echo '
                                            <div class="container">
                                            <div class="order-container">
                                                 
                                                <div class="card-container">
                                            ';
                                                    while ($row = mysqli_fetch_array($orderResult)) {
                                                        $productId = $row['product_id'];
                                
                                                        $productQuery = "SELECT *, product_cost as cost FROM products WHERE product_id = $productId";
                                                        $productResult = mysqli_query($connection, $productQuery);
                                
                                                        if ($row2 = mysqli_fetch_array($productResult)) {
                                                                global $subCost;
                                                                global $row;
                                                                $subCost += $row2['product_cost'];
                                                                $productCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $row2['product_cost']);
                                                                echo '
                                                                <div class="card">
                                                                    <div class="card-info">
                                                                        <img src="'.$row2['product_url']. '" alt="">
                                                                        <h3>' .$row2['product_name']. '</h3>
                                                                    </div>
                                                                    <div class="cart-manage">
                                                                        <form action="" method="post">
                                                                            <h3>₹ '.$productCost.'</h3>
                                                                            <div class="quantity">
                                                                                <input type="number" readonly name="quantity" id=" " value="'.$row['quantity'].'" min="1" max="10">
                                                                            </div>
                                                                        </form>
                                                                        <form hidden action="" method="POST">
                                                                            <button hidden type="submit">
                                                                                <ion-icon name="trash-outline"></ion-icon>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                ';
                                                        }
                                                    }
                                
                                                    echo '</div></div></div>';
                                        }
                                    }
                   
                    echo '</div>
                                    <div id="edit" data-tab-content>
                                        <h2>Edit Account Details</h2>
                                        <form action="./account" method="POST">
                                            <div class="input-fields">
                                                <span style="display: block;">Username: </span>
                                                <input type="text" name="name" placeholder="Name" value="'.$name.'">
                                            </div>
                                            <div class="input-fields">
                                                <span style="display: block;">Email ID: </span>
                                                <input type="text" name="email" placeholder="Email" value="'.$email.'">
                                            </div>
                                            <div class="input-fields">
                                                <span style="display: block;">Residental Address: </span>
                                                <input type="text" name="address" placeholder="Address" value="'.$address.'">
                                            </div>
                                            <input name="id" hidden value="'.$id.'"/>
                                            <button type="submit" name="editinfo">Submit</button>
                                        </form>
                                    </div>    
                                    <div id="logout" data-tab-content>
                                        <h2>Logout</h2>
                                        <h4>Hello '.$name.', </h3>
                                        <p>Do you want to logout from <span style="font-weight: 600;">'.$email.'</span>  account ?</p>
                                        
                                    <form method="POST" action="./action">
                                        <button name="logout" type="submit">Logout</button>
                                    </form>
                                    </div>
                                    <div id="deactivate" data-tab-content>
                                        <h2>Deactivate Account</h2>
                                        <h4>Hello '.$name.', </h3>
                                        <p>Do you want to <span style="font-weight: 600;">Deactivate</span>    your account ?</p>
                                        <form action="./action" method="POST">
                                        <button name="deactivate" type="submit">Deactivate</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        ';              
            } else {
                echo "<script>alert('Information is not updated');</script>";
            }
        }  else {
            if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
                if (!empty($_SESSION['email']) && !empty($_SESSION['password'])) {
                    $email = $_SESSION['email'];
                    $name = $_SESSION['name'];  
                    $address = $_SESSION['address'];
                    $password = $_SESSION['password'];
                    $id = $_SESSION['id'];

                echo '
                            <div class="tab-layout">
                            <ul class="tabs">
                                <p data-tab-target="#account" class="active tab">Account Details</p>
                                <p data-tab-target="#orders" class="tab">Orders</p>
                                <p data-tab-target="#edit" class="tab">Edit Details</p>
                                <p data-tab-target="#logout" class="tab">Logout</p>
                                <p data-tab-target="#deactivate" class="tab" style="color: #ff3333">Deactivate Account</p>
                            </ul>
                    
                            <div class="tab-content">
                                <div id="account" data-tab-content class="active">
                                    <h2>Account Details</h2>
                                    <span><span class="holder" style="font-weight: 600;">Name: </span>'.$name.'</span>
                                    <span><span class="holder" style="font-weight: 600;">Email ID: </span>'.$email.'</span>
                                    <span><span class="holder" style="font-weight: 600;">Address: </span>'.$address.'</span>
                                </div>
                                <div id="orders" data-tab-content>
                                <h2 style=" font-size: 2rem; margin-bottom: 30px;">Your Orders</h2>';

                                    if (isset($_SESSION['id'])) {
                                        $id = $_SESSION['id'];
                                        $orderQuery = "SELECT * FROM orders WHERE user_id = $id";
                                        $orderResult = mysqli_query($connection, $orderQuery);
                                
                                        if (mysqli_num_rows($orderResult) > 0) {
                                            $subCost = 0;
                                
                                            echo '
                                            <div class="container">
                                            <div class="order-container">
                                                 
                                                <div class="card-container">
                                            ';
                                                    while ($row = mysqli_fetch_array($orderResult)) {
                                                        $productId = $row['product_id'];
                                
                                                        $productQuery = "SELECT *, product_cost as cost FROM products WHERE product_id = $productId";
                                                        $productResult = mysqli_query($connection, $productQuery);
                                
                                                        if ($row2 = mysqli_fetch_array($productResult)) {
                                                                global $subCost;
                                                                global $row;
                                                                $subCost += $row2['product_cost'];
                                                                $productCost = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $row2['product_cost']);
                                                                echo '
                                                                <div class="card">
                                                                    <div class="card-info">
                                                                        <img src="'.$row2['product_url']. '" alt="">
                                                                        <h3>' .$row2['product_name']. '</h3>
                                                                    </div>
                                                                    <div class="cart-manage">
                                                                        <form action="" method="post">
                                                                            <h3>₹ '.$productCost.'</h3>
                                                                            <div class="quantity">
                                                                                <input type="number" readonly name="quantity" id=" " value="'.$row['quantity'].'" min="1" max="10">
                                                                            </div>
                                                                        </form>
                                                                        <form  action="" method="POST">
                                                                            <button hidden type="submit">
                                                                                <ion-icon name="trash-outline"></ion-icon>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                ';
                                                        }
                                                    }
                                                    echo '</div></div></div>';
                                        }
                                    }
                            
                                echo '
                                </div>
                                <div id="edit" data-tab-content>
                                    <h2>Edit Account Details</h2>
                                    <form action="./account" method="POST">
                                        <div class="input-fields">
                                            <span style="display: block;">Username: </span>
                                            <input type="text" name="name" placeholder="Name" value="'.$name.'">
                                        </div>
                                        <div class="input-fields">
                                            <span style="display: block;">Email ID: </span>
                                            <input type="text" name="email" placeholder="Email" value="'.$email.'">
                                        </div>
                                        <div class="input-fields">
                                            <span style="display: block;">Residental Address: </span>
                                            <input type="text" name="address" placeholder="Address" value="'.$address.'">
                                        </div>
                                        <input name="id" hidden value="'.$id.'"/>
                                        <button type="submit" name="editinfo">Submit</button>
                                    </form>
                                </div>    
                                <div id="logout" data-tab-content>
                                    <h2>Logout</h2>
                                    <h4>Hello '.$name.', </h3>
                                    <p>Do you want to logout from <span style="font-weight: 600;">'.$email.'</span>  account ?</p>
                                    
                                    <form method="POST" action="./action">
                                        <button name="logout" type="submit">Logout</button>
                                    </form>
                                </div>
                                <div id="deactivate" data-tab-content>
                                    <h2>Deactivate Account</h2>
                                    <h4>Hello '.$name.', </h3>
                                    <p>Do you want to <span style="font-weight: 600;">Deactivate</span>    your account ?</p>
                                    <form action="./action" method="POST">
                                        <button name="deactivate" type="submit">Deactivate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                } else {
                    echo "No Email and Password Set";
                }
            } else {
                echo '
                    <div class="login-container">
                        <h3>Login Account</h3>
                        <form action="./account" method="POST">
                            <input type="mail" placeholder="Email Address" name="mail">
                            <input type="password" placeholder="Password" name="password">
                            <input type="submit" value="Submit" name="Login">
                        </form>
                        <a href="./signup">Don\'t have an Account? Register Now</a>
                    </div>
                    ';
            }
        }
    ?>

</main>

<script>
    const tabs = document.querySelectorAll('[data-tab-target]')
    const tabContents = document.querySelectorAll('[data-tab-content]')

    tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = document.querySelector(tab.dataset.tabTarget)
        tabContents.forEach(tabContent => {
        tabContent.classList.remove('active')
        })
        tabs.forEach(tab => {
        tab.classList.remove('active')
        })
        tab.classList.add('active')
        target.classList.add('active')
    })
    })
</script>

<?php include('./includes/footer.php') ?>
<?php 
    $pageTitle = "TecHunt Admin - Products Page ";
    include('../includes/header.php');
    $logged = false;
    if(!isset($_SESSION)) {
        session_start();
    }

    
    if ((isset($_SESSION['email']) && isset($_SESSION['vendor_password'])) && (!empty($_SESSION['email']) && !empty($_SESSION['vendor_password']))) {
        $logged = true;
    }

    if (!$logged) {
        header("Location: login");
    } 
?> 
    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/THLogo.png" type="image/x-icon">  

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./styles/product.css">

    <style>
        form div label{
            font-weight: 600;
        }

        form div input {
            padding: 0.6rem;
        }
    </style>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<?php 
    $currentPage = "home";
    include('../includes/adminNav.php');
?>

<main>
    <div class="container">
        <?php 
            require_once('../database/database.php');
            if (isset($_POST['edit'])) {
                $id = $_POST['id'];
                $query = "SELECT * FROM products WHERE product_id = '$id'";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result);
                $ProductName = $row['product_name'];
                $ProductCost = $row['product_cost'];
                $ProductQuantity = $row['product_quantity'];
                $ProductBrand = $row['product_brand'];
                $ProductCategory = $row['product_category'];
                $ProductURL = $row['product_url'];
                $ProductDescription = $row['product_description'];
                $ProductType = $row['product_type'];
                $ProductOnSale = $row['on_sale'];
                $ProductRating = $row['rating'];
                $VendorId = $_SESSION["vendor_id"];

                echo '
                    <form class="row g-3 " action="./action" method="POST">
                        <div class="col-md-4 pt-4">
                            <label for="inputEmail4" class="form-label">Product Name</label>
                            <input name="ProductName" type="text" class="form-control" id="inputEmail4" placeholder="ROG Strix G17 G713" value="'.$ProductName.'"> 
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputPassword4" class="form-label">Product Cost</label>
                            <input name="ProductCost" type="number" class="form-control" id="inputPassword4" placeholder="₹ 1,54,990" value="'.$ProductCost.'">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputAddress" class="form-label">Quantity</label>
                            <input name="ProductQuantity" type="number" class="form-control" id="inputAddress" placeholder="99" value="'.$ProductQuantity.'">
                        </div>
                        <div class="col-12 pt-4">
                            <label for="inputAddress2" class="form-label">Product Description</label>
                            <textarea name="ProductDescription" type="text" class="form-control" id="inputAddress2"  rows="5"  placeholder="Free upgrade to Windows 11 when available. Upgraded rollout plan is being finalized....."> '.$ProductDescription.'</textarea>
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputEmail4" class="form-label">Brand</label>
                            <input name="ProductBrand" type="text" class="form-control" id="inputEmail4" style="text-transform:uppercase" placeholder="ASUS" value="'.$ProductBrand.'">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputPassword4" class="form-label">Category</label>
                            <input name="ProductCategory" type="text" class="form-control" id="inputPassword4" placeholder="Laptop" value="'.$ProductCategory.'">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputAddress" class="form-label">Product Type</label>
                            <select class="form-select" aria-label="Default select example" name="ProductType">
                                <option  value="'.$ProductType.'">'.$ProductType.'</option>
                                <option value="featured">Featured</option>
                                <option value="normal">Normal</option>
                            </select>
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputEmail4" class="form-label">Product URL</label>
                            <input name="ProductURL" placeholder="Image URL" type="text" class="form-control" id="inputEmail4" value="'.$ProductURL.'">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputPassword4" class="form-label">On Sale</label>
                            <select class="form-select" aria-label="Default select example" name="ProductOnSale">
                                <option  value="'.$ProductOnSale.'"> '.$ProductOnSale.'</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputAddress" class="form-label">Rating</label>
                            <input name="ProductRating" type="number" class="form-control" id="inputAddress" placeholder="4" value="'.$ProductRating.'">
                        </div>
                        <input type="text" hidden value="'.$VendorId.'" name="vendor_id">
                        <input type="text" hidden value="'.$id.'" name="id"/>
                        <div class="col-12 pt-5">
                            <button name="UpdateProduct" type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                ';

            } else {
                echo '
                    <form class="row g-3 " action="./action" method="POST">
                        <div class="col-md-4 pt-4">
                            <label for="inputEmail4" class="form-label">Product Name</label>
                            <input name="ProductName" type="text" class="form-control" id="inputEmail4" placeholder="ROG Strix G17 G713"> 
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputPassword4" class="form-label">Product Cost</label>
                            <input name="ProductCost" type="number" class="form-control" id="inputPassword4" placeholder="₹ 1,54,990">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputAddress" class="form-label">Quantity</label>
                            <input name="ProductQuantity" type="number" class="form-control" id="inputAddress" placeholder="99">
                        </div>
                        <div class="col-12 pt-4">
                            <label for="inputAddress2" class="form-label">Product Description</label>
                            <textarea name="ProductDescription" type="text" class="form-control" id="inputAddress2"  rows="5"  placeholder="Free upgrade to Windows 11 when available. Upgraded rollout plan is being finalized....."></textarea>
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputEmail4" class="form-label">Brand</label>
                            <input name="ProductBrand" type="text" class="form-control" id="inputEmail4" style="text-transform:uppercase" placeholder="ASUS">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputPassword4" class="form-label">Category</label>
                            <input name="ProductCategory" type="text" class="form-control" id="inputPassword4" placeholder="Laptop">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputAddress" class="form-label">Product Type</label>
                            <select class="form-select" aria-label="Default select example" name="ProductType">
                                <option>Select</option>
                                <option value="featured">Featured</option>
                                <option value="normal">Normal</option>
                            </select>
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputEmail4" class="form-label">Product URL</label>
                            <input name="ProductURL" placeholder="Image URL" type="text" class="form-control" id="inputEmail4">
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputPassword4" class="form-label">On Sale</label>
                            <select class="form-select" aria-label="Default select example" name="ProductOnSale">
                                <option >Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 pt-4">
                            <label for="inputAddress" class="form-label">Rating</label>
                            <input name="ProductRating" type="number" class="form-control" id="inputAddress" placeholder="4">
                        </div>
                        <input type="text" hidden value="'.$_SESSION["vendor_id"].'" name="vendor_id">
                        <div class="col-12 pt-5">
                            <button name="AddProduct" type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                ';
            }
        ?>
    </div>
</main>
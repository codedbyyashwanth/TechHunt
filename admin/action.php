<?php

    require_once('../database/database.php');

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM products WHERE product_id = '$id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "<script>alert('Poduct has been deleted');</script>";
        } else {
            echo "<script>alert('Poduct has not been deleted');</script>";
        }
        header("Location: index");
    }

    if (isset($_POST['deleteOrders'])) {
        $pid = $_POST['pid'];
        $vid = $_POST['vid'];
        $query = "DELETE FROM orders WHERE product_id = '$pid' and vender_id = '$vid'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "<script>alert('Order has been deleted');</script>";
        } else {
            echo "<script>alert('Order has not been deleted');</script>";
        }
        header("Location: index");
    }

    if (isset($_POST['AddProduct'])) {
        $ProductName = $_POST['ProductName'];
        $ProductCost = $_POST['ProductCost'];
        $ProductQuantity = $_POST['ProductQuantity'];
        $ProductBrand = $_POST['ProductBrand'];
        $ProductCategory = $_POST['ProductCategory'];
        $ProductURL = $_POST['ProductURL'];
        $ProductDescription = $_POST['ProductDescription'];
        $ProductType = $_POST['ProductType'];
        $ProductOnSale = $_POST['ProductOnSale'];
        $ProductRating = $_POST['ProductRating'];
        $VendorId = $_POST['vendor_id'];

        $query = "INSERT INTO products( `vender_ids`,`product_name`, `product_cost`, `product_quantity`, `product_brand`, `product_description`, `product_category`, `product_type`, `product_url`, `on_sale`, `rating`) VALUES ('$VendorId','$ProductName','$ProductCost','$ProductQuantity','$ProductBrand','$ProductDescription','$ProductCategory','$ProductType','$ProductURL','$ProductOnSale','$ProductRating')";

        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "<script>alert('Product added to Account');</script>";
        } else {
            echo "<script>alert('Product not added to Account');</script>";
        }

        header("Location: index");
    }

    if (isset($_POST['UpdateProduct'])) {
        $productId = $_POST['id'];
        $ProductName = $_POST['ProductName'];
        $ProductCost = $_POST['ProductCost'];
        $ProductQuantity = $_POST['ProductQuantity'];
        $ProductBrand = $_POST['ProductBrand'];
        $ProductCategory = $_POST['ProductCategory'];
        $ProductURL = $_POST['ProductURL'];
        $ProductDescription = $_POST['ProductDescription'];
        $ProductType = $_POST['ProductType'];
        $ProductOnSale = $_POST['ProductOnSale'];
        $ProductRating = $_POST['ProductRating'];
        $VendorId = $_POST['vendor_id'];

        $query = "UPDATE products SET `product_name`='$ProductName',`product_cost`='$ProductCost',`product_quantity`='$ProductQuantity',`product_brand`='$ProductBrand',`product_description`='$ProductDescription',`product_category`='$ProductCategory',`product_type`='$ProductType',`product_url`='$ProductURL',`on_sale`='$ProductOnSale',`rating`='$ProductRating' WHERE product_id= '$productId'";

        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "<script>alert('Product Updated');</script>";
        } else {
            echo "<script>alert('Product not Updated');</script>";
        }

        header("Location: index");
    }

    if (isset($_GET['logout'])) {
        session_start();
        session_destroy();
        header("Location: login");
    }

?>
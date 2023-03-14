<?php
session_start();
include 'include/functions.php';
include 'include/header.php';

$conn = connectDB();

// Get all orders
$orders = getAllOrders();

// Get all products
$products = getAllProducts();

// Get all categories
$categories = getAllCategories();

// Get total number of orders
$totalOrders = mysqli_num_rows($orders);

// Get total number of products
$totalProducts = mysqli_num_rows($products);

// Get total number of categories
$totalCategories = mysqli_num_rows($categories);

// Get remaining days until delivery for each order
$remainingDays = array();
foreach ($orders as $order) {
    $orderDate = strtotime($order['order_date']);
    $currentDate = time();
    $datediff = $orderDate - $currentDate;
    $remainingDays[] = floor($datediff / (60 * 60 * 24));
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <!-- Add animate.css library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Add custom style for the page -->
    <style>
        /* Add custom styles here */
        body {
            background-color: #f2f2f2;
        }

        .container {
            padding: 50px;
            text-align: center;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #cccccc;
        }

        h1 {
            font-size: 36px;
            color: #333333;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            font-size: 18px;
            color: #555555;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #333333;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 18px;
            box-shadow: 0px 0px 10px #cccccc;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #ffffff;
            color: #333333;
            cursor: pointer;
            box-shadow: 0px 0px 20px #cccccc;
        }
    </style>

</head>

<body>
    <div class="container animated bounceInDown">
        <h1>Hello World!</h1>
        <p>This is a sample dynamic web page using Bootstrap and Animate.css</p>
        <button class="btn">Click me</button>
    </div>
</body>




</html>
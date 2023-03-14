<?php
include 'include/header.php';
include 'include/functions.php';
include 'include/navbar.php';



$conn = connectDB();

$query = "SELECT COUNT(id) as total_products FROM products";
$result = mysqli_query($conn, $query);
$total_products = mysqli_fetch_assoc($result)['total_products'];

$query = "SELECT COUNT(id) as total_orders FROM orders";
$result = mysqli_query($conn, $query);
$total_orders = mysqli_fetch_assoc($result)['total_orders'];

$query = "SELECT COUNT(id) as total_categories FROM categories";
$result = mysqli_query($conn, $query);
$total_categories = mysqli_fetch_assoc($result)['total_categories'];

$query = "SELECT orders.*, products.name as product_name, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 20 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
$due_orders = mysqli_num_rows($result);



$query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 20 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
$orders_due_in_20_days = mysqli_num_rows($result);



?>

<link rel="stylesheet" href="include/assets/dashboard.css" type="text/css">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-NxidTm7lTlE1iRmFhWt2c7f1nm4tq3oVJ4xOhTz7pTJdS1hZhRum0W61O8+Dz0XaCClOyysEogZG8RRvz+23Kg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Awesome 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-kzv1fELr3+7gI42y8Kl6P+o6YJ9D1piU98Oxanb+rkzOfJcHw47+ESt+RP0oKj/cvY1c9J/XRop0kyz+M1Iv3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>


    <div class="container-fluid py-4">

        <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
                <div class="card bg-primary text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Products</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $total_products; ?></h2>
                        </div>
                        <i class="fas fa-box-open fa-3x"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card bg-success text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Orders</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $total_orders; ?></h2>
                        </div>
                        <i class="fas fa-shopping-cart fa-3x"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card bg-info text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Categories</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $total_categories; ?></h2>
                        </div>
                        <i class="fas fa-list-alt fa-3x"></i>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-6">
                <div class="card bg-info text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Orders due dliver in next 20 days</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $orders_due_in_20_days; ?> </h2>
                        </div>
                        <i class="fas fa-list-alt fa-3x"></i>
                    </div>
                </div>
            </div>




            <div class="container-fluid mt-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Delivery Progress</th>
                                <th>days to deliver</th>
                                <th>Product Image</th>
                                <th>Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                                $progressPercent = ($row['remaining_days'] / 20) * 100;
                            ?>
                                <tr>
                                    <td><?php echo $row['customer_name']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress" style="height: 25px;">
                                                <?php if ($row['remaining_days'] >= 10) { ?>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progressPercent; ?>%; height: 100%;" aria-valuenow="<?php echo $row['remaining_days']; ?>" aria-valuemin="0" aria-valuemax="20"></div>
                                                <?php } elseif ($row['remaining_days'] >= 5 && $row['remaining_days'] < 10) { ?>
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $progressPercent; ?>%; height: 100%;" aria-valuenow="<?php echo $row['remaining_days']; ?>" aria-valuemin="0" aria-valuemax="20"></div>
                                                <?php } else { ?>
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $progressPercent; ?>%; height: 100%;" aria-valuenow="<?php echo $row['remaining_days']; ?>" aria-valuemin="0" aria-valuemax="20"></div>
                                                <?php } ?>
                                            </div>
                                            <div class="progress-label">
                                                <?php echo round($progressPercent); ?>%
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $row['remaining_days']; ?></td>


                                    <td><img src="images/<?php echo $row['product_image']; ?>" alt="Product Image" width="50"></td>
                                    <td><?php echo $row['delivery_date']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>


</body>

</html>
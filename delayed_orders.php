<?php
include 'include/header.php';
include 'include/functions.php';
include 'include/navbar.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) < 0 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);

$delayed_orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="include/assets/dashboard.css" type="text/css">
<!DOCTYPE html>
<html>

<head>
    <title>Delayed Orders</title>
</head>


<body>
    <div class="col-lg-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title">Delayed Orders</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Remaining Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($delayed_orders as $order) { ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><img src="images/<?php echo $order['product_image']; ?>" width="50" height="50"></td>
                                    <td><?php echo $order['order_date']; ?></td>
                                    <td><?php echo $order['delivery_date']; ?></td>
                                    <td><?php echo $order['remaining_days']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
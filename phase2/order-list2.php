<?php
include_once 'include/functions.php';

$conn = connectDB();
$allOrders = getAllOrders();

if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    $allOrders = mysqli_query($conn, "SELECT * FROM orders WHERE customer_name LIKE '%$filter%'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Order List</h1>
        <div class="d-flex justify-content-end my-3">
            <form action="" method="post">
                <input type="text" name="filter" placeholder="Search by customer name...">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($allOrders)) : ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td><?php echo $order['product_id']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

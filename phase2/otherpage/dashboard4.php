<?php
include 'include/header.php';
include 'include/functions.php';

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

$query = "SELECT orders.*, products.name as product_name, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 7 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
?>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Total Products</h5>
                <hr>
                <p class="card-text">
                    <?php echo $total_products; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Total Orders</h5>
                <hr>
                <p class="card-text">
                    <?php echo $total_orders; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Total Categories</h5>
                <hr>
                <p class="card-text">
                    <?php echo $total_categories; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Nearby Orders</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Remaining Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td><?php echo $row['delivery_date']; ?></td>
                                <td><?php echo $row['remaining_days']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'include/footer.php'; ?>
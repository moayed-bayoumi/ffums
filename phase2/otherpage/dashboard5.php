<?php
include 'include/header.php';
include 'include/functions.php';
include 'include/db.php';

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
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Products</h4>
                <hr>
                <p class="card-text">
                    <?php echo $total_products; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Orders</h4>
                <hr>
                <p class="card-text">
                    <?php echo $total_orders; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Categories</h4>
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
                <h4 class="card-title">Nearby Orders</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Remaining Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $all_orders = getAllOrders();
                        while ($order = mysqli_fetch_assoc($all_orders)) {
                            $product_id = $order['product_id'];
                            $product = getProductById($product_id);
                            $order_date = new DateTime($order['order_date']);
                            $delivery_date = new DateTime($order['delivery_date']);
                            $remaining_days = $order_date->diff($delivery_date)->format("%a");
                            echo '<tr>';
                            echo '<td>' . $order['customer_name'] . '</td>';
                            echo '<td>' . $product['name'] . '</td>';
                            echo '<td>' . $order['quantity'] . '</td>';
                            echo '<td>' . $order['order_date'] . '</td>';
                            echo '<td>' . $order['delivery_date'] . '</td>';
                            echo '<td>';
                            echo '<div class="progress">';
                            if ($remaining_days >= 7) {
                                echo '<div class="progress-bar bg-success" role="progressbar" style="width: ' . ($remaining_days / 7) * 100 . '%" aria-valuenow="' . $remaining_days . '" aria-valuemin="0" aria-valuemax="7">' . $remaining_days . '</div>';
                            } elseif ($remaining_days >= 4) {
                                echo '<div class="progress-bar bg-warning" role="progressbar" style="width: ' . ($remaining_days / 7) * 100 . '%" aria-valuenow="' . $remaining_days . '" aria-valuemin="0" aria-valuemax="7">' . $remaining_days . '</div>';
                            } else {
                                echo '<div class="progress-bar bg-danger" role="progressbar" style="width: ' . ($remaining_days / 7) * 100 . '%" aria-valuenow="' . $remaining_days . '" aria-valuemin="0" aria-vala-label="' . $remaining_days . ' Days Remaining" aria-describedby="' . $task . '"></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';





                            
                            echo '</body>';
                            echo '</html>';
                        }





                        ?>


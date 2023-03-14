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
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total Products</h4>
                <hr>
                <p class="card-text">
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo $total_products; ?>%">
                        <?php echo $total_products; ?>
                    </div>
                </div>
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
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo $total_orders; ?>%">
                        <?php echo $total_orders; ?>
                    </div>
                </div>
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
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo $total_categories; ?>%">
                        <?php echo $total_categories; ?>
                    </div>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<div class"row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Orders Progress</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Product Name</th>
                        <th>Progress</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $remaining_days = $row['remaining_days'];
                            $product_name = $row['product_name'];
                            $delivery_date = $row['delivery_date'];
                            $order_date = $row['order_date'];
                            $width = ($remaining_days / 7) * 100;
                            if ($remaining_days >= 5) {
                                $color = 'success';
                            } elseif ($remaining_days >= 2) {
                                $color = 'warning';
                            } else {
                                $color = 'danger';
                            }
                            echo "<tr>
                    <td>$order_date</td>
                    <td>$delivery_date</td>
                    <td>$product_name</td>
                    <td>
                      <div class='progress'>
                        <div class='progress-bar bg-$color' role='progressbar' style='width: $width%' aria-valuenow='$width' aria-valuemin='0' aria-valuemax='100'></div>
                      </div>
                    </td>
                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
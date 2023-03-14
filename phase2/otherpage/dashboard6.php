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
            <div class="card-body text-center">
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
            <div class="card-body text-center">
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
            <div class="card-body text-center">
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
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                            <td>' . $row['customer_name'] . '</td>
                                            <td>' . $row['product_name'] . '</td>
                                            <td>' . $row['quantity'] . '</td>
                                            <td>' . $row['order_date'] . '</td>
                                            <td>' . $row['delivery_date'] . '</td>
                                            <td>' . $row['remaining_days'] . '</td>
                                        </tr>';
                            }
                        } else {
                            echo '<tr>
                                        <td colspan="6" class="text-center">No Nearby Orders Found</td>
                                    </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function setProgress(progress) {
        var circle = document.querySelector(".progress-bar");
        var radius = circle.r.baseVal.value;
        var circumference = radius * 2 * Math.PI;

        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        circle.style.strokeDashoffset = `${circumference * (1 - progress)}`;
    }

    setProgress(<?php echo ($remaining_days / 7) * 100; ?> / 100);
</script>
<?php include 'include/footer.php'; ?>
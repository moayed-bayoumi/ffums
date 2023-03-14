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

$query = "SELECT orders.*, products.name as product_name, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 20 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);

$due_orders = mysqli_num_rows($result);
?>
<style>
    .card {
        transition: all 0.2s ease-in-out;
    }

    .card:hover {
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }
</style>


<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h4 class="card-title">Total Products</h4>
                <hr>
                <p class="card-text">
                    <i class="fas fa-box-open fa-2x"></i>
                    <?php echo $total_products; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h4 class="card-title">Total Orders</h4>
                <hr>
                <p class="card-text">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                    <?php echo $total_orders; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h4 class="card-title">Total Categories</h4>
                <hr>
                <p class="card-text">
                    <i class="fas fa-list-alt fa-2x"></i>
                    <?php echo $total_categories; ?>
                </p>
            </div>
        </div>
    </div>

    <?php
    $query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 20 ORDER BY remaining_days ASC";
    $result = mysqli_query($conn, $query);
    $orders_due_in_20_days = mysqli_num_rows($result);
    echo $orders_due_in_20_days;
    ?>




    <div class="card mt-5">
        <div class="card-body">
            <h4 class="card-title">Orders Due in 20 Days</h4>
            <hr>
            <table id="orders-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Remaining Days</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['product_name']; ?></td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $row['remaining_days'] * 100 / 20; ?>%" aria-valuenow="<?php echo $row['remaining_days']; ?>" aria-valuemin="0" aria-valuemax="20"></div>
                                </div>
                                <span class="pl-2"><?php echo $row['remaining_days']; ?> Days</span>
                            </td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><img src="images/<?php echo $row['product_image']; ?>" alt="Product Image" width="50"></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('#orders-table').DataTable({
                "ordering": false
            });

            // Show loading icon while page is loading
            $(document).ajaxStart(function() {
                lockPage();
            });
            $(document).ajaxStop(function() {
                unlockPage();
            });
        });
    </script>





    <?php include 'include/footer.php'; ?>
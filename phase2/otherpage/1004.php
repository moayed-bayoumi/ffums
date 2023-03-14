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
<div class="card mt-5">
    <div class="card-body">
        <h4 class="card-title">Orders Due in 20 Days</h4>
        <hr>
        <table id="orders-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Remaining Days</th>
                    <th>Customer Name</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>
                            <div class="progress">
                                <?php
                                $remaining_days = $row['remaining_days'];
                                $progress = ($remaining_days / 20) * 100;
                                $color = 'bg-success';
                                if ($remaining_days <= 10) {
                                    $color = 'bg-warning';
                                }
                                if ($remaining_days <= 5) {
                                    $color = 'bg-danger';
                                }
                                ?>
                                <div class="progress-bar <?php echo $color; ?>" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $remaining_days; ?>" aria-valuemin="0" aria-valuemax="20"></div>
                            </div>
                            <span class="pl-2">
                                <?php echo $remaining_days; ?> Days
                            </span>
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
            "ordering": false,
            "columnDefs": [{
                "targets": 2,
                "render": function(data, type, row) {
                    var remaining_days = row[1];
                    var progress = (remaining_days / 20) * 100;
                    return '<div class="progress">' +
                        '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: ' + progress + '%" aria-valuenow="' + remaining_days + '" aria-valuemin="0" aria-valuemax="20"></div>' +
                        '</div>' +
                        '<span class="pl-2">' + remaining_days + ' Days</span>';
                }
            }]
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
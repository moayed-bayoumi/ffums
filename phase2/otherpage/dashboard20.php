<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 7 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
?>
<div class="container-fluid">
    <h1 class="text-center my-5">Upcoming Orders</h1>
    <table class="table table-striped">
        <thead class="thead-dark">
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Progress</th>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($result)) :
                $product = getProductById($order['product_id']);
                $order_date = new DateTime($order['order_date']);
                $delivery_date = new DateTime($order['delivery_date']);
                $remaining_days = $order_date->diff($delivery_date)->format("%a");
                $progress = ($remaining_days <= 7) ? 100 - ($remaining_days / 7) * 100 : 0;
            ?>
                <tr>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['delivery_date']; ?></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar <?php echo ($remaining_days <= 7) ? 'bg-danger' : 'bg-success'; ?>" style="width: <?php echo $progress; ?>%">
                                <?php echo $remaining_days; ?> days remaining
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('table').DataTable({
            "lengthMenu": [10, 25, 50, -1],
            "columnDefs": [{
                "orderable": false,
                "targets": [5]
            }]
        });
    });
</script>


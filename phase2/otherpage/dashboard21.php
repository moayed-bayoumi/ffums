<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
?>
<div class="container-fluid">
    <h1 class="text-center my-3">All Orders</h1>
    <table class="table table-striped">
        <thead>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Progress</th>
            <th>Image</th>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($result)) :
                $product = getProductById($order['product_id']);
                $order_date = new DateTime($order['order_date']);
                $delivery_date = new DateTime($order['delivery_date']);
                $remaining_days = $order_date->diff($delivery_date)->format("%a");
            ?>
                <tr>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><img src="images/<?php echo $product['image']; ?>" width="50" height="50"></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['delivery_date']; ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if ($remaining_days <= 7) : ?>
                                <i class="fas fa-thermometer-three-quarters text-danger fa-2x mr-3"></i>
                                <div class="text-danger">
                                    <?php echo $remaining_days; ?> days remaining
                                </div>
                            <?php elseif ($remaining_days <= 14) : ?>
                                <i class="fas fa-thermometer-half text-warning fa-2x mr-3"></i>
                                <div class="text-warning">
                                    <?php echo $remaining_days; ?> days remaining
                                </div>
                            <?php else : ?>
                                <i class="fas fa-thermometer-quarter text-success fa-2x mr-3"></i>
                                <div class="text-success">
                                    <?php echo $remaining_days; ?> days remaining
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>


                    <td>
                        <a href="#" onclick="window.open('images/<?php echo $product['image']; ?>', '_blank', 'width=500,height=500'); return false;">
                            <img src="images/<?php echo $product['image']; ?>" width="50" height="50">
                        </a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
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
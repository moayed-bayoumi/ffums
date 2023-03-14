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
                $today = new DateTime();
                $today = $today->format("Y-m-d");
                $total_days = $order_date->diff($delivery_date)->format("%a");
                $days_passed = $total_days - $remaining_days;
                $percentage = ($days_passed / $total_days) * 100;

            ?>
                <tr class="order-row" id="order-<?php echo $order['id']; ?>">
                    <td><?php echo $order['customer_name']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td>
                        <img src="images/<?php echo $product['image']; ?>" width="50" height="50">
                    </td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['delivery_date']; ?></td>
                    <td>
                        <?php
                        $today = new DateTime();
                        $delivery_date = new DateTime($order['delivery_date']);
                        $interval = $today->diff($delivery_date);
                        $remaining_days = $interval->days;
                        $percent = ($remaining_days / 14) * 100;
                        ?>


                        <div class="progress">
                            <?php if ($percent >= 0 && $percent <= 50) : ?>
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $percent . '%'; ?>
                                </div>
                            <?php elseif ($percent > 50 && $percent <= 75) : ?>
                                <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $percent . '%'; ?>
                                </div>
                            <?php else : ?>
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $percent . '%'; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($remaining_days < 0) : ?>
                            <div class="text-danger">Delayed</div>
                        <?php else : ?>
                            <div class="text-success">On Time</div>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="#" class="view-image" data-toggle="modal" data-target="#productImageModal" data-image="images/<?php echo $product['image']; ?>">
                            <i class="fas fa-eye fa-2x text-primary"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

</div>
<!-- Product Image Modal -->
<div class="modal fade" id="productImageModal" tabindex="-1" role="dialog" aria-labelledby="productImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productImageModalLabel">Product Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" class="img-fluid" id="productImage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('table').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "order": [
                [5, "asc"]
            ]
        });

        $('.view-image').click(function() {
            var imageSrc = $(this).data('image');
            $('#productImage').attr('src', imageSrc);
        });
    });
</script>
<?php
include 'include/footer.php';
?>


add animation progress bar to be dynamic Calculate the days based on the remaining days till Delivery Date .
<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, products.image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 7 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);

?>
<style>
    /* Style the container */
    .order-container {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background: #e9ecef;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    /* Style the product image */
    .product-img {
        width: 100px;
        height: 100px;
        margin-right: 20px;
    }

    /* Style the customer name */
    .customer-name {
        font-size: 18px;
        font-weight: bold;
    }

    /* Style the product name */
    .product-name {
        font-size: 16px;
        margin-bottom: 20px;
    }

    /* Style the order date */
    .order-date {
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Style the delivery date */
    .delivery-date {
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Style the remaining days */
    .remaining-days {
        background: #0f9d58;
        color: #fff;
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
    }
</style>






<div class="nearby-orders">
    <!-- Loop through the orders -->
    <?php while ($order = mysqli_fetch_assoc($result)) { ?>
        <!-- Create the order container -->
        <div class="order-container">
            <!-- Display the product image -->
            <img src="images/<?php echo $order['image']; ?>" class="product-img">
            <!-- Display the customer name -->
            <div class="customer-name"><?php echo $order['customer_name']; ?></div>
            <!-- Display the product name -->
            <div class="product-name">Product Name: <?php echo $order['product_name']; ?></div>
            <!-- Display the order date -->
            <div class="order-date">Order Date: <?php echo $order['order_date']; ?></div>
            <!-- Display the delivery date -->
            <div class="delivery-date">Delivery Date: <?php echo $order['delivery_date']; ?></div>
            <!-- Display the remaining days -->
            <div class="remaining-days">Remaining Days: <?php echo $order['remaining_days']; ?></div>
        </div>
    <?php } ?>
</div>



<script>

    // 
    $(document).ready(function() {
        $('#order-table').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [5]
            }]
        });
    });
</script>
</body>

</html>
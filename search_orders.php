<?php
include 'include/functions.php';

$conn = connectDB();
$searchTerm = $_POST['search_term'];

$query = "SELECT orders.*, products.name as product_name, products.image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE products.name LIKE '%$searchTerm%' ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);

while ($order = mysqli_fetch_assoc($result)) { ?>
    <div class="order">
        <!-- Your order information display code here -->
    </div>
<?php } ?>

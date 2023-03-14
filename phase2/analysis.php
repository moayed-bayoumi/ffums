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



$query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 20 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
$orders_due_in_20_days = mysqli_num_rows($result);



// Retrieve the data for each month
$query = "SELECT MONTH(order_date) as month, COUNT(*) as total_orders FROM orders GROUP BY MONTH(order_date)";
$result = mysqli_query($conn, $query);

$months = [];
$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $orders[] = $row['total_orders'];
}

?>

<link rel="stylesheet" href="include/assets/dashboard.css" type="text/css">
<!DOCTYPE html>
<html>

<head>
    <title>Total Orders by Month</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <canvas id="ordersChart"></canvas>
    <script>
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersData = {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Total Orders',
                data: <?php echo json_encode($orders); ?>,
                backgroundColor: 'rgba(63, 191, 127, 0.8)',
                borderColor: 'rgba(63, 191, 127, 1)',
                borderWidth: 2
            }]
        };
        var ordersChart = new Chart(ctx, {
            type: 'bar',
            data: ordersData,
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Total Orders by Month'
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>
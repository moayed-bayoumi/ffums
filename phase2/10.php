<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

// Get number of orders by shipping status
$shippedCount = count(getOrdersByShippingStatus('shipped'));
$pendingCount = count(getOrdersByShippingStatus('pending'));
$cancelledCount = count(getOrdersByShippingStatus('cancelled'));
// Get the total revenue
$total_revenue = getTotalRevenue();

// Get the recent orders
$recent_orders = getRecentOrders();
?>

<div class="container my-4">
    <h1 class="fw-bold mb-4">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Shipped Orders</h5>
                    <p class="card-text"><?= $shippedCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Pending Orders</h5>
                    <p class="card-text"><?= $pendingCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Cancelled Orders</h5>
                    <p class="card-text"><?= $cancelledCount ?></p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="fw-bold mb-4">Recent Orders</h2>




    <div class="col-lg-4">
        <div class="card bg-success text-light">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text display-4">$<?= number_format($total_revenue, 2) ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card bg-warning text-light">
            <div class="card-body">
                <h5 class="card-title">Recent Orders</h5>
                <ul class="list-group">
                    <?php foreach ($recent_orders as $order) : ?>
                        <li class="list-group-item">
                            Order #<?= $order['id'] ?>
                            <span class="badge bg-primary rounded-pill float-end">$<?= number_format($order['total_price'], 2) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <?php
    include 'include/footer.php';
    ?>
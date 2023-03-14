<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

$orders = getAllOrders();

?>
<div class="container">
    <h1>Order List</h1>
    <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>الموقع</th>
                <th>Product</th>
                <th>صورة المنتج</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Shipping Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['customer_name'] ?></td>
                    <td>
                        <?php 
                            $product = getProductById($order['product_id']);
                            echo $product['name'];
                        ?>
                    </td>
                    <td>
                        <?php 
                            if(!empty($product['image'])) {
                                echo '<img src="images/'.$product['image'].'" width="50">';
                            } else {
                                echo 'No image';
                            }
                        ?>
                    </td>
                    <td><?= $order['quantity'] ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td><?= $order['shipping_status_id'] ?></td>
                    <td>
                        <a href="edit-order.php?id=<?= $order['id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="delete-order.php?id=<?= $order['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

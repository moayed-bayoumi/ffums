<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

$project_id = $_GET['id'];
$project = getProjectById($project_id);
$orders = getAllOrdersByProject($project_id);
?>

<div class="container">
    <h1>Orders for <?= $project['name'] ?></h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Client</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Shipping Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $order['customer_name'] ?></td>
                    <td><?= getProductById($order['product_id'])['name'] ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td><?= $order['delivery_date'] ?></td>
                    <td><?= ucfirst($order['shipping_status_id']) ?></td>
                    <td>
                        <a href="edit-order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete-order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="project-list.php" class="btn btn-secondary">Back to Project List</a>
</div>

<?php
include 'include/footer.php';
?>
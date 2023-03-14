<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

if (isset($_POST['submit'])) {
    $client = $_POST['client'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $date = date('Y-m-d');
    $delivery_date = $_POST['delivery_date'];
    $shipping_status_id = $_POST['shipping_status_id'];
    $project_id = $_POST['project_id'];

    $result = addOrder($client, $product_id, $quantity, $date, $delivery_date, $shipping_status_id, $project_id);

    if ($result) {
        $_SESSION['message'] = "Order added successfully";
        header('location: order-list.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to add order";
    }
}
?>
<div class="container">
    <h1>New Order</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="client">Client</label>
            <input type="text" class="form-control" id="client" name="client" required>
        </div>
        <div class="form-group">
            <label for="product_id">Product</label>
            <div class="row">
                <?php foreach (getAllProducts() as $product) : ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img src="images/<?= $product['image'] ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <input type="radio" id="product_id" name="product_id" value="<?= $product['id'] ?>" required>
                                <label for="product_id">Select</label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="delivery_date">Delivery Date</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
        </div>
        <div class="form-group">
            <label for="shipping_status_id">Shipping Status</label>
            <select class="form-control" id="shipping_status_id" name="shipping_status_id" required>
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>
        <div class="form-group">
            <label for="project_id">Project</label>
            <select class="form-control" id="project_id" name="project_id">
                <?php foreach (getAllProjects() as $project) : ?>
                    <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="submit" value="Add Order" name="submit" class="btn btn-primary">
        <a href="order-list.php" class="btn btn-secondary">Back to Order List</a>
    </form </div>
    <?php
    include 'include/footer.php';
    ?>
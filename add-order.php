<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

// Get all products for dropdown
$products = getAllProducts();

// Get all projects for dropdown
$projects = getAllProjects();

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $customer_name = $_POST['customer_name'];
    $project_id = $_POST['project_id'];
    $order_date = $_POST['order_date'];
    $delivery_date = $_POST['delivery_date'];
    $shipping_status_id = $_POST['shipping_status_id'];

    // Loop through each product and add to the database if selected
    foreach ($products as $product) {
        // Check if the product is selected
        if (in_array($product['id'], $_POST['product_id'])) {
            $quantity = $_POST['quantity'][$product['id']];
            addOrder($customer_name, $project_id, $product['id'], $quantity, $order_date, $delivery_date, $shipping_status_id);
        }
    }

    // Redirect to project-orders.php for the selected project
    header('Location: project-orders.php?id=' . $project_id);
    exit;
}
?>
<div class="container my-4">
    <h1 class="fw-bold">Add Order</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select class="form-select" id="project_id" name="project_id" required>
                <option disabled selected>Select a project</option>
                <?php foreach ($projects as $project) : ?>
                    <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="order_date" class="form-label">Order Date</label>
            <input type="date" class="form-control" id="order_date" name="order_date" required>
        </div>
        <div class="mb-3">
            <label for="delivery_date" class="form-label">Delivery Date</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
        </div>
        <div class="mb-3">
            <label for="shipping_status_id" class="form-label">Shipping Status</label>
            <select class="form-select" id="shipping_status_id" name="shipping_status_id" required>
                <option disabled selected>Select a status</option>
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>
        <hr>
        <h2 class="fw-bold mb-3">Order Details</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Image</th </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?= $product['name'] ?></td>
                            <td>
                                <input type="number" class="form-control" name="quantity[<?= $product['id'] ?>]" min="1">
                            </td>
                            <td><img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="img-thumbnail" width="100"></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="product_id[]" value="<?= $product['id'] ?>" id="product_<?= $product['id'] ?>">
                                    <label class="form-check-label" for="product_<?= $product['id'] ?>">
                                        Add to Order
                                    </label>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end my-4">
            <button type="submit" class="btn btn-primary mx-2" name="submit">
                <i class="fas fa-save me-2"></i>Save Order
            </button>

            <a href="project-list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php include 'include/footer.php'; ?>
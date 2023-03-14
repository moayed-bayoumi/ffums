<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

$project_id = $_GET['id'];
$project = getProjectById($project_id);
$orders = getAllOrdersByProject($project_id);

function format_date($date)
{
  return date('Y-m-d', strtotime($date));
}

?>

<div class="container">
  <h1>Orders for <?= $project['name'] ?></h1>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Customer Name</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Order Date & Delivery Date</th>
        <th>Remaining Days Until Delivery</th>
        <th>Order Image</th>
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
          <td><?= $order['order_date'] .  ' - ' . $order['delivery_date'] ?></td>
          <td>
            <?php
            $remaining_days_until_delivery = ceil((strtotime($order['delivery_date']) - time()) / 86400);
            if ($remaining_days_until_delivery <= 0) {
              echo '<span class="text-danger">Expired</span>';
            } else if ($remaining_days_until_delivery <= 7) {
              echo '<span class="text-warning">' . $remaining_days_until_delivery . ' days</span>';
              // Send notification here
            } else {
              echo $remaining_days_until_delivery . ' days';
            }
            ?>
          </td>
          <td>
            <?php
            $product = getProductById($order['product_id']);
            if (!empty($product['image'])) {
              echo '<a href="images/' . $product['image'] . '" target="_blank"><img src="images/' . $product['image'] . '" width="50"></a>';
            } else {
              echo 'No image';
            }
            ?>
          </td>
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
<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Order Dashboard</title>
</head>

<body>
    <div class="container-fluid">
        <h1 class="text-center my-3">Expected Deliveries at Site</h1>
        <table class="table table-striped">
            <thead>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Progress</th>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($result)) :
                    $product = getProductById($order['product_id']);
                    $order_date = new DateTime($order['order_date']);
                    $delivery_date = new DateTime($order['delivery_date']);
                    $remaining_days = $order_date->diff($delivery_date)->format("%a");
                ?>
                    <tr>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#productImageModal" onclick="showImage('<?php echo $product['image']; ?>')">
                                <img src="images/<?php echo $product['image']; ?>" width="50" height="50" class="img-thumbnail">
                            </a>
                        </td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td><?php echo $order['delivery_date']; ?></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo ($remaining_days <= 7) ? 'bg-danger' : (($remaining_days <= 14) ? 'bg-warning' : ''); ?>" style="width: <?php echo 100 - ($remaining_days / ($remaining_days <= 7 ? 7 : 14)) * 100; ?>%">
                                    <?php echo $remaining_days; ?> days remaining
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="productImageModal" tabindex="-1" role="dialog" aria-labelledby="productImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productImageModalLabel">Product Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="productImage" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <script>
        function showImage(image) {
            $('#productImage').attr('src ', image);
            $('#productImageModal').modal('show');
        }
    </script>
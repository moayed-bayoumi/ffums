<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

if (!isset($_GET['id'])) {
    header('Location: product-list.php');
    exit;
}

$product = getProductById($_GET['id']);

if (!$product) {
    header('Location: product-list.php');
    exit;
}

?>
<div class="container">
    <h1>Product Detail</h1>
    <div class="card" style="width: 18rem;">
        <img src="images/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
        <div class="card-body">
            <h5 class="card-title"><?= $product['name'] ?></h5>
            <p class="card-text"><?= $product['description'] ?></p>
            <table class="table">
                <tr>
                    <th>Price:</th>
                    <td><?= $product['price'] ?></td>
                </tr>
                <tr>
                    <th>Code:</th>
                    <td><?= $product['code'] ?></td>
                </tr>
                <tr>
                    <th>Type:</th>
                    <td><?= $product['type'] ?></td>
                </tr>
                <tr>
                    <th>Wood Type:</th>
                    <td><?= $product['wood_type'] ?></td>
                </tr>
                <tr>
                    <th>Paint Type:</th>
                    <td><?= $product['paint_type'] ?></td>
                </tr>
                <tr>
                    <th>Wood Color:</th>
                    <td><?= $product['wood_color'] ?></td>
                </tr>
                <tr>
                    <th>Accessories:</th>
                    <td><?= $product['accessories'] ?></td>
                </tr>
            </table>
            <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn btn-warning">Edit</a>
            <a href="product-delete.php?id=<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
        </div>
    </div>
    <a href="product-list.php" class="btn btn-primary">Back to Product List</a>
</div>
<?php
include 'include/footer.php';
?>
<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-bold">Product List</h1>
        <div>
            <a href="add-product.php" class="btn btn-primary mx-2"><i class="fas fa-plus me-2"></i>Add Product</a>
            <a href="add-order.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Order</a>
        </div>
    </div>

    <?php
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) :
    ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= $product['name'] ?></td>
                            <td><?= $product['description'] ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="img-thumbnail" width="100"></td>
                            <td>
                                <div class="btn-group">
                                    <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Edit</a>
                                    <a href="product-delete.php?id=<?= $product['id'] ?>" class="btn btn-danger"><i class="fas fa-trash-alt me-2"></i>Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No products found.</p>
    <?php endif; ?>

</div>

<?php
include 'include/footer.php';
?>
<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $wood_type = $_POST['wood_type'];
    $paint_type = $_POST['paint_type'];
    $wood_color = $_POST['wood_color'];
    $accessories = $_POST['accessories'];
    
    // Image upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "upload/$image");
    
    addProduct($name, $description, $price, $image, $code, $type, $wood_type, $paint_type, $wood_color, $accessories);
    header('Location: index.php');
}
?>

<div class="container">
    <h1>Add New Product</h1>
    <form action="product-add.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        <div class="form-group">
            <label for="wood_type">Wood Type</label>
            <input type="text" class="form-control" id="wood_type" name="wood_type" required>
        </div>
        <div class="form-group">
            <label for="paint_type">Paint Type</label>
            <input type="text" class="form-control" id="paint_type" name="paint_type" required>
</div>
<div class="form-group">
<label for="wood_color">Wood Color</label>
<input type="text" class="form-control" id="wood_color" name="wood_color" required>
</div>
<div class="form-group">
<label for="accessories">Accessories</label>
<input type="text" class="form-control" id="accessories" name="accessories" required>
</div>
<input type="submit" class="btn btn-primary" name="submit" value="Add Product">
</form>

</div>
<?php
include 'include/footer.php';
?>

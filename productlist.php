<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

// Get list of categories for dropdown
$categories = getAllCategories();

if (isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    $category = '';
}

?>
<div class="container">
    <h1>Product List</h1>
    <form>
        <label for="category">Filter by category:</label>
        <select name="category" id="category">
            <option value="">All</option>
            <?php while ($row = mysqli_fetch_assoc($categories)): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $category) ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Filter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Code</th>
                <th>Type</th>
                <th>Wood Type</th>
                <th>Paint Type</th>
                <th>Wood Color</th>
                <th>Accessories</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $products = getAllProducts($category);
            while ($row = mysqli_fetch_assoc($products)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td> <img src='images/".$row['image']."' width='50' height='50'></td>";
                echo "<td>" . $row['code'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "<td>" . $row['wood_type'] . "</td>";
                echo "<td>" . $row['paint_type'] . "</td>";
                echo "<td>" . $row['wood_color'] . "</td>";
                echo "<td>" . $row['accessories'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>
                <a href='edit-product.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                <a href='delete-product.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                <a href='view-product.php?id=" . $row['id'] . "' class='btn btn-success'>View</a>
                <a href='new-order.php?id=" . $row['id'] . "' class='btn btn-success'>New Order</a>
                </td>";
                echo "</tr>";
                }
                ?>
                </tbody>
                </table>
                <a href="add-product.php" class="btn btn-primary">Add New Product</a>
                
                </div>
                <?php
                include 'include/footer.php';
                ?>
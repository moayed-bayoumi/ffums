<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Validate inputs
    $errors = array();

    if(empty($_POST['name']) || strlen(trim($_POST['name']))<3){
        $errors[]="Name is required and should be minimum 3 characters!";
    }

    // Sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $id = $_POST['id'];

    // Update the project details in the database
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE projects SET name=?, description=?, image=? WHERE id=?");
    if ($stmt) {
        $image_url = uploadImage($_FILES['image'], 'uploads/');
        $stmt->bind_param("sssi", $name, $description, $image_url, $id);
        $stmt->execute();
        $_SESSION['message'] = "Project updated successfully";
        header('location: project-list.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to update project";
    }
}

// Get the project ID from the URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the project details from the database
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $project = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "Failed to retrieve project details";
    }
} else {
    $_SESSION['error'] = "Project ID not specified";
    header('location: project-list.php');
    exit();
}
?>

<div class="container">
    <h1>Edit Project</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $project['id'] ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= $project['name'] ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= $project['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <div class="form-group">
            <img src="<?= $project['image'] ?>" width="100">
        </div>
        <input type="submit" value="Update Project" name="submit" class="btn btn-primary">
        <a href="project-list.php" class="btn btn-secondary">Back to Project List</a>
    </form>
</div>

<?php
include 'include/footer.php';
?>

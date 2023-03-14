<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

if (isset($_POST['submit'])) {
    //Validate Inputs
    $errors = array();

    if(empty($_POST['name']) || strlen(trim($_POST['name']))<3){
        $errors[]="Name is required and should be minimum 3 characters!";
    }

    if(count($errors) === 0){
        // Sanitize inputs
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $note = htmlspecialchars($_POST['note']);

        if (!empty($image)) {
            $image_url = uploadImage($_FILES['image'], 'uploads/');

        } else {
            $image_url = '';
        }

        // Create prepared statement and execute
        $stmt = $conn->prepare("INSERT INTO projects (name, description, image, note) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $description, $image_url, $note);
            $stmt->execute();
            $stmt->close();
            $_SESSION['message'] = "Project added successfully";
            header('location: project-list.php');
            exit();
        } else {
            $_SESSION['error'] = "Failed to add project";
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}
?>
<div class="container">
    <h1>New Project</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="note">Note</label>
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
        </div>
        <input type="submit" value="Add Project" name="submit" class="btn btn-primary">
        <a href="project-list.php" class="btn btn-secondary">Back to Project List</a>
    </form>
</div>
<?php
include 'include/footer.php';
?>

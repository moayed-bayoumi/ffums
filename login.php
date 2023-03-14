<?php
session_start();
require_once 'include/functions.php';
require_once 'include/header.php';


// check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// check if form is submitted
if (isset($_POST['submit'])) {
    $conn = connectDB();

    // get values from form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // check if username and password match
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- include css and javascript here -->
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) { ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
<?php } ?>

<form action="" method="post">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Login" class="btn btn-primary">
    </div>
</form>
</body>
</html>
<?php

function addProduct($name, $description, $price, $image, $code, $type, $wood_type, $paint_type, $wood_color, $accessories)
{
    global $conn;

    $sql = "INSERT INTO products (name, description, price, image, code, type, wood_type, paint_type, wood_color, accessories)
            VALUES ('$name', '$description', '$price', '$image', '$code', '$type', '$wood_type', '$paint_type', '$wood_color', '$accessories')";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function getAllProducts()
{
    global $conn;
    $query = "SELECT id, name, description, price, image, code, type, wood_type, paint_type, wood_color, accessories, category FROM products";
    $result = mysqli_query($conn, $query);
    return $result;
}


function getAllCategories()
{
    global $conn;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    return $result;
}


function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}




function displayMessage()
{
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}


function getAllOrders()
{
    global $conn;
    $query = "SELECT * FROM orders";
    $result = mysqli_query($conn, $query);
    return $result;
}




function connectDB()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mffus2";
    $conn = mysqli_connect($host, $username, $password, $dbname);
    return $conn;
}




function getOrdersByDeliveryDate($date, $limit)
{
    $conn = mysqli_connect("localhost", "root", "", "mffus2");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM orders WHERE delivery_date = ? LIMIT ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $date, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getCount($date)
{
    $conn = mysqli_connect("localhost", "root", "", "mffus2");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT COUNT(*) as total FROM orders WHERE delivery_date = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result)['total'];
}


function getShippingStatusName($shipping_status_id)
{
    global $conn;
    $query = "SELECT name FROM shipping_status WHERE id = '$shipping_status_id'";
    $result = mysqli_query($conn, $query);
    $shipping_status = mysqli_fetch_assoc($result);
    return $shipping_status['name'];
}


function getRemainingDays($delivery_date)
{
    $current_date = time();
    $delivery_date = strtotime($delivery_date);
    $difference = $delivery_date - $current_date;
    return floor($difference / (60 * 60 * 24));
}



// order
function getOrders()
{
    // Connect to database and retrieve order data
    $conn = mysqli_connect("localhost", "root", "", "mffus2");
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($conn, $sql);

    // Loop through the results and create a table row for each order
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['customer_name'] . "</td>";
        echo "<td>" . $row['order_date'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "</tr>";
    }

    // Close the database connection
    mysqli_close($conn);
}


// project 


function getAllProjects()
{
    global $conn;
    $sql = "SELECT * FROM projects";
    $result = mysqli_query($conn, $sql);
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    foreach ($projects as &$project) {
        $project['process'] = getProjectProcess($project['id']); // Fetch process data for each project
    }
    return $projects;
}

function getProjectProcess($project_id)
{
    global $conn;
    $sql = "SELECT * FROM project_process WHERE project_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $process = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $process;
}


// 
function addOrder($customer_name, $project_id, $product_id, $quantity, $order_date, $delivery_date, $shipping_status_id)
{
    // Connect to the database
    $mysql = connectDB();

    // Prepare the insert statement
    $stmt = mysqli_prepare($mysql, "INSERT INTO orders (customer_name, project_id, product_id, quantity, order_date, delivery_date, shipping_status_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the statement
    mysqli_stmt_bind_param($stmt, "siiissi", $customer_name, $project_id, $product_id, $quantity, $order_date, $delivery_date, $shipping_status_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the ID of the last inserted order
    $order_id = mysqli_insert_id($mysql);

    // Get the ID of the selected product
    $product_id = intval($product_id);

    // Get the price of the selected product
    $result = mysqli_query($mysql, "SELECT id, price FROM products WHERE id = $product_id");
    $row = mysqli_fetch_assoc($result);
    $price = (float) $row['price'];

    // Calculate the total price of the order
    $total_price = (float) $quantity * $price;

    // Insert the order details into the order_details table
    mysqli_query($mysql, "INSERT INTO order_details (order_id, product_id, quantity, price, total_price) VALUES ($order_id, $product_id, $quantity, $price, $total_price)");

    // Close the database connection
    mysqli_close($mysql);
}

// 

function getProjectById($id)
{
    global $conn;

    $sql = "SELECT * FROM projects WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}


function getOrdersByProject($project_id)
{
    global $conn;
    $query = "SELECT orders.*, products.name AS product_name FROM orders 
              JOIN products ON orders.product_id = products.id 
              WHERE orders.project_id = $project_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


// 
// 
function getProjectDeliveryDate($project_id)
{
    global $conn;
    $sql = "SELECT MIN(delivery_date) AS delivery_date FROM orders WHERE project_id = $project_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['delivery_date'];
}

function getProjectProgress($project_id)
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total, SUM(IF(shipping_status_id IS NOT NULL, 1, 0)) AS shipped FROM orders WHERE project_id = $project_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
    $shipped = $row['shipped'];
    if ($total == 0) {
        return 0;
    } else {
        return round(($shipped / $total) * 100);
    }
}


// 

/**
 * Retrieve all orders for a given project.
 *
 * @param int $projectId The ID of the project to retrieve orders for.
 * @return array An array of orders for the specified project.
 */
function getAllOrdersByProject($projectId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE project_id = ?");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}


// 
function calculateProjectProgress($project_id)
{
    $total_orders = count(getAllOrdersByProject($project_id));
    $shipped_orders = count(getAllOrdersByProjectAndStatus($project_id, 'shipped'));
    $delivered_orders = count(getAllOrdersByProjectAndStatus($project_id, 'delivered'));

    if ($total_orders == 0) {
        return 0;
    } else if ($delivered_orders == $total_orders) {
        return 100;
    } else {
        $progress = (($shipped_orders + $delivered_orders) / $total_orders) * 100;
        return round($progress, 2);
    }
}
function getAllOrdersByProjectAndStatus($project_id, $status)
{
    global $db;

    $sql = "SELECT * FROM orders WHERE project_id = :project_id AND shipping_status_id = :status";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//   
function getOrdersByShippingStatus($status)
{
    global $conn;
    $sql = "SELECT orders.*, customers.name AS customer_name FROM orders
            JOIN customers ON orders.customer_id = customers.id
            WHERE orders.shipping_status = '$status'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        error_log("Error in query: $sql. " . mysqli_error($conn));
        return false;
    }
    if ($result !== false) {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 0) {
            return [];
        }
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $orders;
    } else {
        return false;
    }
}


// 
function getTotalRevenue()
{
    global $conn;
    $revenue = 0;

    // Check if the table and column exist
    $table_name = "orders";
    $column_name = "order_total";
    $query = "SELECT COUNT(*) FROM information_schema.columns WHERE table_name = '$table_name' AND column_name = '$column_name'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_row($result)[0];

    if ($count > 0) {
        // Get total revenue
        $query = "SELECT SUM(order_total) AS total_revenue FROM orders";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $revenue = mysqli_fetch_assoc($result)['total_revenue'];
        }
    }

    return $revenue;
}



function getRecentOrders($limit = 10)
{
    global $conn;

    $query = "SELECT * FROM orders ORDER BY order_date DESC LIMIT $limit";
    $result = mysqli_query($conn, $query);

    $orders = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    return $orders;
}


function uploadImage($file, $destination)
{
    $target_dir = $destination;
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        // File is an image - proceed with upload
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    } else {
        // File is not an image
        return false;
    }
}

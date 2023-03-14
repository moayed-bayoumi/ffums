<?php
include 'include/db.php';
include 'include/functions.php';

// Get all orders that are scheduled for delivery in 3 days
$orders = getOrdersByDeliveryDate(date('Y-m-d', strtotime('+3 days')));

// Loop through each order and send an email notification to the project manager
foreach ($orders as $order) {
    $project = getProjectById($order['project_id']);
    $to = $project['manager_email'];
    $subject = 'Order Reminder: ' . getProductById($order['product_id'])['name'];
    $message = 'Dear ' . $project['manager_name'] . ',<br><br>';
    $message .= 'This is a friendly reminder that the following order is scheduled to be delivered in 3 days:<br><br>';
    $message .= '- Order ID: ' . $order['id'] . '<br>';
    $message .= '- Product Name: ' . getProductById($order['product_id'])['name'] . '<br>';
    $message .= '- Quantity: ' . $order['quantity'] . '<br>';
    $message .= '- Delivery Date: ' . $order['delivery_date'] . '<br><br>';
    $message .= 'Please make sure that the necessary preparations have been made for the delivery of this order.<br><br>';
    $message .= 'Best regards,<br>Order Management System';
    $headers = 'From: Order Management System <noreply@oms.com>' . "\r\n";
    $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";

    // Send the email
    mail($to, $subject, $message, $headers);
}

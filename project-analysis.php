<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

$projects = getAllProjects();

?>

<div class="container">
    <h1>Project Analysis</h1>


    <?php foreach ($projects as $project) : ?>
        <h2><?= $project['name'] ?></h2>
        <?php
        $orders = getAllOrdersByProject($project['id']);
        $total_orders = count($orders);
        $completed_orders = 0;
        $progress = 0;

        foreach ($orders as $order) {
            if ($order['shipping_status_id'] == 'delivered' && $order['delivery_date'] <= date('Y-m-d')) {
                $completed_orders++;
            }
        }

        if ($total_orders > 0) {
            $progress = round(($completed_orders / $total_orders) * 100);
        }
        
        ?>

        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"><?= $progress ?>%</div>
        </div>
        <p><?= $completed_orders ?> of <?= $total_orders ?> orders completed</p>
    <?php endforeach; ?>
</div>

<?php include 'include/footer.php'; ?>

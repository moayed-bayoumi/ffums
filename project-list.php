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
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $project['image'] ?>" alt="<?= $project['name'] ?>" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title"><?= $project['name'] ?></h2>
                        <p class="card-text"><?= $project['note'] ?></p>
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
                        <a href="project-orders.php?id=<?= $project['id'] ?>" class="btn btn-primary">View Orders</a>
                        <a href="edit-project.php?id=<?= $project['id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="#" class="btn btn-success">Tasks List</a>
                        <a href="#" class="btn btn-info">Add Team Member</a>
                        <a href="#" class="btn btn-warning">Brainstorming</a>
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'include/footer.php'; ?>
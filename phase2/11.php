<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

$projects = getAllProjects();

?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($projects as $project) : ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= $project['image'] ?>" class="card-img-top" alt="<?= $project['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $project['name'] ?></h5>
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
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"><?= $progress ?>%</div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="project-orders.php?id=<?= $project['id'] ?>" class="btn btn-outline-primary">View Orders</a>
                            <a href="edit-project.php?id=<?= $project['id'] ?>" class="btn btn-outline-secondary">Edit</a>
                            <a href="#" class="btn btn-outline-secondary">Tasks List</a>
                            <a href="#" class="btn btn-outline-secondary">Add Team Member</a>
                            <a href="#" class="btn btn-outline-secondary">Brainstorming</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'include/footer.php'; ?>
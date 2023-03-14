<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';
include 'include/navbar.php';

$projects = getAllProjects();

?>

<div class="container">
    <h1>Dashboard</h1>

    <div class="row">
        <div class="col-md-12">
            <h2>Projects</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Completion</th>
                        <th>View Orders</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project) : ?>
                        <?php
                        $orders = getAllOrdersByProject($project['id']);
                        $total_orders = count($orders);
                        $completed_orders = 0;
                        foreach ($orders as $order) {
                            if ($order['shipping_status_id'] == 3) {
                                $completed_orders++;
                            }
                        }
                        $completion_percentage = ($total_orders == 0) ? 0 : round(($completed_orders / $total_orders) * 100);
                        ?>
                        <tr>
                            <td><?= $project['name'] ?></td>
                            <td><?= $project['description'] ?></td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $completion_percentage ?>%" aria-valuenow="<?= $completion_percentage ?>" aria-valuemin="0" aria-valuemax="100"><?= $completion_percentage ?>%</div>
                                </div>
                            </td>
                            <td>
                                <a href="view-orders.php?project_id=<?= $project['id'] ?>" class="btn btn-primary">View Orders</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include 'include/footer.php';
?>

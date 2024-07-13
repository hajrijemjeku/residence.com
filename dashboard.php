<?php include('includes/header.php'); ?>


<section class="dashboard py-5">
    <div class="container">
        <?php if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): ?>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a class="text-decoration-none fs-5 link-secondary" href="manageUsers.php">Manage Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a  class="text-decoration-none fs-5 link-secondary" href="manageResidences.php">Manage Residences</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>







<?php include('includes/footer.php'); ?>
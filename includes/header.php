<?php
session_start();
ob_start();
// session_destroy();
include 'db.php';
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
$base_url = 'http://localhost/php/yv/newProjectPHP/';

//addlimit = 3 per reviews tek index.php;
if (basename($_SERVER['SCRIPT_FILENAME']) !== "index.php") {
    $_SESSION['addlimit'] = 3;
}
// echo (basename($_SERVER['SCRIPT_FILENAME'])); //kthen emrin e file (pjesen e fundit dmth te url) ku e kemi shenu kodin
?>

<?php


if(isset($_GET['action']) && $_GET['action'] == 'logout'){

    session_unset();
    session_destroy();
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    unset($_SESSION['isadmin']);

    header('Location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>residence.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/testimonials/testimonial-3/assets/css/testimonial-3.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.min.js"></script> -->
    <script src="https://inorganik.github.io/countUp.js/dist/countUp.umd.js"></script>

</head>
<body style="overflow-x:hidden;">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary ">
            <div class="container">
                <a class="navbar-brand" href="#">residence.com</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse  d-flex justify-content-end" id="navbarNav">
                    <ul class="navbar-nav w-50 justify-content-evenly">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?=$base_url?>index.php">Ballina</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$base_url?>residences.php">Residenca</a>
                        </li>
                        
                        <?php if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in']=== true)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$base_url?>offerResidence.php">Ofro Residence</a>
                        </li>   
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $_SESSION['email'] ?></a>
                            <ul class="dropdown-menu">
                                <?php if(isset($_SESSION['isadmin']) && ($_SESSION['isadmin'] == 1)): ?>
                                
                                <!-- <li><a class="dropdown-item" href="users.php">Users</a></li>
                                <li><a class="dropdown-item" href="manageresidences.php">Residences</a></li> -->
                                <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                                <li><a class="dropdown-item" href="myaccount.php">Llogaria</a></li>

                                <?php endif; ?>

                                <?php if(isset($_SESSION['isadmin']) && ($_SESSION['isadmin'] == 0)): ?>

                                <li><a class="dropdown-item" href="myaccount.php">Llogaria</a></li>
                                <li><a class="dropdown-item" href="myresidences.php">Residencat</a></li>
                                <?php endif; ?>

                                <li class="link-item">
                                    <a class="dropdown-item" href="?action=logout">Dil</a>
                                </li>

                            </ul>
                    
                        </li>
                        

                        
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link"  href="<?=$base_url?>register.php">Regjistrohu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" name="login" href="<?=$base_url?>login.php">Kycu</a>
                        </li>
                        <?php endif; ?> 

                        
                        

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="z-index:1;">
    <button type="button" class="btn btn-sm btn-outline-warning rounded-circle " onClick="history.go(-1)" style="position:fixed; margin:40px; padding:10px; z-index:2;">Prev</button>

    </section>
    
    
   
</body>
</html>



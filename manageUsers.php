<?php include('includes/header.php'); ?>

<?php
$errors = [];

$users = (new CRUD($pdo))->select('users',[],[],'','');

$users = $users->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deleteuser = (new CRUD($pdo))->delete('users','id',$_GET['id']);

    header('Location:manageUsers.php');
    exit;
}

if(isset($_POST['edit-btn'])){

    if((!empty($_POST['name'])) && (!empty($_POST['surname'])) && (!empty($_POST['email']))){

        $updateuser = (new CRUD($pdo)) -> update('users',['name','surname','email'],[$_POST['name'],$_POST['surname'],$_POST['email']],['id'=>$_POST['id']]);

        header('Location:manageUsers.php');


    }else {
        $errors [] = 'Hi! Something went wrong';
    }

}


?>
<?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
    if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): 
?>
    <section class="myresidences py-5">
        <div class="container">
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        <?php if(count($users) > 0): ?>
            <h2 class="text-center">Users (<?= count($users); ?>)</h2>
        
        <div class="row mt-4">
            <table class="table">
                <tr>
                    <!-- <th>Id</th> -->
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): 
                    if($user['id'] == $_SESSION['user_id'] && $_SESSION['user_id'] == $_SESSION['isadmin']){
                        continue;
                    }
                ?>
                <tr>
                    <!-- <td><?//= $myresidence['userid'] ?></td> -->
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['surname'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <a href="?action=delete&id=<?=$user['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a> /
                        <a href="?action=edit&id=<?=$user['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: echo '<p>0 residences </p>'; ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['action']) && $_GET['action']=='edit'): 
            
                $fillinputs = (new CRUD($pdo))->select('users',[],['id'=>$_GET['id']],1,'');
                $fillinput = $fillinputs->fetch();

            ?>
            
        <!-- <div class="container d-flex justify-content-center"> -->
            <div class="residence-form w-50 p-4 shadow rounded bg-light mx-auto mt-5">
                <div class="text-center mb-4">
                    <h3 class="mb-3 text-secondary">Modifiko te dhenat e userit</h3>
                </div>
                
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="id" class="form-control" id="id" value="<?= $fillinput['id']; ?>" >
                    </div>
                    <!-- <div class="mb-3">
                        <input type="hidden" name="userid" class="form-control" id="userid" value="<?//=$_SESSION['user_id'];?>" >
                    </div> -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="<?=$fillinput['name'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" name="surname" class="form-control" id="surname" value="<?=$fillinput['surname'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required value="<?=$fillinput['email'];?>">
                    </div>
                    
                    <button type="submit" name="edit-btn" class="btn btn-primary w-100">Modifiko</button>
                </form>
            </div>
        <!-- </div> -->
        <?php endif; ?>


        </div>
    </section>

<?php else: header('location:index.php');?>
<?php endif; endif; ?>









<?php include('includes/footer.php'); ?>
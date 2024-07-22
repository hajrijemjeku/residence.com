<?php include('includes/header.php'); 
//  ob_start()
?>

<?php

$errors = [];
$account = (new CRUD($pdo))->select('users',[],['id'=> $_SESSION['user_id']],1,'');
                  
if($account){
    $account = $account->fetch();
}
else{
    $errors[] = 'Something went wrong';
}
if(isset($_POST['update-btn'])){

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    $modify = (new CRUD($pdo))->update('users',['name','surname','email'],[$name, $surname, $email], ['id'=>$_SESSION['user_id']]);

    if($modify){
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['email'] = $email;
        
        header('Location:myaccount.php');
    }
    else{
        $errors[] = 'Something went wrong during modification';
    }
}
                 

?>


<section class="login my-5">
    <div class="container d-flex justify-content-center">
        <div class="login-form w-50  p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Llogaria</h3>
            </div>
            <?php if(count($errors)>0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif; ?>
           
            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name"  value="<?= $account['name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Surname</label>
                    <input type="text" name="surname" class="form-control" id="surname"  value="<?= $account['surname'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $account['email'] ?>" required aria-describedby="emailHelp">
                    <div id="divemail" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <button type="submit" name="update-btn" class="btn btn-success w-50 mb-3">Modifiko</button>
                    <?php if(isset($_SESSION['isadmin']) && $_SESSION['isadmin']==0): ?>
                    <button type="button" name="delete-btn" class="btn btn-danger w-50"  data-bs-toggle="modal" data-bs-target="#deleteUserModal<?= $account['id'] ?>" data-residence-id="<?= $account['id'] ?>">Fshij</button>
                    <?php endif; ?>
                </div>
            </form>
            <div class="modal fade" id="deleteUserModal<?= $account['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel<?= $account['id'] ?>">Confirm with password u wanna delete your '<?= $account['name'];?>' account </h5>
                            <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="deleteForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" id="password" required >
                                </div>
                                <input type="hidden" name="id" id="id" value="<?= $account['id'] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="deleteacc" type="submit" class="btn btn-primary">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
         </div>
    </div>
</section>


<?php 
    if(isset($_POST['deleteacc'])) {

        $password = $_POST['password'];
        $user_id = $account['id'];

        if(!empty($password)){

            $user = (new CRUD($pdo))->select('users',[],['id'=> $user_id],1,'');
            $user = $user->fetch();

            if(password_verify($password, $user['password'])){
                $deleteuser = (new CRUD($pdo))->delete('users','id',$user_id);

                session_unset();      
                session_destroy();
                unset($_SESSION['user_id']);
                unset($_SESSION['logged_in']);
                unset($_SESSION['is_admin']);
                unset($_SESSION['email']);
                header('Location: index.php');
                exit;
                
            }else{
                $errors[] = 'something went wrong';
            }
            
        }
    }

?>



<?php include('includes/footer.php'); ?>
<?php include('includes/header.php'); ?>

<?php

$errors = []    ;
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
        header('Location:residences.php');
        exit;
    }
    else{
        $errors[] = 'Something went wrong during modification';
    }
    

    

}
                 

?>


<section class="login my-5">
    <div class="container  d-flex justify-content-center">
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
           
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
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
                    <input type="email" name="email" class="form-control" id="email" value="<?= $account['email'] ?>"  aria-describedby="emailHelp">
                    <div id="divemail" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <!-- <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password"  value="<?//= $account['password'] ?>">
                </div> -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember" value="1">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
                <div class="mb-3">
                    <button type="submit" name="update-btn" class="btn btn-success w-50 mb-3">Modifiko</button>
                    <?php if(isset($_SESSION['isadmin']) && $_SESSION['isadmin']==0): ?>
                    <button type="submit" name="delete-btn" class="btn btn-danger w-50">Fshij</button>
                    <?php endif; ?>
                </div>
            

           
            </form>
            <?//php endforeach; ?>
        </div>
    </div>
    

</section>








<?php include('includes/footer.php'); ?>
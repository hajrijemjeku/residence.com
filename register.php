<?php include('includes/header.php'); ?>
<?php

$errors = [];

if(isset($_POST['register-btn']) ){

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password)){

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $password = password_hash($password, PASSWORD_BCRYPT);
            $crudObj = new CRUD($pdo);
            $allusers = $crudObj->select('users',[],['email'=> $email],'','');
            $allusers = $allusers->fetch();
            
            if($allusers){
                $errors[] = 'Ths email is already registered';
            }else{
                if($registerUser = $crudObj->insert('users',['name','surname','email','password'],[$name,$surname, $email, $password])){
                
                    header('Location:login.php');
                    // <div class='alert alert-success'><h3>Registered successfully!</h3></div>
                }else{
                    $errors[] = 'Something went wrong';
                }
            }
            
        }else{
            $errors[] = 'Email was not valid';
        }
    }else{
        $errors[] = 'Fill both email and password fields!';
    }

    
    
}


?>


<section class="register my-5">
    <div class="container d-flex justify-content-center">
        <div class="register-form w-50 p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Create an account</h3>
                <p class="text-secondary">Or, <a href="login.php" class="link-info text-decoration-none">sign in to your account</a></p>
            </div>
            <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Surname</label>
                    <input type="text" name="surname" class="form-control" id="surname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                    <div id="divemail" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                
                <button type="submit" name="register-btn" class="btn btn-primary w-100">Sign Up</button>
            </form>
        </div>
    </div>
</section>



<?php include('includes/footer.php'); ?>
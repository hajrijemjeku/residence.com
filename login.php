<?php include('includes/header.php'); ?>

<?php $errors = []; 

// $password = 'admin'; // Replace with the actual password from your database
// Hash the password
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
//echo $hashed_password;

    if(isset($_POST['login-btn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($email) && !empty($password)) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user = (new CRUD($pdo))->select('users',[],['email'=> $email],1,'');
                if($user){
                    $user = $user->fetch();
                    if(is_array($user)){
                        if(password_verify($password, $user['password'])) {
    
                            $_SESSION['logged_in'] = true;
                            $_SESSION['email'] = $email;
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['isadmin'] = $user['isadmin'];
                            $_SESSION['name'] = $user['name'];
                            $_SESSION['surname'] = $user['surname'];
        
                            header('Location: index.php');
        
                        } else{
                            $errors[] = 'Wrong password';
                        }
                    } else {
                        $errors[] = 'This email does not exists on our database';
                    }

                }else{
                    $errors[] = 'Database query error!';
                }
            } else{
                $errors[] = 'Invalid Email';
            }
        } else{
            $errors[] = 'Fill email and password fields!';
        }


    }






?>





<section class="login my-5">
    <div class="container  d-flex justify-content-center">
        <div class="login-form w-50  p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Sign in to your account</h3>
                <p class="text-secondary">Or, <a href="register.php" class="link-success rounded text-decoration-none">create an account</a></p>
            </div>
            <?php if(count($errors)>0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif; ?>

            <?//php //if(isset($_GET['success']) &&  $_GET['success'] == 1): ?>
            <!-- <div class="alert alert-info">
                Registered successfully.
                <br>
                Please log in!
            </div> -->
            <?//php// endif; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email"  aria-describedby="emailHelp">
                    <div id="divemail" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control"  id="password">
                </div>
                
            <button type="submit" name="login-btn" class="btn btn-success w-100">Sign In</button>
           
            </form>
        </div>
    </div>
    

</section>


<?php include('includes/footer.php'); ?>
<?php
include_once 'crud.php';

$errors = [];

if(isset($_POST['subscribe'])) {
    $email = $_POST['email'];

    if(!empty($email)) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $crudObj = new CRUD($pdo);
            $subscribers = $crudObj->select('subscribers', [], ['email'=>$email], 1, '');
            $subscribers = $subscribers->fetch();

            if(empty($subscribers)) {
                $subscribe = $crudObj->insert('subscribers', ['email'], [$email]);
                if($subscribe) {
                    // Success scenario
                    // Perform redirection
                    header('Location: index.php');
                    exit;
                } else {
                    $errors[] = 'Something went wrong';
                }
            } else {
                $errors[] = 'This email is already subscribed';
            }
        } else {
            $errors[] = 'Invalid email';
        }
    } else {
        $errors[] = 'Please enter an email address';
    }
}

// If there are errors, display them
if(!empty($errors)) {
    // You can choose to display errors in various ways, like alert boxes or inline messages.
    echo '<script type="text/javascript">alert("INFO: '.$errors[0].'");</script>';
    // Redirect to index.php if needed
    // header('Location: ../index.php');
    // exit;
}


// $errors = [];

// if(isset($_POST['subscribe'])) {
//     $email = $_POST['email'];

//     if(!empty($email)) {
//         if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $crudObj = new CRUD($pdo);
//             $subscribers = $crudObj->select('subscribers', [], ['email'=>$email], 1, '');
//             $subscribers = $subscribers->fetch();

//             if(empty($subscribers)) {
//                 $subscribe = $crudObj->insert('subscribers', ['email'], [$email]);
//                 if($subscribe) {
//                     // Subscription successful
//                     echo '<div class="success-message">You have successfully subscribed!</div>';
//                 } else {
//                     $errors[] = 'Something went wrong with the subscription.';
//                 }
//             } else {
//                 $errors[] = 'This email is already subscribed.';
//             }
//         } else {
//             $errors[] = 'Invalid email format.';
//         }
//     } else {
//         $errors[] = 'Please enter your email address.';
//     }
// }




?>

    <footer class="mt-5 bg-light py-3">
    <div class="container mt-4">
    <?php
    // Display errors if there are any
    //if(!empty($errors)) {
      //  echo '<div class="error-message">' . implode('<br>', $errors) . '</div>';
    //}
    ?>
        <div class="row">
            <div class="col-sm-12 col-md-4 mb-4" >
                <h1 class="fs-6 text-secondary mt-3"><a href="index.php" class="text-decoration-none text-success">residence.com</a></h1>
                <p class="fs-6 text-secondary mt-4 w-75">&copy; 2024 residence.com Te gjitha te drejtat te rezervuara.</p>
            </div>

            <div class="col-sm-12 col-md-4 mb-4" >
                <h1 class="fs-6 text-secondary text-center mt-3 ">Social Media</h1>
                <ul class="list-unstyled text-center">
                    <li><a href="#" class="text-decoration-none text-success">Facebook</a></li>
                    <li><a href="#" class="text-decoration-none text-success">Instagram</a></li>
                    <li><a href="#" class="text-decoration-none text-success">Tiktok</a></li>
                    <li><a href="#" class="text-decoration-none text-success">Twitter(X)</a></li>
                </ul>
            </div>

            <div class="col-sm-12 col-md-4 mb-4" >
                <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="input-group mt-3 w-75 mx-auto">
                        <input type="email" name="email" class="form-control form-control-sm " placeholder="Enter your email" aria-label="Enter your email" aria-describedby="button-addon2">
                        <button class="btn btn-success btn-sm" type="submit" name="subscribe" id="button-addon2">Subscribe</button>
                    </div>
                </form>
                <ul class="list-unstyled text-white w-75  mt-3 mx-auto">
                    <li><a href="#" class="text-decoration-none text-success">info@example.com</a></li>
                    <li><a href="#" class="text-decoration-none text-success">1234567890</a></li>
                    <li><a href="#" class="text-decoration-none text-success">123 Street, City, Country</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
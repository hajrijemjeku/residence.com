<?php include('includes/header.php'); ?>
<?php 
// $_SESSION['addlimit'] = 1;
// unset($_SESSION['addlimit']);


$errors= [];
if(isset($_POST['subscr'])) {
    $email = $_POST['email'];

    if(!empty($email)) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $crudObj = new CRUD($pdo);
            $subscribers = $crudObj->select('subscribers', [], ['email'=>$email], 1, '');
            $subscribers = $subscribers->fetch();

            if(empty($subscribers)) {
                $subscribe = $crudObj->insert('subscribers', ['email'], [$email]);
                if($subscribe) {
                    $errors[] = 'Subscribed successfully!!';
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
// SUBSCRIBE PART
// if(isset($_POST['subscribe'])){

//     $email = $_POST['email'];

//     if(!empty($email)){
//         if(filter_var($email, FILTER_VALIDATE_EMAIL)){
//             $crudObj = new CRUD($pdo);
//             $subscribers = $crudObj->select('subscribers',[],['email'=>$email],1,'');
//             $subscribers = $subscribers->fetch();
//             if(empty($subscribers) && !($subscribers['email']==$email)) {
//                 $subscribe = $crudObj->insert('subscribers',['email'],[$email]);
//                 if($subscribe){
//                     echo ' you subscribed';
//                     header('Location:index.php');
//                 }else {
//                     $errors[] = 'something went wrong';
//                     header('Location:login.php');

//                 }
//                 // exit;
//             }else if(!empty($subscribers) && ($subscribers['email']==$email)){
               
                
//                 $errors[] = 'This email already subscribed';
//                 header('Location:residences.php');

//             }
//         }else{
//             $errors[] = 'invalid email';
//         }
//     }
//     else{
//         $errors[] = 'please write email on input field';
//     }
//     // header('Location:index.php');
// }


// if(isset($_POST['subscribe'])) {
//     $email = $_POST['email'];

//     if(!empty($email)) {
//         if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $crudObj = new CRUD($pdo);
            
//             // Check if email already exists in database
//             $subscribers = $crudObj->select('subscribers', [], ['email' => $email], 1, '');
//             $existingSubscriber = $subscribers->fetch();

//             if(!$existingSubscriber) {
//                 // Email does not exist, proceed to insert
//                 $subscribe = $crudObj->insert('subscribers', ['email'], [$email]);
//                 if($subscribe) {
//                     echo 'You subscribed successfully.';
//                     exit; // Exit after successful subscription
//                 } else {
//                     $errors[] = 'Something went wrong while subscribing.';
//                 }
//             } else {
//                 // Email already exists in database
//                 $errors[] = 'This email is already subscribed.';
//             }
//         } else {
//             $errors[] = 'Invalid email format.';
//         }
//     } else {
//         $errors[] = 'Please enter your email address.';
//     }

//     // Redirect back to index.php with errors
//    // $_SESSION['errors'] = $errors; // Assuming you handle errors using session
//     header('Location: index.php');
//     exit; // Ensure script execution stops after redirection
// }


// if (isset($_POST['subscribe'])) {
//     $email = $_POST['email'];

//     if (!empty($email)) {
//         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $crudObj = new CRUD($pdo);

//             // Insert new subscriber
//             $subscribe = $crudObj->insert('subscribers', ['email'], [$email]);
//             if ($subscribe === true) {
//                 echo 'You subscribed!';
//             } elseif ($subscribe === false) {
//                 $errors[] = 'This email is already subscribed';
//             } else {
//                 $errors[] = 'Something went wrong';
//             }
//         } else {
//             $errors[] = 'Invalid email';
//         }
//     } else {
//         $errors[] = 'Please enter an email address';
//     }
// }





?>

<style>
    
</style>


<!-- SLIDER SECTION -->
<section class="slider" style="position:relative;">
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner p-3 my-3">
            <div class="carousel-item active">
                <img src="./assets/images/slider/slider1.jpg" class="d-block w-100" height="600px" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/slider/slider2.jpg" class="d-block w-100" height="600px" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/slider/slider3.jpg" class="d-block w-100" height="600px" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">

    <div class="form" style="position:absolute; width:50%; height:10%; top:65%; left:30%;">
        <div class="row g-3">
            <div class="col-sm-8  ">
                <input type="text" name="inputcity" class="form-control form-control-lg " placeholder="Kerko ne baze te qytetit">
            </div>
            <div class="col-sm-4">
                <input type="submit" name="searchbycity" class="btn btn-success btn-lg " value="Kerko">
            </div>
        </div>
    </div>

    </form>

</section>



<!-- SHOW ALL RESIDENCES SECTION -->
<section class="residences py-5">
    <div class="container">
        
        <?php

        $crudObj = new CRUD($pdo);
        
  
        if(isset($_GET['searchbycity']) && !empty($_GET['inputcity'])){
            $city = $_GET['inputcity'];
            $residences = $crudObj->search('residence',[],['city'=>$city]);
            $residences = $residences->fetchAll();
        }else{
            $residences = $crudObj->select('residence',[],[],6,'');
            $residences = $residences->fetchAll();
        }
        
        //SEARCH BY CITY
        // $residences = $crudObj->select('residence',[],[],6,'');
        //         $residences = $residences->fetchAll();
        $nrofresidences = count($residences);

        ?>
        <?//php if(count($residences) == 0): ?>
            <!-- <h2 class="text-center"> (<?//= count($residences); ?>) Residences with  input: <?//= $city; ?></h2> -->
        <?//php endif; ?>
        <?php if(empty($city)): ?>
            <h2 class="text-center">Latest Residences</h2>
        <?php else: ?>
            <h2 class="text-center"> (<?= count($residences); ?>) Residences with  input: <?= $city; ?></h2>
        <?php endif; ?>
        <div class="row mt-4">
            <!-- <form action="<?//= $_SERVER['PHP_SELF'] ?>" method="GET"> -->

            <?php foreach($residences as $residence): ?>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-5" style="height:500px;">
                <div class="card d-flex flex-column h-100" style="width: 24rem;" >
                    <img src="./assets/images/residences/<?=$residence['image'];?>" class="card-img-top h-50 mb-5" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $residence['title'] . ' - '. $residence['status']; ?></h5>
                        <p class="card-text">Qyteti: <?php echo  $residence['city']; ?> </p>
                        <p class="card-text">Hapesira: <?php echo  $residence['squaremeters'] .'m&sup2;, Cmimi:' . $residence['price']; ?>&euro;</p>
                        <a href="<?=$base_url?>residencedetails.php?id=<?= $residence['id'] ?>" class="btn btn-outline-info" >View Details</a>
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):?>
                        <!-- <a href="<?//=$base_url?>residencedetails.php?id=<?//= $residence['id'] ?>" class="btn btn-outline-success" name="addreview">Add a review</a> -->
                        <button type="submit" class="btn btn-outline-success add-review-btn" data-bs-toggle="modal" data-bs-target="#addReviewModal<?= $residence['id'] ?>" data-residence-id="<?= $residence['id'] ?>">Add a review</button>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        <!-- MODAL FROM CHATGPT -->
        <!-- Modal Structure -->
        <div class="modal fade" id="addReviewModal<?= $residence['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="addReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addReviewModalLabel<?= $residence['id'] ?>">Add a Review for <?= $residence['title']; ?></h5>
                        <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="reviewForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= $_SESSION['user_id']?>" required>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <input type="hidden" name="residence_id" id="residence_id" value="<?= $residence['id'] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button name="submitreview" type="submit" class="btn btn-primary">Save Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <?php endforeach; ?>



            <!-- </form> -->
            
        </div>
        <?php if(!isset($_GET['searchbycity'])): ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>">
                <!-- <div class="row mt-5"> <?php
                // $nrofresidences = count($residences);
                //if($_SESSION['addlimit'] <= $nrofresidences):
                     ?>
                    <input type="submit" name="morebtn" class="btn btn-info w-25 mx-auto" value="Shiko me shume">
                    <?//php endif;?>
                </div> -->
            </form>
        
        <!-- <div class="row mt-5">
            <a href="?morebtn=1" name="morebtn" class="btn btn-info w-25 mx-auto">Shiko me shume</a>
        </div> -->
        <?php endif; ?>
        <div class="row">
        <div class="col-12">
            <hr class="mx-auto mt-5 border-secondary">
        </div>
        </div>
    </div>
</section>


<?php if(isset($_POST['submitreview'])) {

        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        $residence_id = $_POST['residence_id'];
        $user_id = $_SESSION['user_id'];


        $insertreview = (new CRUD($pdo))->insert('reviews',['rating','comment', 'residence_id','user_id'],[$rating,$comment,$residence_id,$user_id]);

        if($insertreview){
            //header('residences.php');
            echo "inserted";
            
        }else{
            $errors[] = 'something went wrong';
        }


    }?>


<!-- DONT HAVE AN ACCOUNT? -->
 <section class="account py-5" >
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):?>
        <div class="container">
            <h2 class="text-center">Tashme jeni te kycur ne llogarine tuaj!</h2>
            <div class="row mt-4">
                <div class="col col-lg-6 col-md-6 col-sm-12 mt-5" > <!-- style="background-color: aquamarine;"-->
                    <div class="text-center py-5 my-5">
                        <h4>Ofro Residence!</h4>
                        <p>Ne rast se keni residenca per te ofruar, sherbimet tona jane ne dispozicionin tuaj per t'i ofruar ato!</p>
                        <a href="offerResidence.php" class="btn btn-lg   btn-outline-info">Ofro Residence</a>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 px-5" > <!--style="background-color: beige;" -->
                    <img src="./assets/images/slider/offerresidence.webp" alt="" height="400px">
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
            </div>
        </div>
        <?php else: ?>
        <div class="container">
            <h2 class="text-center">Nuk keni llogari?</h2>
            <div class="row mt-4">
                <div class="col col-lg-6 col-md-6 col-sm-12 mt-5" > <!-- style="background-color: aquamarine;"-->
                    <div class="text-center py-5 my-5">
                        <h4>Krijo llogari</h4>
                        <p>Ne rast se nuk keni llogari, krijojeni dhe do keni qasje ne sherbimet tona.</p>
                        <a href="register.php" class="btn btn-lg   btn-outline-info">Regjistrohu</a>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12 px-5" > <!--style="background-color: beige;" -->
                    <img src="./assets/images/slider/register.png" alt="" height="400px">
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
            </div>
        </div>
    
        
    <?php endif; ?>

    
 </section>

<!-- ABOUT US -->
<section class="about-us py-5">
    <div class="container">
        <h2 class="text-center">Rreth Nesh</h2>
        <div class="row mt-4">
            <div class="col col-lg-6 col-md-6 col-sm-12 px-5">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php
                        $allresidences = (new CRUD($pdo))->select('residence',[],[],'','');
                        $allresidences = $allresidences->fetchAll();
                         foreach($allresidences as $index => $residence): ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $index; ?>" class="<?= $index === 0 ? 'active' : ''; ?>" aria-current="true" aria-label="Slide <?= $index + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach($allresidences as $index => $residence): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                <img src="./assets/images/residences/<?= $residence['image']; ?>" class="d-block w-100 mt-5" height="300px" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3 class="text-light bg-secondary"><?= $residence['title']; echo ", " . $residence['price'];?> &euro;
                                
                                    </h3>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12">
                <div class="text-center py-5 my-5">
                    <h4>Cka ofron residence.com?:</h4>
                    <h3>Vendi ideal per ofrim/kerkim te residences sipas nevojave tuaja!</h3>
                    <p>Mundeson krijimin e llogarive dhe mirembajtjen e tyre</p>
                    <p>Ofron mundesi per kerkim te shtepive/banesace/villave</p>
                    <p>Mundesi per ofrim te residencave</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
        </div>
    </div>
</section>

 <!-- STATISTICS -->
 <section class="statistics py-5">
    <div class="container">
        <div class="row mt-4">
            <div class="col col-lg-3 col-md-4 col-sm-12 border border-2 mx-auto rounded">
                <h6>Numri perdoruesve</h6>
                <?php 
                $users = (new CRUD($pdo))->select('users',[],[],'',''); 
                $users = $users->fetchAll();
                ?>
                <p><strong id="usersCount" data-count="<?= count($users) ?>">0</strong></p>
            </div>
            <div class="col col-lg-3 col-md-4 col-sm-12 border border-2 mx-auto rounded">
                <h6>Numri residencave</h6>
                <p><strong id="residencesCount" data-count="<?= count($allresidences) ?>">0</strong></p>
            </div>
            <div class="col col-lg-3 col-md-4 col-sm-12 border border-2 mx-auto rounded">
                <h6>Numri i reviews</h6>
                <?php 
                $nrofReviews = (new CRUD($pdo))->select('reviews',[],[],'',''); 
                $nrofReviews = $nrofReviews->fetchAll(); 
                ?>
                <p><strong id="citiesCount" data-count="<?= count($nrofReviews) ?>">0</strong></p>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let animated = false;

        function animateCountUp(element) {
            const countTo = element.getAttribute('data-count');
            const c = new countUp.CountUp(element.id, countTo);
            if (!c.error) {
                c.start();
            } else {
                console.error(c.error);
            }
        }

        function handleScroll() {
            const section = document.querySelector('.statistics');
            const sectionTop = section.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (sectionTop < windowHeight && !animated) {
                animated = true; // Mark as animated to prevent future triggers
                document.querySelectorAll('.statistics [data-count]').forEach(animateCountUp);
                document.removeEventListener('scroll', handleScroll); // Remove scroll listener after animation
            }
        }

        document.addEventListener('scroll', handleScroll);
    });
</script>


<!-- REVIEWS -->
 <section class="reviews py-5" > <!--style="color: #000; background-color: #f3f2f2;" -->
    <div class="container">
        <div class="row justify-content-md-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
            <h2 class="fs-6 text-secondary mb-2 text-uppercase text-center">Happy Customers</h2>
            <p class="display-5 mb-4 mb-md-5 text-center">We deliver what we promise. See what clients are expressing about us.</p>
            <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
        </div>
        </div>
    </div>

    <div class="container overflow-hidden" id="review">
        <div class="row gy-4 gy-md-0 gx-xxl-5 mb-3">
        <?php
            if(!isset($_SESSION['addlimit'])){
                $_SESSION['addlimit'] = 3;
            }
            if (isset($_POST['morebtn'])) {
                $_SESSION['addlimit'] = $_SESSION['addlimit'] + 3; // Increment $_SESSION['addlimit'] when morebtn is clicked
                // header('Location: index.php');
                // exit;
            }
            // echo($_SERVER['SCRIPT_FILENAME']);
            // $current_script = basename($_SERVER['SCRIPT_FILENAME']);
            // echo($current_script);
            // if ($current_script !== "index.php") {
            //     $_SESSION['addlimit'] = 3;
            // }
           

            //if((new Crud($pdo))->delete('order_product', 'order_id', $_GET['id']) && (new Crud($pdo))->delete('orders', 'id', $_GET['id'])){
                // if(isset($_GET['morebtn']) && !empty($_GET['morebtn'])):

                    $reviews = (new CRUD($pdo))->select('reviews',[],[],$_SESSION['addlimit'],'');// && (new CRUD($pdo))->select('residence',[],[],'','') );
                    
                    $reviews = $reviews->fetchAll();
                
    ?>
            <?php foreach($reviews as $review): 
                $residencereview = (new CRUD($pdo))->select('residence',[],['id'=>$review['residence_id']],1,'');
                $residencereview = $residencereview->fetch();    
            ?>
        <div class="col-12 col-md-4 mb-5">
            <div class="card border-0 border-bottom border-primary shadow-sm d-flex flex-column h-100 bg-light">
            <div class="card-body p-4 p-xxl-5 d-flex flex-column justify-content-between">
                
            <h6 class=" mb-5 text-secondary text-end"><?php $createdAt = $review['created_at']; $createdAt = date('m/Y',strtotime($createdAt)); echo $createdAt; ?></h6>
                <figure>
                <!-- <img class="img-fluid rounded rounded-circle mb-4 border border-5 w-50 " style="margin-left: 70px;"  loading="lazy" src="./assets/images/slider/<?php //if($review['residence_id']==$residence['id']) return $residence['image'];?>" alt=""> -->
                <img class="img-fluid rounded rounded-circle mb-4 border border-5 w-50"   loading="lazy" src="./assets/images/residences/<?= $residencereview['image'];?>" alt="">
                <figcaption>
                    <div class="bsb-ratings text-warning mb-3" data-bsb-star="<?=$review['rating']?>" data-bsb-star-off="<?= ($review['rating']===5) ? 0 : (5 - $review['rating']) ?>"></div>
                    <blockquote class="bsb-blockquote-icon mb-4"><?=$review['comment']?></blockquote>
                    <?php foreach($users as $user){ 
                        if($user['id'] == $review['user_id']):
                    ?>
                    <h4 class="mb-2"><?= $user['name'];?></h4>
                    <h5 class="fs-6 text-secondary mb-0"><?= $user['email'] ; ?></h5>
                    <?php endif; } ?>
                </figcaption>
                </figure>
            </div>
            </div>
        </div>
        <?php endforeach;?>
        

        <?//php };?>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="submit" name="morebtn" class="btn btn-info w-25 mx-auto" value="Shiko me shume">


        </form>
        <div class="row mt-4">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
        </div>
    </div>
  
 </section>

 <!-- SUBSCRIBE -->
  <section class="subscribe py-5">
    <div class="container rounded" style="background-color:#bad9c7;">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fs-6 pt-4 text-secondary mb-3 text-uppercase text-center">Subscribe to Residence.com</h2>
                <!-- <hr class="w-50 mx-auto mb-4 border-dark-subtle"> -->
            </div>
        </div>
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif; ?>
        
        <div class="row mb-4">
            <div class="col-12 col-md-8 mx-auto">
                
                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div class="input-group">
                        <input type="email" name="email" class="form-control form-control-lg rounded-start-pill" placeholder="Enter your email" aria-label="Enter your email" aria-describedby="button-addon2">
                        <button class="btn btn-success btn-lg rounded-end-pill" name="subscr" type="submit" id="subscr">Subscribe</button>
                        <!-- <input type="submit" class="btn btn-success btn-lg rounded-end-pill" name="subscribe" id="subscribe" value="Subscribe"> -->
                        </div>
                    </form>
                
                <div class="form-text text-center mt-2">We'll never share your email with anyone else.</div>
            </div>
        </div>
        
       
    </div>
</section>


<?php include('includes/footer.php'); ?>
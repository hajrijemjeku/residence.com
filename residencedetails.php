<?php include('includes/header.php'); ?>



<section class="residences py-5">
    <div class="container">
        <h2 class="text-center">Residenca</h2>
        <?php $crudObj = new CRUD($pdo);
        if(isset($_GET['id'])){
            $residences = $crudObj->select('residence',[],['id'=>$_GET['id']],'','');

            $residence = $residences->fetch();
            // echo "<pre>";
            // print_r($residence);
        }
            
            // die();
        ?>
        <div class="row mt-4">
        <?php //foreach($residences as $residence): ?>
        <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
            <div class="card d-flex flex-column h-100" style="width: 40rem;" >
            <img src="./assets/images/residences/<?=$residence['image'];?>" class="img-fluid h-50" alt="Residence Image">
            
            <!-- <img src="<?//= __DIR__ ?>/assets/images/slider/<?//=$residence['image'];?>" class="img-fluid" alt="Residence Image"> -->
            <form action="<?php $_SERVER['PHP_SELF']?>" method="GET">

            <div class="card-body">
                    <input type="hidden" name="id" value="<?= $residence['id']; ?>">
                    <h5 class="card-title"><?php echo $residence['title'] . ' - '. $residence['status']; ?></h5>
                    <p class="card-text">Qyteti: <?php echo  $residence['city']; ?> </p>
                    <p class="card-text" name="rooms">Nr Dhomave: <?php echo  $residence['rooms']; ?> </p>
                    <p class="card-text" name="neighborhood">Lagje: <?php echo  $residence['neighborhood']; ?> </p>
                    <p class="card-text" name="street">Rruga: <?php echo  $residence['street']; ?> </p>
                    <p class="card-text" name="tel">Nr Tel: <?php echo  $residence['tel']; ?> </p>
                    <p class="card-text" name="status">Status: <?php echo  $residence['status']; ?> </p>
                    <p class="card-text" name="rooms">Pershkrimi: <?php echo  $residence['description']; ?> </p>
                    <p class="card-text" name="squaremeters">Hapesira: <?php echo  $residence['squaremeters'] .'m&sup2;, Cmimi:' . $residence['price']; ?>&euro;</p>
                    
                    <a href="?action=viewreviews&id=<?=$residence['id'];?>" class="btn btn-outline-info" name="view-reviews">View Reviews</a>
                    

                    
            </div>

            </form>
            
            </div>

        </div>
        <?php //endforeach; ?>
        </div>
        <div class="row">
        <div class="col-12">
            <hr class="mx-auto mt-5 border-success">
        </div>

        
    </div>
</section>
<?php if(isset($_GET['action']) && $_GET['action'] == 'viewreviews'): ?>
<section class="reviews py-5"> <!--style="color: #000; background-color: #f3f2f2;" -->

    <div class="container overflow-hidden">
        <div class="row gy-4 gy-md-0 gx-xxl-5 mb-3">
        <?php
            $reviews = (new CRUD($pdo))->select('reviews',[],['residence_id'=>$_GET['id']],'','');// && (new CRUD($pdo))->select('residence',[],[],'','') );
            //if($reviews):
            $reviews = $reviews->fetchAll();
            ?>
            <?php if(count($reviews) == 0): ?>
                <h3 class="text-center mb-5"><?= count($reviews); ?> Reviews for this product! </h3>
                <?php else: ?>
                    <h3 class="text-center mb-5">
                        <?php  if(count($reviews)==1):
                            echo count($reviews)  ?> Review for this product!
                        <?php else: echo count($reviews) ?> Reviews for this product! 
                        <?php endif; ?>
                    </h3>
                <?php endif; ?>


            <?php 
                foreach($reviews as $review):   
                    if($review): 
                        $residencereview = ((new CRUD($pdo))->select('residence',[],['id'=>$review['residence_id']],1,''));
                        $residencereview = $residencereview->fetch(); 
            ?>
            
        <div class="col-12 col-md-4">
            
            <div class="card border-0 border-bottom border-primary shadow-sm d-flex flex-column h-100">
            <div class="card-body p-4 p-xxl-5 d-flex flex-column justify-content-between">
                

                
            <h6 class=" mb-5 text-secondary text-end"><?php $createdAt = $review['created_at']; $createdAt = date('m/Y',strtotime($createdAt)); echo $createdAt; ?></h6>
                <figure>
                <!-- <img class="img-fluid rounded rounded-circle mb-4 border border-5 w-50 " style="margin-left: 70px;"  loading="lazy" src="./assets/images/slider/<?php //if($review['residence_id']==$residence['id']) return $residence['image'];?>" alt=""> -->
                <img class="img-fluid rounded rounded-circle mb-4 border border-5 w-50"   loading="lazy" src="./assets/images/residences/<?= $residencereview['image'];?>" alt="">
                <figcaption>
                    <div class="bsb-ratings text-warning mb-3" data-bsb-star="<?=$review['rating']?>" data-bsb-star-off="<?= ($review['rating']===5) ? 0 : (5 - $review['rating']) ?>"></div>
                    <blockquote class="bsb-blockquote-icon mb-4"><?=$review['comment']?></blockquote>
                    <?php
                    $users = (new CRUD($pdo))->select('users',[],['id'=>$review['user_id']],1,''); 
                    $user = $users->fetch();
                    // foreach($users as $user){ 
                    //     if($user['id'] == $review['user_id']):
                    ?>
                    <h4 class="mb-2"><?= $user['name'];?></h4>
                    <h5 class="fs-6 text-secondary mb-0"><?= $user['email'] ; ?></h5>
                    <?//php endif; } ?>
                </figcaption>
                </figure>
            </div>
            </div>
            <?//php endif; ?>
        </div>
        <?//php// endforeach;?>
        <?php endif; endforeach;?>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <hr class="mx-auto mt-5 border-secondary">
            </div>
           
        </div>
    </div>

</section>
<?php endif; ?>


<section class="residences py-5">
    <div class="container">
        
        <div class="row">
            <div class="similar">
            <h2 class="text-start">Te ngjashme</h2>
                
            <!-- me u shfaq info te njojta psh nlidhje me  qytetin ose type ose status -->
            <?php 
                if(isset( $residence['status'] ) && isset($residence['rooms'])) {
                    
                    
                    $status = $residence['status'];
                    $rooms = $residence['rooms'];

                    $crudObj = new CRUD($pdo);
                    // $residences = $crudObj->search('residence',[],['rooms'=>$_GET['rooms'],'status'=>$_GET['status']]);
                    $similarities = $crudObj->select('residence',[],['status'=>$status],'','');

                    $similarities = $similarities->fetchAll();
                }
           
        
            
        ?>
        <div class="row mt-4">
        <?php foreach($similarities as $similar): ?>
        <div class="col-lg-4 col-md-4 col-sm-12 mb-5">
            <div class="card d-flex flex-column h-100" style="width: 25rem;" >
            <img src="./assets/images/residences/<?=$similar['image'];?>" class="img-fluid h-75" alt="Residence Image">
            
            <!-- <img src="<?//= __DIR__ ?>/assets/images/slider/<?//=$residence['image'];?>" class="img-fluid" alt="Residence Image"> -->
            <form action="<?php $_SERVER['PHP_SELF']?>" method="GET">

            <div class="card-body">
                    <input type="hidden" name="id" value="<?= $similar['id']; ?>">
                    <h5 class="card-title"><?php echo $similar['title'] . ' - '. $similar['status']; ?></h5>
                    <p class="card-text">Qyteti: <?php echo  $similar['city']; ?> </p>
                    <p class="card-text" name="rooms">Nr Dhomave: <?php echo  $similar['rooms']; ?> </p>
                    <p class="card-text" name="neighborhood">Lagje: <?php echo  $similar['neighborhood']; ?> </p>
                    <p class="card-text" name="street">Rruga: <?php echo  $similar['street']; ?> </p>
                    <p class="card-text" name="tel">Nr Tel: <?php echo  $similar['tel']; ?> </p>
                    <p class="card-text" name="status">Status: <?php echo  $similar['status']; ?> </p>
                    <p class="card-text" name="rooms">Pershkrimi: <?php echo  $similar['description']; ?> </p>
                    <p class="card-text" name="squaremeters">Hapesira: <?php echo  $similar['squaremeters'] .'m&sup2;, Cmimi:' . $similar['price']; ?>&euro;</p>
                    <!-- <a href="<?//=$base_url?>residencedetails.php/<?//= $residence['id'] ?>" class="btn btn-outline-info" >View Details</a> -->
            </div>

            </form>
            
            </div>

        </div>
        <?php endforeach; ?>
        </div>
             
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
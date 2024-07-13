<?php include('includes/header.php'); ?>


<?php $crudObj = new CRUD($pdo);
            $residences = $crudObj->select('residence',[],[],'','');
            $residences = $residences->fetchAll();
        ?>
<section class="residences py-5">
    <div class="container">
        <h2 class="text-center">Residences</h2>
        
        <div class="row mt-4 ">
       
            <!-- <form action="<?//= $_SESSION['PHP_SELF']; ?>" method="GET" > -->
            <?php foreach($residences as $residence): ?>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3" style="height:500px;">
                    <div class="card d-flex flex-column h-100" style="width: 25rem;" >
                        <img src="./assets/images/residences/<?=$residence['image'];?>" class="card-img-top mb-5 h-50" alt="...">
                        <div class="card-body">
                            <input type="hidden" name="residence_id" id="residence_id" value="<?= $residence['id']; ?>">
                            <h5 class="card-title"><?php echo $residence['title'] . ' - '. $residence['status']; ?></h5>
                            <p class="card-text">Qyteti: <?php echo  $residence['city']; ?> </p>
                            <p class="card-text">Hapesira: <?php echo  $residence['squaremeters'] .'m&sup2;, Cmimi:' . $residence['price']; ?>&euro;</p>
                            <a href="<?=$base_url?>residencedetails.php?id=<?= $residence['id'] ?>" class="btn btn-outline-info" name="viewdetails" >View Details</a>
                            <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):?>
                                <!-- <a href="<?//=$base_url?>residencedetails.php?id=<?//= $residence['id'] ?>" class="btn btn-outline-success" name="addreview">Add a review</a> -->
                                <!-- <button type="submit" name="addmodal" class="btn btn-outline-success add-review-btn" data-bs-toggle="modal" data-bs-target="#addReviewModal" data-residence-id="<?//= $residence['id'] ?>">Add a review</button> -->
                                <!-- <a href="?action=review&id=<?//= $residence['id'] ?>" class="btn btn-outline-success add-review-btn" name="addmodal"  data-bs-toggle="modal" data-bs-target="#addReviewModal" data-residence-id="<?//= $residence['id'] ?>">Add Review</a> -->




                                <!-- <a href="#" class="btn btn-outline-success add-review-btn" name="addmodal" data-bs-toggle="modal" data-bs-target="#addReviewModal" data-residence-id="<?//= $residence['id'] ?>">Add Review</a> -->

                                <button type="submit" class="btn btn-outline-success add-review-btn" data-bs-toggle="modal" data-bs-target="#addReviewModal<?= $residence['id'] ?>" data-residence-id="<?= $residence['id'] ?>">Add a review</button>


                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                            <!-- MODAL FROM CHATGPT -->
 <!-- Modal Structure -->
 <div class="modal fade" id="addReviewModal<?= $residence['id'] ?>" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReviewModalLabel<?= $residence['id'] ?>">Add a Review for <?= $residence['title'] ?></h5>
                <button type="submit" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                    <input type="hidden" name="residence_id" id="residence_id_modal" value="<?= $residence['id'] ?>" required>
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
        <div class="row">
        <div class="col-12">
            <hr class="mx-auto mt-5 border-secondary">
        </div>
        </div>
    </div>
</section>


<?php 

    if(isset($_POST['submitreview'])) {

        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        $residence_id = $_POST['residence_id'];
        $user_id = $_POST['user_id'];
        
        
        $insertreview = (new CRUD($pdo))->insert('reviews',['rating','comment', 'residence_id','user_id'],[$rating,$comment,$residence_id,$user_id]);
        
        if($insertreview){
            header('residences.php');
            // exit;
            
        }else{
            $errors[] = 'something went wrong';
        }
        
        
    }


//}





?>



<?php include('includes/footer.php'); ?>
<?php include('includes/header.php'); ?>


<?php 
    $crudObj = new CRUD($pdo);
    $residences = $crudObj->select('residence',[],[],'','');
    $residences = $residences->fetchAll();
    ?>

<section class="residences py-5">
    <div class="container">
        <form action="<?= $_SERVER['PHP_SELF']?>" class="d-inline">
            <button class="btn btn-outline-success" title="Nga me e shtrenjta tek me e lira" type="submit" name="down">
                <i class="fa fa-arrow-down"></i>
            </button><span>Price</span>
            <button class="btn btn-outline-success" title="Nga me e lira tek me e shtrenjta" type="submit" name="up">
                <i class="fa fa-arrow-up"></i>
            </button>
        </form>
        <?php
            if(isset($_GET['down'])){
                $residences = $crudObj->select('residence',[],[],'','price DESC');
                $residences = $residences->fetchAll();
            }else if(isset($_GET['up'])){
                $residences = $crudObj->select('residence',[],[],'','price ASC');
                $residences = $residences->fetchAll();
            }
        ?>
        
        
       

        <button type="submit" class="btn btn-outline-success filter-btn" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
        <!-- MODAL FOR FILTERING DATA-->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                            <button type="submit" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="reviewForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rooms">Rooms:</label>
                                    <input type="number" class="form-control" id="rooms" name="rooms" min="1">
                                </div>
                                <div class="form-group">
                                    <label for="status" class="form-label">Statusi</label>
                                    <select name="status" id="status" class="form-control mb-2">
                                        <option value="">Select Status</option>
                                        <?php
                                            $statusenum = (new CRUD($pdo))->distinctSelect('residence','status');
                                            $statusenum = $statusenum->fetchAll();
                                            
                                            foreach($statusenum as $status):
                                        ?>
                                        <option value="<?= $status['status']; ?>"><?= $status['status']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="form-label">Tipi</label>
                                    <select name="type" id="type" class="form-control mb-2">
                                        <option value="">Select Type</option>
                                        <?php
                                            $types = (new CRUD($pdo))->select('type',[],[],'','');
                                            $types = $types->fetchAll();
                                            
                                            foreach($types as $type):
                                        ?>
                                        <option value="<?= $type['id']; ?>"><?= $type['name']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="filterdata" type="submit" class="btn btn-primary">Filtro</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        <?php
            if(isset($_POST['filterdata'])){
                $rooms = $_POST['rooms'];
                $status = $_POST['status'];
                $type = $_POST['type'];

                $filterConditions = [];
                if (!empty($rooms)) {
                    $filterConditions['rooms'] = $rooms;
                }
                if (!empty($status)) {
                    $filterConditions['status'] = $status;
                }
                if (!empty($type)) {
                    $filterConditions['typeid'] = $type;
                }

                $residences = $crudObj->select('residence', [], $filterConditions, '', '');
                $residences = $residences->fetchAll();
               
            }
        
        ?>

        <?php
        if(!empty($_POST['type'])){
            $typesname = $crudObj->select('type',[],['id'=>$_POST['type']],1,'');
            $name = $typesname->fetch();        
        }else{
            $name = '';
        }
        
        ?>
        <h2 class="text-center">Residencat (<?= count($residences) ?>) </h2>

        <?php if(count($residences)>0 && isset(($_POST['filterdata']))):?>
            <!-- <h2 class="text-center">Residences me te dhenat e kerkuara : -->
            <p class="text-center">
                <?php if(!empty($rooms) && !empty($status) && !empty($type)): ?>
                        Nr dhomave: <b><?= $rooms; ?></b>, Statusi: <b> <?=$status; ?></b> , Tipi:<b> <?=$name['name'] ?></b>
                <?php endif; ?>
                <?php if(!empty($rooms) && !empty($status) && empty($type)): ?>
                        Nr dhomave: <b><?= $rooms; ?></b>, Statusi:<b> <?=$status; ?></b> 
                <?php endif; ?>
                <?php if(!empty($rooms) && empty($status) && !empty($type)): ?>
                        Nr dhomave: <b><?= $rooms; ?></b>, Tipi: <b><?=$name['name']; ?> </b>
                <?php endif; ?>
                <?php if(empty($rooms) && !empty($status) && !empty($type)): ?>
                        Statusi: <b><?= $status; ?></b>, Tipi:<b> <?=$name['name']; ?> </b>
                <?php endif; ?>
                <?php if(!empty($rooms) && empty($status) && empty($type)): ?>
                        Nr dhomave: <b><?= $rooms; ?> </b>
                <?php endif; ?>
                <?php if(empty($rooms) && !empty($status) && empty($type)): ?>
                        Statusi: <b><?= $status; ?></b>
                <?php endif; ?>
                <?php if(empty($rooms) && empty($status) && !empty($type)): ?>
                       Tipi: <b><?= $name['name']; ?> </b>
                <?php endif; ?>
            
            </p>
        <?php  endif; ?>

        <?php if(count($residences)==0): ?>
            <h2 class="text-center">
                Nuk ka Residenca me te dhenat e kerkuara!
            </h2>
        <?php endif; ?>
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
                                <button type="submit" class="btn btn-outline-success add-review-btn" data-bs-toggle="modal" data-bs-target="#addReviewModal<?= $residence['id'] ?>" data-residence-id="<?= $residence['id'] ?>">Add a review</button>

                                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true): ?>
                                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$residence['userid']): ?>
                                <!-- <button name="deleteresidence" type="submit" class="btn btn-outline-danger">Delete</button> -->
                                <form action="myresidences" method="POST" class="d-inline">
                                    <a href="myresidences.php?action=edit&id=<?=$residence['id'];?>" class="btn btn-md btn-outline-danger">Edit</a> 
                                </form>

                                <?php endif; endif; ?>

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
        }else{
            $errors[] = 'something went wrong';
        }
    }

?>



<?php include('includes/footer.php'); ?>
<?php include('includes/header.php'); ?>

<?php
$errors = [];

$myresidences = (new CRUD($pdo))->select('residence',[],['userid'=>$_SESSION['user_id']],'','');

$myresidences = $myresidences->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deleteresidence = (new CRUD($pdo))->delete('residence','id',$_GET['id']);

    header('Location:myresidences.php');
}

if(isset($_POST['edit-btn'])){
        $image = $_FILES['image']['name'];

        $tempname = $_FILES['image']['tmp_name'];

    if((!empty($_POST['title'])) && (!empty($_POST['status'])) && (!empty($_POST['neighborhood'])) && (!empty($_POST['city'])) && (!empty($_POST['street'])) && (!empty($_POST['squaremeters'])) && (!empty($_POST['rooms'])) && (!empty($_POST['price'])) && (!empty($_POST['tel'])) && (!empty($_POST['description'])) && (!empty($_POST['type'])) &&  (!empty($_POST['userid']))     ){

        if(!($image != null && isset($_FILES['image']))){
            $updateresidence = (new CRUD($pdo)) -> update('residence',['title','status','neighborhood','street','city','squaremeters','rooms','price', 'tel','description','typeid','userid'],[$_POST['title'],$_POST['status'],$_POST['neighborhood'],$_POST['street'],$_POST['city'],$_POST['squaremeters'],$_POST['rooms'],$_POST['price'],$_POST['tel'],$_POST['description'],$_POST['type'],$_POST['userid']],['id'=>$_POST['id']]);

        }else{
            $image = time(). $_FILES['image']['name'];

            $updateresidence = (new CRUD($pdo)) -> update('residence',['title','status','neighborhood','street','city','squaremeters','rooms','price', 'tel','description','image','typeid','userid'],[$_POST['title'],$_POST['status'],$_POST['neighborhood'],$_POST['street'],$_POST['city'],$_POST['squaremeters'],$_POST['rooms'],$_POST['price'],$_POST['tel'],$_POST['description'],$image,$_POST['type'],$_POST['userid']],['id'=>$_POST['id']]);
            move_uploaded_file($tempname,'assets/images/residences/'.$image);
        }

        

        header('Location:residences.php');


    }else {
        $errors [] = 'something went wrong';
    }

}


?>
<section class="myresidences py-5">
    <div class="container">
    <?php if(count($myresidences) > 0): ?>
        <h2 class="text-center">My Residences (<?= count($myresidences); ?>)</h2>
    
    <div class="row mt-4">
        <table class="table">
            <tr>
                <!-- <th>Id</th> -->
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
           <?php foreach($myresidences as $myresidence): ?>
            <tr>
                <!-- <td><?//= $myresidence['userid'] ?></td> -->
                <td><?= $myresidence['title'] ?></td>
                <td><?= $myresidence['description'] ?></td>
                <td><?= $myresidence['price'] ?>&euro;</td>
                <td><?= $myresidence['city'] ?></td>
                <td>
                    <a href="?action=view&id=<?=$myresidence['id'];?>" class="btn btn-sm btn-success">View Reviews</a> /
                    <a href="?action=delete&id=<?=$myresidence['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a> /
                    <a href="?action=edit&id=<?=$myresidence['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: echo '<h3 class="text-center">0 Residences offered from you! </h3>'; ?>
    </div>
    <?php endif; ?>


    <?php if(isset($_GET['action']) && $_GET['action'] == 'view'):
        
        $getreviews = (new CRUD($pdo))->select('reviews',[],['residence_id'=>$_GET['id']], '', '');
        $getreviews = $getreviews->fetchAll();    
        
        foreach($getreviews as $getreview):
            if($getreview): 
                $residencereview = ((new CRUD($pdo))->select('residence',[],['id'=>$getreview['residence_id']],1,''));
                $residencereview = $residencereview->fetch(); 
    ?>
        
    <div class="col-12 col-md-4">
            
            <div class="card border-0 border-bottom border-primary shadow-sm d-flex flex-column h-100">
                <div class="card-body p-4 p-xxl-5 d-flex flex-column justify-content-between">
                        
                    <h6 class=" mb-5 text-secondary text-end"><?php $createdAt = $getreview['created_at']; $createdAt = date('m/Y',strtotime($createdAt)); echo $createdAt; ?></h6>
                        <figure>
                        <img class="img-fluid rounded rounded-circle mb-4 border border-5 w-50"   loading="lazy" src="./assets/images/residences/<?= $residencereview['image'];?>" alt="">
                        <figcaption>
                            <div class="bsb-ratings text-warning mb-3" data-bsb-star="<?=$getreview['rating']?>" data-bsb-star-off="<?= ($getreview['rating']===5) ? 0 : (5 - $getreview['rating']) ?>"></div>
                            <blockquote class="bsb-blockquote-icon mb-4"><?=$getreview['comment']?></blockquote>
                            <?php
                            $useri = (new CRUD($pdo))->select('users',[],['id'=>$getreview['user_id']],1,''); 
                            $useri = $useri->fetch();
                            // foreach($users as $user){ 
                            //     if($user['id'] == $review['user_id']):
                            ?>
                            <h4 class="mb-2"><?= $useri['name'];?></h4>
                            <h5 class="fs-6 text-secondary mb-0"><?= $useri['email'] ; ?></h5>
                            <?//php endif; } ?>
                        </figcaption>
                        </figure>
                </div>
            </div>
                    <?//php endif; ?>
        </div>

        <?php endif; endforeach; endif; ?>





    <?php if(isset($_GET['action']) && $_GET['action']=='edit'): 
        
            $fillinputs = (new CRUD($pdo))->select('residence',[],['id'=>$_GET['id']],1,'');
            $fillinput = $fillinputs->fetch();

            
        
        ?>
        
    <!-- <div class="container d-flex justify-content-center"> -->
        <div class="residence-form w-50 p-4 shadow rounded bg-light mx-auto my-4">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Modifiko residencen</h3>
            </div>
            
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" name="id" class="form-control" id="id" value="<?= $fillinput['id']; ?>" >
                </div>
                <div class="mb-3">
                    <input type="hidden" name="userid" class="form-control" id="userid" value="<?=$_SESSION['user_id'];?>" >
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="<?=$fillinput['title'];?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Statusi</label>
                    <select name="status" id="status" class="form-control mb-2">
                        <option value="" disabled>Select Status</option>
                        <?php
                            $statusenum = (new CRUD($pdo))->distinctSelect('residence','status');
                            $statusenum = $statusenum->fetchAll();
                            
                            foreach($statusenum as $status):
                        ?>
                        
                        <option value="<?= $status['status']?>"<?php if($fillinput['status']==$status['status']): ?>selected <?php endif; ?>><?= $status['status']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="neighborhood" class="form-label">Neighborhood</label>
                    <input type="text" name="neighborhood" class="form-control" id="neighborhood" value="<?=$fillinput['neighborhood'];?>" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" class="form-control" id="city" value="<?=$fillinput['city'];?>" required>
                </div>
                <div class="mb-3">
                    <label for="street" class="form-label">Street</label>
                    <input type="text" name="street" class="form-control" id="street" value="<?=$fillinput['street'];?>" required>
                </div>
                <div class="mb-3">
                    <label for="squaremeters" class="form-label">SquareMeters</label>
                    <input type="number" name="squaremeters" class="form-control" id="squaremeters" value="<?=$fillinput['squaremeters'];?>" min="1" required>
                </div>                
                <div class="mb-3">
                    <label for="rooms" class="form-label">Rooms</label>
                    <input type="number" name="rooms" class="form-control" id="rooms" value="<?=$fillinput['rooms'];?>" min="1" required>
                </div>                
                <div class="mb-3">
                    <label for="type" class="form-label">Tipi</label>
                    <select name="type" id="type" class="form-control mb-2">
                        <option value="" disabled>Select Type</option>
                        <?php
                            $types = (new CRUD($pdo))->select('type',[],[],'','');
                            $types = $types->fetchAll();
                            
                            foreach($types as $type):
                        ?>
                        <option value="<?=$type['id'];?>" <?php if($fillinput['typeid']==$type['id']): ?>selected <?php endif; ?>><?= $type['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Telephone number</label>
                    <input type="text" name="tel" class="form-control" id="tel" value="<?=$fillinput['tel'];?>" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" id="price" value="<?=$fillinput['price'];?>" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" value="<?=$fillinput['description'];?>" required><?=$fillinput['description'];?></textarea>
                </div>
                <div class="mb-3">
                <input type="file" name="image" /><br><br>
                    <!-- <label for="image" class="form-label d-inline mx-3">Image</label> -->
                    <!-- <input type="file" name="image" class="form-control" id="image" > -->
                    <?php if(!empty($fillinput['image'])) {?>
                    <img class="mx-5" width="500px"  src="./assets/images/residences/<?= $fillinput['image']; ?>"/>
                    <?php } else { echo "<em>There is no image set here</em>"; } ?><br><br>
                    <!-- <img src="./assets/images/residences/<?//= $fillinput['image']; ?>" class="d-block mb-2" height="100px" alt="..."> -->
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" name="fullname" class="form-control bg-light" id="fullname" required readonly value="<?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control bg-light" id="email" required value="<?=$_SESSION['email']; ?>" readonly>
                </div>
                
                <button type="submit" name="edit-btn" class="btn btn-primary w-100">Modifiko</button>
            </form>
        </div>
    <!-- </div> -->
     <?php endif; ?>


    </div>
</section>




<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<?php
$myreviews = (new CRUD($pdo))->select('reviews',[],['user_id'=>$_SESSION['user_id']],'','');

$myreviews = $myreviews->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'deletereview'){
    $deletereview = (new CRUD($pdo))->delete('reviews','id',$_GET['id']);

    header('Location:myresidences.php');
}

if(isset($_POST['edit-review'])){

    if((!empty($_POST['rating'])) && (!empty($_POST['comment']))   ){

        $updatereview = (new CRUD($pdo)) -> update('reviews',['rating','comment'],[$_POST['rating'],$_POST['comment']],['id'=>$_POST['id']]);

        header('Location:residences.php');


    }else {
        $errors [] = 'something went wrong';
    }

}


?>
    <section class="myreviews py-5">
        <div class="container">
            <?php if(count($errors)>0): ?>
                <div class="alert alert-warning">
                <?php foreach($errors as $error):?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                    <?php endforeach;?>
                </div>
                <?php endif; ?>
            <?php if(count($myreviews) > 0): ?>
                <h2 class="text-center"> (<?= count($myreviews); ?>) Reviews nga account im!</h2>
            
                <div class="row mt-4">
                    <table class="table">
                        <tr>
                            <!-- <th>Fullname</th> -->
                            <th>Residence title</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Added at</th>
                            <th>Actions</th>
                        </tr>
                    <?php foreach($myreviews as $review): ?>
                        <tr>
                            <?php //$username = (new CRUD($pdo))->select('users',[],['id'=>$review['user_id']],1,''); 
                               // $username = $username->fetch();
                            ?>
                            <!-- <td><?//= $username['name'] . ' ' . $username['surname']; ?></td> -->
                            <?php $residencetitle = (new CRUD($pdo))->select('residence',[],['id'=>$review['residence_id']],1,''); 
                                $residencetitle = $residencetitle->fetch();
                            ?>
                            <td><?= $residencetitle['title'];?></td>
                            <td><?= $review['rating'] ?></td>
                            <td><?= $review['comment'] ?></td>
                            
                            <td><?= $review['created_at'] ?></td>
                            <td>
                                <a href="?action=deletereview&id=<?=$review['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>/
                                <a href="?action=editreview&id=<?=$review['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: echo '<h2 class="text-center">0 Reviews from you </h2>'; ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_GET['action']) && $_GET['action']=='editreview'): 
        
            $fillinputs = (new CRUD($pdo))->select('reviews',[],['id'=>$_GET['id']],1,'');
            $fillinput = $fillinputs->fetch();

            ?>

<div class="residence-form w-50 p-4 shadow rounded bg-light mx-auto my-4">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Modifiko review e dhene</h3>
            </div>
            
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" name="id" class="form-control" id="id" value="<?= $fillinput['id']; ?>" >
                </div>
                <div class="mb-3">
                    <input type="hidden" name="user_id" class="form-control" id="user_id" value="<?=$_SESSION['user_id'];?>" >
                </div>
                <div class="mb-3">
                    <input type="hidden" name="residence_id" class="form-control" id="residence_id" value="<?=$fillinput['residence_id'];?>" >
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="number" name="rating" class="form-control" id="rating" value="<?=$fillinput['rating'];?>" min="1" max="5" required>
                </div>                 
                
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <input type="text" name="comment" class="form-control" id="comment" value="<?=$fillinput['comment'];?>" required>
                </div>
                
                
                <button type="submit" name="edit-review" class="btn btn-primary w-100">Modifiko</button>
            </form>
        </div>
    <!-- </div> -->
     <?php endif; ?>
        </div>
    </section>

<?php include('includes/footer.php'); ?>
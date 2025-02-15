<?php include('includes/header.php'); ?>

<?php
$errors[] = '';
if(!(isset($_SESSION['logged_in'])) && !($_SESSION['logged_in'] == true)){
    header('Location:login.php');}


$residences = (new CRUD($pdo))->select('residence',[],[],'','');

$residences = $residences->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deleteresidence = (new CRUD($pdo))->delete('residence','id',$_GET['id']);

    header('Location:manageResidences.php');
    exit;
}

if(isset($_POST['edit-btn'])){

    if((!empty($_POST['title'])) && (!empty($_POST['status'])) && (!empty($_POST['neighborhood'])) && (!empty($_POST['city'])) && (!empty($_POST['street'])) && (!empty($_POST['squaremeters'])) && (!empty($_POST['rooms'])) && (!empty($_POST['price'])) && (!empty($_POST['tel'])) && (!empty($_POST['description'])) && (!empty($_POST['type']))){

        $updateresidence = (new CRUD($pdo)) -> update('residence',['title','status','neighborhood','street','city','squaremeters','rooms','price', 'tel','description','typeid'],[$_POST['title'],$_POST['status'],$_POST['neighborhood'],$_POST['street'],$_POST['city'],$_POST['squaremeters'],$_POST['rooms'],$_POST['price'],$_POST['tel'],$_POST['description'],$_POST['type']],['id'=>$_POST['id']]);

        header('Location:manageResidences.php');
        // exit;


    }else {
        $errors [] = 'something went wrong';
    }

}


?>

<?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
    if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): 
?>
    <section class="myresidences py-5">
        <div class="container">
        <?php if(count($residences) > 0): ?>
            <h2 class="text-center">My Residences (<?= count($residences); ?>)</h2>
        
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
            <?php foreach($residences as $residence): ?>
                <tr>
                    <!-- <td><?//= $myresidence['userid'] ?></td> -->
                    <td><?= $residence['title'] ?></td>
                    <td><?= $residence['description'] ?></td>
                    <td><?= $residence['price'] ?>&euro;</td>
                    <td><?= $residence['city'] ?></td>
                    <td>
                        <a href="?action=delete&id=<?=$residence['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a> /
                        <a href="?action=edit&id=<?=$residence['id'];?>" class="btn btn-sm btn-secondary">Edit</a> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: echo '<p>0 residences </p>'; ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['action']) && $_GET['action']=='edit'): 
            
                $fillinputs = (new CRUD($pdo))->select('residence',[],['id'=>$_GET['id']],1,'');
                if($fillinputs):
                    $fillinput = $fillinputs->fetch();
                    $fullname = (new CRUD($pdo))->select('users',['name','surname','email'],['id'=>$fillinput['userid']],1,'');
                    $fullname = $fullname->fetch();

                
            
            ?>
            
        <!-- <div class="container d-flex justify-content-center"> -->
            <div class="residence-form w-50 p-4 shadow rounded bg-light">
                <div class="text-center mb-4">
                    <h3 class="mb-3 text-secondary">Modifiko residencen</h3>
                </div>
                
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="id" class="form-control" id="id" value="<?= $fillinput['id']; ?>" >
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="userid" class="form-control" id="userid" value="<?=$fillinput['userid'];?>" >
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
                        <input type="text" name="squaremeters" class="form-control" id="squaremeters" min="1" value="<?=$fillinput['squaremeters'];?>" required>
                    </div>                
                    <div class="mb-3">
                        <label for="rooms" class="form-label">Rooms</label>
                        <input type="number" name="rooms" class="form-control" min="1" id="rooms" value="<?=$fillinput['rooms'];?>" required>
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
                        <input type="text" name="price" class="form-control" min="1" id="price" value="<?=$fillinput['price'];?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" value="<?=$fillinput['description'];?>" required><?=$fillinput['description'];?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="image" >
                    </div>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" name="fullname" class="form-control bg-light" id="fullname" required readonly value="<?php echo $fullname['name'] . ' ' . $fullname['surname']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control bg-light" id="email" required value="<?=$fullname['email']; ?>" readonly>
                    </div>
                    
                    <button type="submit" name="edit-btn" class="btn btn-primary w-100">Modifiko</button>
                </form>
            </div>
        <!-- </div> -->
        <?php endif;endif; ?>


        </div>
    </section>


<?php else: header('location:index.php');?>
<?php endif; endif; ?>





<?php include('includes/footer.php'); ?>
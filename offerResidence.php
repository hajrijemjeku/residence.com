<?php include('includes/header.php'); ?>
<?php

$errors = [];
?>
<?php
if(!(isset($_SESSION['logged_in'])) && !($_SESSION['logged_in'] == true)){
    header('Location:login.php');}
?>

<?php
//if((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true)): 

if(isset($_POST['register-btn'])){

    $image = time(). $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    

    if((!empty($_POST['title'])) && (!empty($_POST['status'])) && (!empty($_POST['neighborhood'])) && (!empty($_POST['city'])) && (!empty($_POST['street'])) && (!empty($_POST['squaremeters'])) && (!empty($_POST['rooms'])) && (!empty($_POST['price'])) && (!empty($_POST['tel'])) && (!empty($_POST['description'])) && (!empty($_POST['type'])) &&  (!empty($_POST['userid']))     ){


        if(!(empty($image))){
            $insertresidence = (new CRUD($pdo)) -> insert('residence',['title','status','neighborhood','city','street','squaremeters','rooms','price', 'tel','description','image','typeid','userid'],[$_POST['title'],$_POST['status'],$_POST['neighborhood'],$_POST['city'],$_POST['street'],$_POST['squaremeters'],$_POST['rooms'],$_POST['price'],$_POST['tel'],$_POST['description'],$image,$_POST['type'],$_POST['userid']]);
            move_uploaded_file($tempname,'assets/images/residences/'.$image);

        }else{
            $insertresidence = (new CRUD($pdo)) -> insert('residence',['title','status','neighborhood','city','street','squaremeters','rooms','price', 'tel','description','typeid','userid'],[$_POST['title'],$_POST['status'],$_POST['neighborhood'],$_POST['city'],$_POST['street'],$_POST['squaremeters'],$_POST['rooms'],$_POST['price'],$_POST['tel'],$_POST['description'],$_POST['type'],$_POST['userid']]);
        }



        

        header('Location:residences.php');


    }else {
        $errors [] = 'Please fill all input fields!';
    }
}
?>


<section class="offer-residence my-5">
    <div class="container d-flex justify-content-center">
        <div class="residence-form w-50 p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <h3 class="mb-3 text-secondary">Shto nje residence</h3>
            </div>
            <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach($errors as $error): ?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
            <?php endif; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <div class="mb-3">
                    <input type="hidden" name="userid"  class="form-control" id="userid" value="<?=$_SESSION['user_id']?>" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" required>
                </div>
                <div class="mb-3">
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
                <div class="mb-3">
                    <label for="neighborhood" class="form-label">Neighborhood</label>
                    <input type="text" name="neighborhood" class="form-control" id="neighborhood" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" class="form-control" id="city" required>
                </div>
                <div class="mb-3">
                    <label for="street" class="form-label">Street</label>
                    <input type="text" name="street" class="form-control" id="street" required>
                </div>
                <div class="mb-3">
                    <label for="squaremeters" class="form-label">SquareMeters</label>
                    <input type="number" name="squaremeters" class="form-control" id="squaremeters" min="1" required>
                </div>                
                <div class="mb-3">
                    <label for="rooms" class="form-label">Rooms</label>
                    <input type="number" name="rooms" class="form-control" id="rooms" required min="1">
                </div>                
                <div class="mb-3">
                    <label for="type" class="form-label">Tipi</label>
                    <select name="type" id="type" class="form-control mb-2">
                        <option value="">Select Type</option>
                        <?php
                            $types = (new CRUD($pdo))->select('type',[],[],'','');
                            $types = $types->fetchAll();
                            
                            foreach($types as $type):
                        ?>
                        <option value="<?= $type['id']; ?>" required><?= $type['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Telephone number</label>
                    <input type="text" name="tel" class="form-control" id="tel" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" id="price" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" id="image" >
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" name="fullname" class="form-control bg-light" id="fullname" required readonly value="<?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control bg-light" id="email" required value="<?=$_SESSION['email']; ?>" readonly>
                </div>
                
                <button type="submit" name="register-btn" class="btn btn-primary w-100">Ruaj Residencen</button>
            </form>
        </div>
    </div>
</section>



<?php include('includes/footer.php'); ?>
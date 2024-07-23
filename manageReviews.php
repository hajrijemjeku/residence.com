<?php include('includes/header.php'); ?>

<?php
$errors = [];
if(!(isset($_SESSION['logged_in'])) && !($_SESSION['logged_in'] == true)){
    header('Location:login.php');}


$reviews = (new CRUD($pdo))->select('reviews',[],[],'','');

$reviews = $reviews->fetchAll();

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $deletereview = (new CRUD($pdo))->delete('reviews','id',$_GET['id']);

    header('Location:manageReviews.php');
    exit;
}

?>
<?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
    if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): 
?>
    <section class="myresidences py-5">
        <div class="container">
            <?php if(count($errors)>0): ?>
                <div class="alert alert-warning">
                <?php foreach($errors as $error):?>
                    <p class="p-0 m-0"><?= $error; ?></p>
                    <?php endforeach;?>
                </div>
                <?php endif; ?>
            <?php if(count($reviews) > 0): ?>
                <h2 class="text-center">Reviews (<?= count($reviews); ?>)</h2>
            
                <div class="row mt-4">
                    <table class="table">
                        <tr>
                            <th>Fullname</th>
                            <th>Residence title</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                    <?php foreach($reviews as $review): ?>
                        <tr>
                            <?php $username = (new CRUD($pdo))->select('users',[],['id'=>$review['user_id']],1,''); 
                                $username = $username->fetch();
                            ?>
                            <td><?= $username['name'] . ' ' . $username['surname']; ?></td>
                            <?php $residencetitle = (new CRUD($pdo))->select('residence',[],['id'=>$review['residence_id']],1,''); 
                                $residencetitle = $residencetitle->fetch();
                            ?>
                            <td><?= $residencetitle['title'];?></td>
                            <td><?= $review['rating'] ?></td>
                            <td><?= $review['comment'] ?></td>
                            
                            <td><?= $review['created_at'] ?></td>
                            <td>
                                <a href="?action=delete&id=<?=$review['id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: echo '<p>0 reviews </p>'; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php else: header('location:index.php');?>
<?php endif; endif; ?>



<?php include('includes/footer.php'); ?>
<?php
require_once 'db.php';
$title = "Users List";
include_once 'inc/header.php';
$msg = $_GET['message'] ?? '';
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$skip = ($page - 1) * $limit;
$totalRecords = $collection->countDocuments();
$totalPages = (int) ceil($totalRecords / $limit);
$users = $collection->find(
    [],
    [
        'skip' => $skip,
        'limit' => $limit,
        'sort' => ['_id' => 1]
    ]
);
?>
<section class="container py-5">
    <div class="my-2 p-3 d-flex justify-content-between">
        <h3>All Users</h3>
        <a class="btn btn-md btn-primary" href="newUser.php"> New User</a>
    </div>
<?php if($msg == 1) { ?>    
<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
    User Inserted Successfully..!
    
</div>
<?php } ?>
<?php if($msg == 3){ ?>   
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    User Deleted Successfully..!
    
</div>
<?php } ?>
<?php if($msg == 2) { ?>   
<div class="alert alert-info alert-dismissible fade show" role="alert">
  User Updated Successfully..!
  
</div>
<?php } ?>
<table border="1" class="table table-hover table-bordered">
<thead>
<tr class="text-center">
    <th>ID</th>
    <th>Photo</th>
    <th>Name</th>
    <th>Email</th>
    <th>View</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>
</thead>
<tbody>
<?php 
$i=1;
foreach ($users as $user):
 ?>
<tr class="text-center">
    <td><?= $i ?? '' ?></td>
    <td class="text-center"><img src="<?= $user['image_path'] ?? '' ?>" style="width:50px;height:50px;" /></td>
    <td><?= $user['name'] ?? '' ?></td>
    <td><?= $user['email'] ?? '' ?></td>
    <td><a class="btn btn-md btn-primary" href="viewUser.php?id=<?= $user['_id'] ?>">View</a></td>
    <td><a class="btn btn-md btn-success" href="updateUser.php?id=<?= $user['_id'] ?>">Edit</a></td>
    <td>        
        <form method="post" action="deleteUser.php" style="display:inline">
            <input type="hidden" name="id"
                value="<?= $user['_id'] ?>">
                <input type="hidden" name="image_path"
                value="<?= $user['image_path'] ?>">
            <button class="btn btn-md btn-danger" type="submit"
                onclick="return confirm('Delete this User?')">
                Delete
            </button>
        </form>
    </td>
</tr>
<?php 
$i++;
endforeach; 
?>
</tbody>
</table>
<div class="d-felx justify-content-center align-items-center">
    <ul class="pagination  justify-content-center">
        <?php
        if ($page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
        }
        else{
            echo '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
            }
        }
        if ($page < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page='.($page + 1).'">Next</a>';
        }
        else{
            echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a>';
        }
        ?>
    </ul>  
</div>
</section>

<?php include_once 'inc/footer.php'; ?>

<?php
require_once 'db.php';
$id = $_GET['id'] ?? '';
try {
    $objectId = new MongoDB\BSON\ObjectId($id);
} catch (Throwable $e) {
    http_response_code(400);
    exit('Invalid student ID.');
}
$student = $collection->findOne(['_id' => $objectId]);
$title = "View User";
 include_once "inc/header.php";
?>
<section class="container py-5 w-25 mx-auto">
<div class="card mb-3">
  <img src="<?= $student['image_path'] ?? '' ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <ul class="list-group p-0">
        <li class="list-group-item"> <b>Name</b> : <?= $student['name'] ?? '' ?></li>
        <li class="list-group-item"> <b>Email</b> : <?= $student['email'] ?? '' ?></li>
    </ul>
  </div>
</div>
<div class="my-2 d-flex justify-content-start gap-3">
    <a class="btn btn-danger" href="index.php">Back</a>
</div>  
</section>

<?php include_once "inc/footer.php"; ?>
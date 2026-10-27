
<?php
require_once 'db.php';

$id = $_GET['id'] ?? $_POST['id'] ?? '';

try {
    $objectId = new MongoDB\BSON\ObjectId($id);
} catch (Throwable $e) {
    http_response_code(400);
    exit('Invalid student ID.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $uploadDir = __DIR__ . '/uploads/';
    // $fileName = "";
    // if (isset($_FILES['photoUpload']) ) {
    //     // Validate file type (only images)
    //     $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    //     $fileType = mime_content_type($_FILES['photoUpload']['tmp_name']);
    //     if (!in_array($fileType, $allowedTypes)) {
    //         echo "Error: Only JPG, PNG, and GIF files are allowed.";
    //         exit;
    //     }
    
    //     $fileName = $uploadDir.trim($_POST['imagePath'] ?? '');
    //     if (file_exists($fileName) && isset($_FILES['photoUpload']) ) 
    //     {
    //         unlink($fileName);
    //     }
    //     if (!is_dir($uploadDir)) {
    //         mkdir($uploadDir, 0755, true);
    //     }
    //     $fileName = uniqid() . "_" . basename($_FILES['photoUpload']['name']);
    //     $filePath = $uploadDir . $fileName;
    //     if (!move_uploaded_file($_FILES['photoUpload']['tmp_name'], $filePath)) {
    //         echo "Error: Failed to move uploaded file.";
    //         exit;
    //     }
    // }
   
    // $relativePath = 'uploads/' . $fileName;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $collection->updateOne(
        ['_id' => $objectId],
        ['$set' => [
            'name' => $name,
            'email' => $email,           
        ]]
    );
    header('Location: index.php?message=2');
    exit;
}

$user = $collection->findOne(['_id' => $objectId]);

$title = "Edit User";

 include_once "inc/header.php";
?>
<section class="container py-5 w-25 mx-auto">
<h3>Edit User</h3>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="imagePath" value="<?= $user['image_path'] ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input name="name" id="name" class="form-control" required value="<?= $user['name'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control"  name="email" required value="<?= $user['email'] ?? '' ?>">
    </div>
     <!-- <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repalce Photo :</label>
            <input type="file" class="form-control" accept="image/*" name="photoUpload" id="photoUpload"/>
    </div>  -->
    <div class="mb-3">
            <img src="<?= $user['image_path'] ?? '' ?>" class="img-thumbnail" alt="...">
    </div> 
    
    <div class="my-2 d-flex justify-content-start gap-3">
        <button type="submit" class="btn btn-primary mr-5" >Update User</button>
        <a class="btn btn-danger" href="index.php">Back</a>
    </div>   
</form>
</section>

<?php include_once "inc/footer.php"; ?>
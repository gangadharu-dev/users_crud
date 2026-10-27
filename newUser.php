<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['photoUpload']) || $_FILES['photoUpload']['error'] !== UPLOAD_ERR_OK) {
        echo "Error: No file uploaded or upload failed.";
        exit;
    }
    // Validate file type (only images)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['photoUpload']['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        echo "Error: Only JPG, PNG, and GIF files are allowed.";
        exit;
    }
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $fileName = uniqid() . "_" . basename($_FILES['photoUpload']['name']);
    $filePath = $uploadDir . $fileName;
    if (!move_uploaded_file($_FILES['photoUpload']['tmp_name'], $filePath)) {
        echo "Error: Failed to move uploaded file.";
        exit;
    }
    $relativePath = 'uploads/' . $fileName;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $collection->insertOne([
        'name' => $name,
        'email' => $email,
        'image_path' => $relativePath,
    ]);
    header('Location: index.php?message=1');
}
$title = "New User";
 include_once "inc/header.php";
?>
<section class="container py-5 w-25 mx-auto">
    <h3>Add New User</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name : </label>
            <input name="name" class="form-control" id="name" aria-describedby="validationNameFeedback" placeholder="Name" required>
            <div id="validationNameFeedback" class="invalid-feedback">
                Please choose a username.
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email : </label>
            <input name="email" class="form-control" type="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label"> Photo :</label>
            <input type="file" class="form-control" accept="image/*" name="photoUpload" id="photoUpload" required/>
        </div>  
        <div class="my-2 d-flex justify-content-start gap-3">
            <button type="submit" class="btn btn-primary mr-5" >Add User</button>
            <a class="btn btn-danger" href="index.php">Back</a>
        </div>
    </form>
    
</section>

<?php include_once "inc/footer.php"; ?>
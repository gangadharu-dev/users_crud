<?php
require_once 'db.php';
$id = $_POST['id'] ?? '';
$uploadDir = __DIR__ . '/';
try {
    $objectId = new MongoDB\BSON\ObjectId($id);
} catch (Throwable $e) {
    http_response_code(400);
    exit('Invalid User ID.');
}
$collection->deleteOne(['_id' => $objectId]);
$fileName = $uploadDir.trim($_POST['image_path'] ?? '');
if (file_exists($fileName)) 
{
    unlink($fileName);
}
header('Location: index.php?message=3');
exit;
?>
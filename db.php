<?php
    require 'vendor/autoload.php'; 
    try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->demo->users;
} catch (Throwable $e) {
    exit("MongoDB connection failed: " .
        htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>

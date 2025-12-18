<?php
header('Content-Type: application/json');

$uploadDir = './assets/ekip/';

if (!isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => 'Dosya gönderilmedi']);
    exit;
}

$file = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'error' => 'Geçersiz dosya tipi']);
    exit;
}

if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'error' => 'Dosya çok büyük (max 5MB)']);
    exit;
}

$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('player_') . '.' . $extension;
$destination = $uploadDir . $filename;

if (move_uploaded_file($file['tmp_name'], $destination)) {
    echo json_encode(['success' => true, 'path' => $destination]);
} else {
    echo json_encode(['success' => false, 'error' => 'Dosya yüklenemedi']);
}

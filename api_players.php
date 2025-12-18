<?php
header('Content-Type: application/json');
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM players ORDER BY created_at DESC');
    $players = $stmt->fetchAll();
    echo json_encode($players);
}

elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || !isset($data['image'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name and image are required']);
        exit;
    }
    
    $id = generateUUID();
    $name = $data['name'];
    $image = $data['image'];
    
    $stmt = $db->prepare('INSERT INTO players (id, name, image) VALUES (:id, :name, :image)');
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $id, 'name' => $name, 'image' => $image]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to add player']);
    }
}

elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID is required']);
        exit;
    }
    
    $id = $data['id'];
    $stmt = $db->prepare('DELETE FROM players WHERE id = :id');
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete player']);
    }
}

$db = null;

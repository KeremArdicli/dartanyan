<?php
header('Content-Type: application/json');
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['game_type']) || !isset($data['game_data']) || !isset($data['participants'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    $gameId = generateUUID();
    $gameType = $data['game_type'];
    $gameData = json_encode($data['game_data']);
    $winnerId = isset($data['winner_id']) ? $data['winner_id'] : null;
    
    $stmt = $db->prepare('INSERT INTO game_results (id, game_type, game_data, winner_id) VALUES (:id, :type, :data, :winner)');
    $stmt->bindParam(':id', $gameId);
    $stmt->bindParam(':type', $gameType);
    $stmt->bindParam(':data', $gameData);
    $stmt->bindParam(':winner', $winnerId);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save game result']);
        exit;
    }
    
    foreach ($data['participants'] as $participant) {
        $stmt = $db->prepare('INSERT INTO game_participants (game_id, player_id, player_name, final_score, placement) VALUES (:game_id, :player_id, :player_name, :final_score, :placement)');
        $stmt->bindParam(':game_id', $gameId);
        $stmt->bindParam(':player_id', $participant['player_id']);
        $stmt->bindParam(':player_name', $participant['player_name']);
        $stmt->bindParam(':final_score', $participant['final_score']);
        $placement = isset($participant['placement']) ? $participant['placement'] : null;
        $stmt->bindParam(':placement', $placement);
        $stmt->execute();
    }
    
    echo json_encode(['success' => true, 'game_id' => $gameId]);
}

elseif ($method === 'GET') {
    $gameType = isset($_GET['game_type']) ? $_GET['game_type'] : null;
    
    $query = 'SELECT gr.*, GROUP_CONCAT(gp.player_name) as players FROM game_results gr 
              LEFT JOIN game_participants gp ON gr.id = gp.game_id';
    
    if ($gameType) {
        $query .= ' WHERE gr.game_type = :game_type';
    }
    
    $query .= ' GROUP BY gr.id ORDER BY gr.created_at DESC LIMIT 50';
    
    $stmt = $db->prepare($query);
    if ($gameType) {
        $stmt->bindParam(':game_type', $gameType);
    }
    
    $stmt->execute();
    $games = $stmt->fetchAll();
    
    echo json_encode($games);
}

$db = null;

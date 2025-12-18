<?php
require_once 'db.php';

$db = getDB();

$db->exec('CREATE TABLE IF NOT EXISTS players (
    id TEXT PRIMARY KEY,
    name TEXT NOT NULL,
    image TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

$db->exec('CREATE TABLE IF NOT EXISTS game_results (
    id TEXT PRIMARY KEY,
    game_type TEXT NOT NULL,
    game_data TEXT NOT NULL,
    winner_id TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (winner_id) REFERENCES players(id)
)');

$db->exec('CREATE TABLE IF NOT EXISTS game_participants (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    game_id TEXT NOT NULL,
    player_id TEXT NOT NULL,
    player_name TEXT NOT NULL,
    final_score INTEGER,
    placement INTEGER,
    FOREIGN KEY (game_id) REFERENCES game_results(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
)');

echo "Database initialized successfully!";
$db = null;

function getPlayers() {
    const data = localStorage.getItem('dart_players');
    return data ? JSON.parse(data) : [];
}

function savePlayers(players) {
    localStorage.setItem('dart_players', JSON.stringify(players));
}

function addPlayer(name, image) {
    const players = getPlayers();
    const player = {
        id: Date.now().toString(),
        name: name,
        image: image || './assets/ekip/USER.jpg'
    };
    players.push(player);
    savePlayers(players);
    return player;
}

function removePlayer(id) {
    const players = getPlayers();
    const filtered = players.filter(p => p.id !== id);
    savePlayers(filtered);
}

function getPlayer(id) {
    const players = getPlayers();
    return players.find(p => p.id === id);
}

function getGame(gameId) {
    const data = localStorage.getItem('dart_game_' + gameId);
    return data ? JSON.parse(data) : null;
}

function saveGame(gameId, gameData) {
    localStorage.setItem('dart_game_' + gameId, JSON.stringify(gameData));
}

function deleteGame(gameId) {
    localStorage.removeItem('dart_game_' + gameId);
}

function createGame(type, settings) {
    const gameId = Date.now().toString();
    const game = {
        id: gameId,
        type: type,
        settings: settings,
        created: new Date().toISOString(),
        status: 'active'
    };
    saveGame(gameId, game);
    return gameId;
}

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./index.css">
<link rel="stylesheet" href="./styles.css">
<link rel="icon" type="image/svg+xml" href="./favicon.svg">
<title>Around the Clock - Dartanyan</title>
</head>
<body class="bg-yellow-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <a href="index.php" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Ana Sayfa</a>
            <h1 class="text-3xl font-bold">🕐 Around the Clock</h1>
            <button onclick="toggleFullscreen()" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold text-xl" title="Tam Ekran">
                <span id="fullscreenIcon">⛶</span>
            </button>
        </div>

        <div id="setupScreen" class="max-w-2xl mx-auto">
            <div class="neobrutalism-card bg-white p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Oyuncu Seçimi</h2>
                <form id="setupForm" class="space-y-4">
                    <div id="playerSelects">
                        <div class="mb-3">
                            <label class="block font-bold mb-2">Oyuncu 1</label>
                            <select id="player1" required class="neobrutalism-input w-full px-4 py-2 rounded">
                                <option value="">-- Oyuncu Seç --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="block font-bold mb-2">Oyuncu 2</label>
                            <select id="player2" required class="neobrutalism-input w-full px-4 py-2 rounded">
                                <option value="">-- Oyuncu Seç --</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" onclick="addPlayer()" class="neobrutalism-btn bg-blue-400 px-4 py-2 rounded font-bold w-full">
                        + Oyuncu Ekle
                    </button>

                    <button type="submit" class="neobrutalism-btn bg-green-400 px-6 py-3 rounded font-bold w-full">
                        Oyunu Başlat
                    </button>
                </form>
            </div>
        </div>

        <div id="gameScreen" class="hidden">
            <div class="grid lg:grid-cols-2 gap-4">
                <div class="neobrutalism-card bg-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4 text-center">
                        Sıra: <span id="currentPlayerName"></span>
                    </h3>
                    <div class="flex justify-center mb-4">
                        <img id="currentPlayerImage" class="w-24 h-24 rounded-full object-cover border-3 border-black">
                    </div>

                    <div class="mb-4">
                        <p class="text-center text-lg mb-2">Hedef Sayı: <span id="targetNumber" class="font-bold text-4xl"></span></p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <button onclick="hit()" class="neobrutalism-btn bg-green-400 px-6 py-4 rounded font-bold text-lg">
                            ✓ Vurdu
                        </button>
                        <button onclick="miss()" class="neobrutalism-btn bg-red-400 px-6 py-4 rounded font-bold text-lg">
                            ✗ Kaçırdı
                        </button>
                    </div>

                    <button onclick="endGame()" class="neobrutalism-btn bg-orange-400 px-6 py-3 rounded font-bold w-full">
                        Oyunu Bitir
                    </button>
                </div>

                <div class="neobrutalism-card bg-white p-6 rounded-lg">
                    <h2 class="text-2xl font-bold mb-4 text-center">Sıralama</h2>
                    <div id="standings" class="space-y-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let game = null;
        let playerCount = 2;

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log('Tam ekran hatası:', err);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        document.addEventListener('fullscreenchange', function() {
            const icon = document.getElementById('fullscreenIcon');
            if (document.fullscreenElement) {
                icon.textContent = '⛶';
            } else {
                icon.textContent = '⛶';
            }
        });

        async function loadPlayerOptions() {
            try {
                const response = await fetch('api_players.php');
                const players = await response.json();
                
                for (let i = 1; i <= playerCount; i++) {
                    const select = document.getElementById(`player${i}`);
                    if (select) {
                        select.innerHTML = '<option value="">-- Oyuncu Seç --</option>';
                        players.forEach(player => {
                            const option = document.createElement('option');
                            option.value = player.id;
                            option.textContent = player.name;
                            select.appendChild(option);
                        });
                    }
                }
            } catch (error) {
                console.error('Oyuncular yüklenemedi:', error);
            }
        }

        function addPlayer() {
            playerCount++;
            const container = document.getElementById('playerSelects');
            const div = document.createElement('div');
            div.className = 'mb-3';
            div.innerHTML = `
                <label class="block font-bold mb-2">Oyuncu ${playerCount}</label>
                <select id="player${playerCount}" required class="neobrutalism-input w-full px-4 py-2 rounded">
                    <option value="">-- Oyuncu Seç --</option>
                </select>
            `;
            container.appendChild(div);
            loadPlayerOptions();
        }

        document.getElementById('setupForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const selectedPlayers = [];
            for (let i = 1; i <= playerCount; i++) {
                const playerId = document.getElementById(`player${i}`).value;
                if (!playerId) {
                    alert(`Lütfen Oyuncu ${i} seçin`);
                    return;
                }
                if (selectedPlayers.includes(playerId)) {
                    alert('Aynı oyuncuyu birden fazla kez seçemezsiniz');
                    return;
                }
                selectedPlayers.push(playerId);
            }
            
            try {
                const response = await fetch('api_players.php');
                const players = await response.json();
                
                game = {
                    players: selectedPlayers.map(id => {
                        const p = players.find(pl => pl.id === id);
                        return {
                            id: p.id,
                            name: p.name,
                            image: p.image,
                            currentNumber: 1,
                            time: 0,
                            finished: false,
                            startTime: null
                        };
                    }),
                    currentPlayerIndex: 0,
                    gameStartTime: Date.now()
                };
                
                game.players[0].startTime = Date.now();
                startGame();
            } catch (error) {
                alert('Oyuncular yüklenirken hata oluştu');
            }
        });

        function startGame() {
            document.getElementById('setupScreen').classList.add('hidden');
            document.getElementById('gameScreen').classList.remove('hidden');
            updateDisplay();
        }

        function updateDisplay() {
            const activePlayers = game.players.filter(p => !p.finished);
            
            if (activePlayers.length === 0) {
                saveGameResult();
                return;
            }
            
            while (game.players[game.currentPlayerIndex].finished) {
                game.currentPlayerIndex = (game.currentPlayerIndex + 1) % game.players.length;
            }
            
            const current = game.players[game.currentPlayerIndex];
            document.getElementById('currentPlayerName').textContent = current.name;
            document.getElementById('currentPlayerImage').src = current.image;
            document.getElementById('targetNumber').textContent = current.currentNumber;
            
            updateStandings();
        }

        function updateStandings() {
            const standings = document.getElementById('standings');
            const sortedPlayers = [...game.players].sort((a, b) => {
                if (a.finished && !b.finished) return -1;
                if (!a.finished && b.finished) return 1;
                if (a.finished && b.finished) return a.time - b.time;
                return b.currentNumber - a.currentNumber;
            });
            
            standings.innerHTML = sortedPlayers.map((p, idx) => {
                let bgColor = 'bg-white';
                if (p.finished) {
                    if (idx === 0) bgColor = 'bg-green-400';
                    else bgColor = 'bg-blue-400';
                } else if (p.id === game.players[game.currentPlayerIndex].id) {
                    bgColor = 'bg-yellow-400';
                }
                
                return `
                    <div class="neobrutalism-card ${bgColor} p-3 rounded flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="${p.image}" class="w-12 h-12 rounded-full object-cover border-2 border-black">
                            <span class="font-bold">${p.name}</span>
                        </div>
                        <div class="text-right">
                            ${p.finished ? 
                                `<p class="font-bold">Tamamlandı!</p><p class="text-sm">${(p.time / 1000).toFixed(1)}s</p>` :
                                `<p class="font-bold">Sayı: ${p.currentNumber}/20</p>`
                            }
                        </div>
                    </div>
                `;
            }).join('');
        }

        function hit() {
            const current = game.players[game.currentPlayerIndex];
            current.currentNumber++;
            
            if (current.currentNumber > 20) {
                current.finished = true;
                current.time = Date.now() - current.startTime;
                
                const nextIndex = (game.currentPlayerIndex + 1) % game.players.length;
                if (!game.players[nextIndex].finished && !game.players[nextIndex].startTime) {
                    game.players[nextIndex].startTime = Date.now();
                }
            }
            
            game.currentPlayerIndex = (game.currentPlayerIndex + 1) % game.players.length;
            updateDisplay();
        }

        function miss() {
            game.currentPlayerIndex = (game.currentPlayerIndex + 1) % game.players.length;
            updateDisplay();
        }

        async function saveGameResult() {
            try {
                const sortedPlayers = [...game.players].sort((a, b) => a.time - b.time);
                const winner = sortedPlayers[0];
                
                await fetch('api_game_result.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        game_type: 'around-the-clock',
                        game_data: {
                            winner_time: (winner.time / 1000).toFixed(2) + 's'
                        },
                        winner_id: winner.id,
                        participants: sortedPlayers.map((p, idx) => ({
                            player_id: p.id,
                            player_name: p.name,
                            final_score: Math.round(p.time / 1000),
                            placement: idx + 1
                        }))
                    })
                });
                
                alert(`🎉 ${winner.name} kazandı! (${(winner.time / 1000).toFixed(1)} saniye)`);
                endGameWithoutConfirm();
            } catch (error) {
                console.error('Sonuç kaydedilemedi:', error);
                endGameWithoutConfirm();
            }
        }

        function endGameWithoutConfirm() {
            game = null;
            playerCount = 2;
            document.getElementById('setupScreen').classList.remove('hidden');
            document.getElementById('gameScreen').classList.add('hidden');
            document.getElementById('setupForm').reset();
            
            const container = document.getElementById('playerSelects');
            container.innerHTML = `
                <div class="mb-3">
                    <label class="block font-bold mb-2">Oyuncu 1</label>
                    <select id="player1" required class="neobrutalism-input w-full px-4 py-2 rounded">
                        <option value="">-- Oyuncu Seç --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block font-bold mb-2">Oyuncu 2</label>
                    <select id="player2" required class="neobrutalism-input w-full px-4 py-2 rounded">
                        <option value="">-- Oyuncu Seç --</option>
                    </select>
                </div>
            `;
            
            loadPlayerOptions();
        }

        function endGame() {
            if (confirm('Oyunu bitirmek istediğinize emin misiniz?')) {
                endGameWithoutConfirm();
            }
        }

        loadPlayerOptions();
    </script>
</body>
</html>

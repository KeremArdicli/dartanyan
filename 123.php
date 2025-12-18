<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./index.css">
<link rel="stylesheet" href="./styles.css">
<link rel="icon" type="image/svg+xml" href="./favicon.svg">
<title>1-2-3 - Dartanyan</title>
</head>
<body class="bg-yellow-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <a href="index.php" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Ana Sayfa</a>
            <h1 class="text-3xl font-bold">🔢 1-2-3</h1>
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
                <div>
                    <div class="neobrutalism-card bg-white p-6 rounded-lg mb-4">
                        <h2 class="text-2xl font-bold mb-4 text-center">Sıralama</h2>
                        <div id="standings" class="space-y-2"></div>
                    </div>

                    <div class="neobrutalism-card bg-white p-6 rounded-lg">
                        <h3 class="text-xl font-bold mb-4 text-center">
                            Sıra: <span id="currentPlayerName"></span>
                        </h3>
                        <div class="flex justify-center mb-4">
                            <img id="currentPlayerImage" class="w-24 h-24 rounded-full object-cover border-3 border-black">
                        </div>

                        <div class="mb-4">
                            <p class="text-center text-lg mb-2">Hedef Sayı: <span id="targetNumber" class="font-bold text-3xl"></span></p>
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <button onclick="hit()" class="neobrutalism-btn bg-green-400 px-6 py-4 rounded font-bold text-lg">
                                ✓ Vurdu
                            </button>
                            <button onclick="miss()" class="neobrutalism-btn bg-red-400 px-6 py-4 rounded font-bold text-lg">
                                ✗ Kaçırdı
                            </button>
                            <button onclick="endGame()" class="neobrutalism-btn bg-orange-400 px-6 py-4 rounded font-bold text-lg">
                                Bitir
                            </button>
                        </div>
                    </div>
                </div>

                <div class="neobrutalism-card bg-white p-4 rounded-lg">
                    <h3 class="text-xl font-bold mb-3">Tur Geçmişi</h3>
                    <div id="history" class="space-y-2 max-h-96 overflow-y-auto"></div>
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
                        const p = players.find(player => player.id === id);
                        return {
                            id: p.id,
                            name: p.name,
                            image: p.image,
                            currentNumber: 1,
                            lives: 3,
                            out: false
                        };
                    }),
                    currentPlayerIndex: 0,
                    history: []
                };
                
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
            const activePlayers = game.players.filter(p => !p.out);
            if (activePlayers.length === 1) {
                alert(`🎉 ${activePlayers[0].name} kazandı!`);
                saveGameResult();
                return;
            }
            
            if (activePlayers.length === 0) {
                alert('Tüm oyuncular elendi!');
                endGameWithoutConfirm();
                return;
            }
            
            while (game.players[game.currentPlayerIndex].out) {
                game.currentPlayerIndex = (game.currentPlayerIndex + 1) % game.players.length;
            }
            
            const current = game.players[game.currentPlayerIndex];
            document.getElementById('currentPlayerName').textContent = current.name;
            document.getElementById('currentPlayerImage').src = current.image;
            document.getElementById('targetNumber').textContent = current.currentNumber;
            
            updateStandings();
            updateHistory();
        }

        function updateStandings() {
            const standings = document.getElementById('standings');
            const sortedPlayers = [...game.players].sort((a, b) => {
                if (a.out && !b.out) return 1;
                if (!a.out && b.out) return -1;
                if (a.currentNumber !== b.currentNumber) return b.currentNumber - a.currentNumber;
                return b.lives - a.lives;
            });
            
            standings.innerHTML = sortedPlayers.map((p, idx) => {
                let bgColor = 'bg-white';
                if (idx === 0 && !p.out) bgColor = 'bg-green-400';
                else if (p.out) bgColor = 'bg-red-400';
                
                return `
                    <div class="neobrutalism-card ${bgColor} p-3 rounded flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="${p.image}" class="w-12 h-12 rounded-full object-cover border-2 border-black">
                            <span class="font-bold">${p.name}</span>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">Sayı: ${p.currentNumber}</p>
                            <p class="text-sm">Can: ${'❤️'.repeat(p.lives)} ${p.out ? '(Elendi)' : ''}</p>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function updateHistory() {
            const history = document.getElementById('history');
            history.innerHTML = [...game.history].reverse().slice(0, 10).map(h => 
                `<div class="border-3 border-black rounded p-2">
                    <span class="font-bold">${h.player}</span>: 
                    Hedef ${h.target} - 
                    <span class="${h.hit ? 'text-green-600' : 'text-red-600'} font-bold">
                        ${h.hit ? '✓ Vurdu' : '✗ Kaçırdı'}
                    </span>
                    ${h.eliminated ? ' (Elendi!)' : ''}
                </div>`
            ).join('');
        }

        function hit() {
            const current = game.players[game.currentPlayerIndex];
            
            game.history.push({
                player: current.name,
                target: current.currentNumber,
                hit: true,
                eliminated: false
            });
            
            current.currentNumber++;
            
            if (current.currentNumber > 20) {
                alert(`🎉 ${current.name} 20'ye ulaştı ve kazandı!`);
                saveGameResult();
                return;
            }
            
            game.currentPlayerIndex = (game.currentPlayerIndex + 1) % game.players.length;
            updateDisplay();
        }

        function miss() {
            const current = game.players[game.currentPlayerIndex];
            
            current.lives--;
            
            const eliminated = current.lives <= 0;
            if (eliminated) {
                current.out = true;
            }
            
            game.history.push({
                player: current.name,
                target: current.currentNumber,
                hit: false,
                eliminated: eliminated
            });
            
            game.currentPlayerIndex = (game.currentPlayerIndex + 1) % game.players.length;
            updateDisplay();
        }

        async function saveGameResult() {
            try {
                const sortedPlayers = [...game.players].sort((a, b) => {
                    if (a.out && !b.out) return 1;
                    if (!a.out && b.out) return -1;
                    return b.currentNumber - a.currentNumber;
                });
                
                const winner = sortedPlayers[0];
                
                const participants = sortedPlayers.map((p, idx) => ({
                    player_id: p.id,
                    player_name: p.name,
                    final_score: p.currentNumber,
                    placement: idx + 1
                }));
                
                await fetch('api_game_result.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        game_type: '1-2-3',
                        game_data: {
                            winner_score: winner.currentNumber
                        },
                        winner_id: winner.id,
                        participants: participants
                    })
                });
                
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

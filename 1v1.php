<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./index.css">
<link rel="stylesheet" href="./styles.css">
<link rel="icon" type="image/svg+xml" href="./favicon.svg">
<title>1v1 - Dartanyan</title>
</head>
<body class="bg-yellow-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <a href="index.php" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Ana Sayfa</a>
            <h1 class="text-3xl font-bold">🎯 1v1</h1>
            <button onclick="toggleFullscreen()" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold text-xl" title="Tam Ekran">
                <span id="fullscreenIcon">⛶</span>
            </button>
        </div>

        <div id="setupScreen" class="max-w-2xl mx-auto">
            <div class="neobrutalism-card bg-white p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Oyun Ayarları</h2>
                <form id="setupForm" class="space-y-4">
                    <div>
                        <label class="block font-bold mb-2">Hedef Puan</label>
                        <select id="targetScore" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="301">301</option>
                            <option value="501" selected>501</option>
                            <option value="701">701</option>
                            <option value="1001">1001</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Kaç Leg Kazanan Alır?</label>
                        <select id="legsToWin" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="1" selected>Best of 1 (1 leg)</option>
                            <option value="2">Best of 3 (2 leg)</option>
                            <option value="3">Best of 5 (3 leg)</option>
                            <option value="4">Best of 7 (4 leg)</option>
                            <option value="5">Best of 9 (5 leg)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Oyuncu 1</label>
                        <select id="player1" required class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="">-- Oyuncu Seç --</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Oyuncu 2</label>
                        <select id="player2" required class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="">-- Oyuncu Seç --</option>
                        </select>
                    </div>

                    <button type="submit" class="neobrutalism-btn bg-green-400 px-6 py-3 rounded font-bold w-full">
                        Oyunu Başlat
                    </button>
                </form>
            </div>
        </div>

        <div id="gameScreen" class="hidden">
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div id="player1Card" class="neobrutalism-card p-4 rounded-lg">
                    <img id="player1Image" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover border-3 border-black">
                    <h3 id="player1Name" class="text-xl font-bold text-center mb-2"></h3>
                    <p id="player1Score" class="text-4xl font-bold text-center"></p>
                </div>

                <div id="player2Card" class="neobrutalism-card p-4 rounded-lg">
                    <img id="player2Image" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover border-3 border-black">
                    <h3 id="player2Name" class="text-xl font-bold text-center mb-2"></h3>
                    <p id="player2Score" class="text-4xl font-bold text-center"></p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-4">
                <div class="neobrutalism-card bg-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4 text-center">
                        Sıra: <span id="currentPlayerName"></span>
                    </h3>

                    <div class="mb-4">
                        <input type="text" id="scoreInput" 
                            class="neobrutalism-input w-full px-4 py-3 rounded text-center text-3xl font-bold" 
                            placeholder="0" inputmode="numeric">
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <button onclick="enterScore(1)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">1</button>
                        <button onclick="enterScore(2)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">2</button>
                        <button onclick="enterScore(3)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">3</button>
                        <button onclick="enterScore(4)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">4</button>
                        <button onclick="enterScore(5)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">5</button>
                        <button onclick="enterScore(6)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">6</button>
                        <button onclick="enterScore(7)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">7</button>
                        <button onclick="enterScore(8)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">8</button>
                        <button onclick="enterScore(9)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">9</button>
                        <button onclick="clearScore()" class="neobrutalism-btn bg-red-400 px-4 py-3 rounded font-bold">C</button>
                        <button onclick="enterScore(0)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">0</button>
                        <button onclick="backspace()" class="neobrutalism-btn bg-orange-400 px-4 py-3 rounded font-bold">←</button>
                    </div>

                    <button onclick="submitScore()" class="neobrutalism-btn bg-green-400 px-6 py-3 rounded font-bold w-full mb-2">
                        Puanı Kaydet
                    </button>

                    <button onclick="endGame()" class="neobrutalism-btn bg-red-400 px-6 py-3 rounded font-bold w-full">
                        Oyunu Bitir
                    </button>
                </div>

                <div class="neobrutalism-card bg-white p-4 rounded-lg">
                    <h3 class="text-xl font-bold mb-3">Tur Geçmişi</h3>
                    <div id="history" class="space-y-2 max-h-96 overflow-y-auto"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let gameState = null;

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

        async function loadPlayers() {
            try {
                const response = await fetch('api_players.php');
                const players = await response.json();
                const select1 = document.getElementById('player1');
                const select2 = document.getElementById('player2');
                
                players.forEach(player => {
                    const option1 = document.createElement('option');
                    option1.value = player.id;
                    option1.textContent = player.name;
                    select1.appendChild(option1);
                    
                    const option2 = document.createElement('option');
                    option2.value = player.id;
                    option2.textContent = player.name;
                    select2.appendChild(option2);
                });
            } catch (error) {
                console.error('Oyuncular yüklenemedi:', error);
            }
        }

        document.getElementById('setupForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const targetScore = parseInt(document.getElementById('targetScore').value);
            const legsToWin = parseInt(document.getElementById('legsToWin').value);
            const p1Id = document.getElementById('player1').value;
            const p2Id = document.getElementById('player2').value;
            
            if (!p1Id || !p2Id) {
                alert('Lütfen her iki oyuncuyu da seçin');
                return;
            }
            
            if (p1Id === p2Id) {
                alert('Lütfen farklı oyuncular seçin');
                return;
            }
            
            try {
                const response = await fetch('api_players.php');
                const players = await response.json();
                const p1 = players.find(p => p.id === p1Id);
                const p2 = players.find(p => p.id === p2Id);
                
                gameState = {
                    target: targetScore,
                    legsToWin: legsToWin,
                    player1: {id: p1.id, name: p1.name, image: p1.image, score: targetScore, legs: 0, history: []},
                    player2: {id: p2.id, name: p2.name, image: p2.image, score: targetScore, legs: 0, history: []},
                    currentPlayer: 1
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
            setupKeyboardListeners();
        }

        function setupKeyboardListeners() {
            const scoreInput = document.getElementById('scoreInput');
            
            scoreInput.addEventListener('keydown', function(e) {
                if (e.key >= '0' && e.key <= '9') {
                    e.preventDefault();
                    enterScore(parseInt(e.key));
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    submitScore();
                } else if (e.key === 'Backspace' || e.key === 'Delete') {
                    e.preventDefault();
                    backspace();
                } else if (e.key === 'Escape' || e.key.toLowerCase() === 'c') {
                    e.preventDefault();
                    clearScore();
                }
            });
            
            scoreInput.focus();
        }

        function updateDisplay() {
            document.getElementById('player1Image').src = gameState.player1.image;
            document.getElementById('player1Name').textContent = gameState.player1.name + ' (' + gameState.player1.legs + ')';
            document.getElementById('player1Score').textContent = gameState.player1.score;
            
            document.getElementById('player2Image').src = gameState.player2.image;
            document.getElementById('player2Name').textContent = gameState.player2.name + ' (' + gameState.player2.legs + ')';
            document.getElementById('player2Score').textContent = gameState.player2.score;
            
            const currentPlayer = gameState.currentPlayer === 1 ? gameState.player1 : gameState.player2;
            document.getElementById('currentPlayerName').textContent = currentPlayer.name;
            
            document.getElementById('player1Card').style.backgroundColor = 
                gameState.currentPlayer === 1 ? 'var(--color-green-400)' : 'var(--color-white)';
            document.getElementById('player2Card').style.backgroundColor = 
                gameState.currentPlayer === 2 ? 'var(--color-green-400)' : 'var(--color-white)';
            
            updateHistory();
        }

        function updateHistory() {
            const history = document.getElementById('history');
            const allHistory = [];
            
            gameState.player1.history.forEach((score, i) => {
                allHistory.push({round: i + 1, p1: score, p2: gameState.player2.history[i] || '-'});
            });
            
            history.innerHTML = allHistory.reverse().map(h => 
                `<div class="flex justify-between border-3 border-black rounded p-2">
                    <span class="font-bold">Tur ${h.round}</span>
                    <span>${gameState.player1.name}: ${h.p1}</span>
                    <span>${gameState.player2.name}: ${h.p2}</span>
                </div>`
            ).join('');
        }

        function enterScore(digit) {
            const input = document.getElementById('scoreInput');
            if (input.value.length < 3) {
                input.value += digit;
            }
        }

        function clearScore() {
            document.getElementById('scoreInput').value = '';
        }

        function backspace() {
            const input = document.getElementById('scoreInput');
            input.value = input.value.slice(0, -1);
        }

        function submitScore() {
            const scoreInput = document.getElementById('scoreInput');
            const score = parseInt(scoreInput.value) || 0;
            
            const currentPlayer = gameState.currentPlayer === 1 ? gameState.player1 : gameState.player2;
            
            if (score > currentPlayer.score) {
                alert('Puan geçersiz! Kalan puanınızdan büyük olamaz.');
                return;
            }
            
            const newScore = currentPlayer.score - score;
            
            if (newScore === 0) {
                currentPlayer.score = 0;
                currentPlayer.history.push(score);
                currentPlayer.legs++;
                
                if (currentPlayer.legs >= gameState.legsToWin) {
                    alert(`🎉 ${currentPlayer.name} oyunu kazandı! (${gameState.player1.legs}-${gameState.player2.legs})`);
                    saveGameResult(currentPlayer);
                    return;
                } else {
                    alert(`${currentPlayer.name} bu leg'i kazandı! Skor: ${gameState.player1.legs}-${gameState.player2.legs}`);
                    gameState.player1.score = gameState.target;
                    gameState.player2.score = gameState.target;
                    gameState.player1.history = [];
                    gameState.player2.history = [];
                    scoreInput.value = '';
                    updateDisplay();
                    return;
                }
            }
            
            if (newScore === 1) {
                alert('Bust! 1 puana düştünüz, puan sayılmadı.');
                gameState.currentPlayer = gameState.currentPlayer === 1 ? 2 : 1;
                scoreInput.value = '';
                updateDisplay();
                return;
            }
            
            currentPlayer.score = newScore;
            currentPlayer.history.push(score);
            
            gameState.currentPlayer = gameState.currentPlayer === 1 ? 2 : 1;
            scoreInput.value = '';
            updateDisplay();
            document.getElementById('scoreInput').focus();
        }

        async function saveGameResult(winner) {
            try {
                const gameData = {
                    target_score: gameState.target,
                    legs_to_win: gameState.legsToWin,
                    final_score: `${gameState.player1.legs}-${gameState.player2.legs}`
                };
                
                const participants = [
                    {
                        player_id: gameState.player1.id,
                        player_name: gameState.player1.name,
                        final_score: gameState.player1.legs,
                        placement: gameState.player1.legs > gameState.player2.legs ? 1 : 2
                    },
                    {
                        player_id: gameState.player2.id,
                        player_name: gameState.player2.name,
                        final_score: gameState.player2.legs,
                        placement: gameState.player2.legs > gameState.player1.legs ? 1 : 2
                    }
                ];
                
                await fetch('api_game_result.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        game_type: '1v1',
                        game_data: gameData,
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
            gameState = null;
            document.getElementById('setupScreen').classList.remove('hidden');
            document.getElementById('gameScreen').classList.add('hidden');
            document.getElementById('setupForm').reset();
        }

        function endGame() {
            if (confirm('Oyunu bitirmek istediğinize emin misiniz?')) {
                endGameWithoutConfirm();
            }
        }

        loadPlayers();
    </script>
</body>
</html>

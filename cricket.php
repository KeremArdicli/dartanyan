<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./index.css">
<link rel="stylesheet" href="./styles.css">
<link rel="icon" type="image/svg+xml" href="./favicon.svg">
<title>Cricket - Dartanyan</title>
</head>
<body class="bg-yellow-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <a href="index.php" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Ana Sayfa</a>
            <h1 class="text-3xl font-bold">🦗 Cricket</h1>
            <button onclick="toggleFullscreen()" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold text-xl" title="Tam Ekran">
                <span id="fullscreenIcon">⛶</span>
            </button>
        </div>

        <div id="setupScreen" class="max-w-2xl mx-auto">
            <div class="neobrutalism-card bg-white p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Oyuncu Seçimi</h2>
                <form id="setupForm" class="space-y-4">
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
            <div class="grid lg:grid-cols-2 gap-4 mb-4">
                <div class="neobrutalism-card bg-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4 text-center">
                        Sıra: <span id="currentPlayerName"></span>
                    </h3>
                    <div class="flex justify-center mb-4">
                        <img id="currentPlayerImage" class="w-24 h-24 rounded-full object-cover border-3 border-black">
                    </div>

                    <h3 class="text-lg font-bold mb-3">Hangi sayıya vurdu?</h3>
                    <div class="grid grid-cols-4 gap-2 mb-4">
                        <button onclick="hitNumber(15)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">15</button>
                        <button onclick="hitNumber(16)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">16</button>
                        <button onclick="hitNumber(17)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">17</button>
                        <button onclick="hitNumber(18)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">18</button>
                        <button onclick="hitNumber(19)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">19</button>
                        <button onclick="hitNumber(20)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">20</button>
                        <button onclick="hitNumber(25)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">Bull</button>
                        <button onclick="nextTurn()" class="neobrutalism-btn bg-orange-400 px-4 py-3 rounded font-bold">İleri</button>
                    </div>

                    <button onclick="endGame()" class="neobrutalism-btn bg-red-400 px-6 py-3 rounded font-bold w-full">
                        Oyunu Bitir
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                <div id="player1Card" class="neobrutalism-card bg-white p-4 rounded-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <img id="player1Image" class="w-16 h-16 rounded-full object-cover border-2 border-black">
                        <div>
                            <h3 id="player1Name" class="font-bold text-lg"></h3>
                            <p id="player1Score" class="text-xl font-bold">0</p>
                        </div>
                    </div>
                    <div id="player1Numbers" class="text-sm"></div>
                </div>

                <div id="player2Card" class="neobrutalism-card bg-white p-4 rounded-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <img id="player2Image" class="w-16 h-16 rounded-full object-cover border-2 border-black">
                        <div>
                            <h3 id="player2Name" class="font-bold text-lg"></h3>
                            <p id="player2Score" class="text-xl font-bold">0</p>
                        </div>
                    </div>
                    <div id="player2Numbers" class="text-sm"></div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let game = null;
        const numbers = [15, 16, 17, 18, 19, 20, 25];

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
                
                [1, 2].forEach(i => {
                    const select = document.getElementById(`player${i}`);
                    select.innerHTML = '<option value="">-- Oyuncu Seç --</option>';
                    players.forEach(player => {
                        const option = document.createElement('option');
                        option.value = player.id;
                        option.textContent = player.name;
                        select.appendChild(option);
                    });
                });
            } catch (error) {
                console.error('Oyuncular yüklenemedi:', error);
            }
        }

        document.getElementById('setupForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
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
                
                game = {
                    player1: {
                        id: p1.id,
                        name: p1.name,
                        image: p1.image,
                        score: 0,
                        numbers: {}
                    },
                    player2: {
                        id: p2.id,
                        name: p2.name,
                        image: p2.image,
                        score: 0,
                        numbers: {}
                    },
                    currentPlayer: 1
                };
                
                numbers.forEach(num => {
                    game.player1.numbers[num] = 0;
                    game.player2.numbers[num] = 0;
                });
                
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
            const current = game.currentPlayer === 1 ? game.player1 : game.player2;
            
            document.getElementById('currentPlayerName').textContent = current.name;
            document.getElementById('currentPlayerImage').src = current.image;
            
            document.getElementById('player1Image').src = game.player1.image;
            document.getElementById('player1Name').textContent = game.player1.name;
            document.getElementById('player1Score').textContent = game.player1.score;
            
            document.getElementById('player2Image').src = game.player2.image;
            document.getElementById('player2Name').textContent = game.player2.name;
            document.getElementById('player2Score').textContent = game.player2.score;
            
            updateNumbers(1);
            updateNumbers(2);
            
            document.getElementById('player1Card').style.backgroundColor = 
                game.currentPlayer === 1 ? 'var(--color-green-400)' : 'var(--color-white)';
            document.getElementById('player2Card').style.backgroundColor = 
                game.currentPlayer === 2 ? 'var(--color-green-400)' : 'var(--color-white)';
        }

        function updateNumbers(playerNum) {
            const player = playerNum === 1 ? game.player1 : game.player2;
            const opponent = playerNum === 1 ? game.player2 : game.player1;
            const container = document.getElementById(`player${playerNum}Numbers`);
            
            container.innerHTML = numbers.map(num => {
                const hits = player.numbers[num];
                const closed = hits >= 3;
                const marks = '✓'.repeat(Math.min(hits, 3));
                return `<div class="flex justify-between py-1 ${closed ? 'opacity-60' : ''}">
                    <span>${num === 25 ? 'Bull' : num}:</span>
                    <span class="font-bold">${marks}</span>
                </div>`;
            }).join('');
        }

        function hitNumber(num) {
            const current = game.currentPlayer === 1 ? game.player1 : game.player2;
            const opponent = game.currentPlayer === 1 ? game.player2 : game.player1;
            
            current.numbers[num]++;
            
            if (current.numbers[num] > 3 && opponent.numbers[num] < 3) {
                const points = num === 25 ? 25 : num;
                current.score += points;
            }
            
            updateDisplay();
            checkWinner();
        }

        function checkWinner() {
            const current = game.currentPlayer === 1 ? game.player1 : game.player2;
            const allClosed = numbers.every(num => current.numbers[num] >= 3);
            
            if (allClosed) {
                const opponent = game.currentPlayer === 1 ? game.player2 : game.player1;
                if (current.score >= opponent.score) {
                    alert(`🎉 ${current.name} kazandı! (${current.score} - ${opponent.score})`);
                    saveGameResult();
                }
            }
        }

        function nextTurn() {
            game.currentPlayer = game.currentPlayer === 1 ? 2 : 1;
            updateDisplay();
        }

        async function saveGameResult() {
            try {
                const winner = game.player1.score > game.player2.score ? game.player1 : game.player2;
                
                await fetch('api_game_result.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        game_type: 'cricket',
                        game_data: {
                            final_score: `${game.player1.score}-${game.player2.score}`
                        },
                        winner_id: winner.id,
                        participants: [
                            {
                                player_id: game.player1.id,
                                player_name: game.player1.name,
                                final_score: game.player1.score,
                                placement: game.player1.score > game.player2.score ? 1 : 2
                            },
                            {
                                player_id: game.player2.id,
                                player_name: game.player2.name,
                                final_score: game.player2.score,
                                placement: game.player2.score > game.player1.score ? 1 : 2
                            }
                        ]
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

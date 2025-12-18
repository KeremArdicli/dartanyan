<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./index.css">
<link rel="stylesheet" href="./styles.css">
<link rel="icon" type="image/svg+xml" href="./favicon.svg">
<title>Turnuva - Dartanyan</title>
</head>
<body class="bg-yellow-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <a href="index.php" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Ana Sayfa</a>
            <h1 class="text-3xl font-bold">🏆 Turnuva</h1>
            <button onclick="toggleFullscreen()" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold text-xl" title="Tam Ekran">
                <span id="fullscreenIcon">⛶</span>
            </button>
        </div>

        <div id="setupScreen" class="max-w-2xl mx-auto">
            <div class="neobrutalism-card bg-white p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Turnuva Ayarları</h2>
                <form id="setupForm" class="space-y-4">
                    <div>
                        <label class="block font-bold mb-2">Bacak Hedef Puanı</label>
                        <select id="legScore" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="301">301</option>
                            <option value="501" selected>501</option>
                            <option value="701">701</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Kaç Bacak Kazanmalı? (Finalde Hariç)</label>
                        <select id="legsToWin" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="1" selected>Best of 1 (1 bacak)</option>
                            <option value="2">Best of 3 (2 bacak)</option>
                            <option value="3">Best of 5 (3 bacak)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Final Hedef Puanı</label>
                        <select id="finalScore" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="501">501</option>
                            <option value="701" selected>701</option>
                            <option value="1001">1001</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Finalde Kaç Bacak Kazanmalı?</label>
                        <select id="finalLegsToWin" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="2">Best of 3 (2 bacak)</option>
                            <option value="3" selected>Best of 5 (3 bacak)</option>
                            <option value="4">Best of 7 (4 bacak)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-2">Katılımcı Sayısı</label>
                        <select id="playerCount" class="neobrutalism-input w-full px-4 py-2 rounded">
                            <option value="4">4 Oyuncu</option>
                            <option value="8" selected>8 Oyuncu</option>
                            <option value="16">16 Oyuncu</option>
                        </select>
                    </div>

                    <div id="playerSelects"></div>

                    <button type="submit" class="neobrutalism-btn bg-green-400 px-6 py-3 rounded font-bold w-full">
                        Turnuvayı Başlat
                    </button>
                </form>
            </div>
        </div>

        <div id="bracketScreen" class="hidden">
            <div class="neobrutalism-card bg-white p-6 rounded-lg mb-4">
                <h2 class="text-2xl font-bold mb-4 text-center">
                    <span id="roundName"></span>
                </h2>
                <div id="bracket" class="space-y-4"></div>
            </div>
            
            <button onclick="resetTournament()" class="neobrutalism-btn bg-red-400 px-6 py-3 rounded font-bold w-full">
                Turnuvayı Sıfırla
            </button>
        </div>

        <div id="matchScreen" class="hidden">
            <div class="neobrutalism-card bg-white p-6 rounded-lg mb-4">
                <div class="flex justify-between items-center mb-4">
                    <button onclick="backToBracket()" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Geri</button>
                    <h2 class="text-2xl font-bold text-center">
                        <span id="matchTitle"></span>
                    </h2>
                    <div class="w-20"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div id="matchPlayer1Card" class="neobrutalism-card p-4 rounded-lg">
                    <img id="matchPlayer1Image" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover border-3 border-black">
                    <h3 id="matchPlayer1Name" class="text-xl font-bold text-center mb-2"></h3>
                    <p id="matchPlayer1Legs" class="text-2xl font-bold text-center mb-1"></p>
                    <p id="matchPlayer1Score" class="text-4xl font-bold text-center"></p>
                </div>

                <div id="matchPlayer2Card" class="neobrutalism-card p-4 rounded-lg">
                    <img id="matchPlayer2Image" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover border-3 border-black">
                    <h3 id="matchPlayer2Name" class="text-xl font-bold text-center mb-2"></h3>
                    <p id="matchPlayer2Legs" class="text-2xl font-bold text-center mb-1"></p>
                    <p id="matchPlayer2Score" class="text-4xl font-bold text-center"></p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-4">
                <div class="neobrutalism-card bg-white p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4 text-center">
                        Sıra: <span id="matchCurrentPlayerName"></span>
                    </h3>

                    <div class="mb-4">
                        <input type="text" id="matchScoreInput" 
                            class="neobrutalism-input w-full px-4 py-3 rounded text-center text-3xl font-bold" 
                            placeholder="0" inputmode="numeric">
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <button onclick="matchEnterScore(1)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">1</button>
                        <button onclick="matchEnterScore(2)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">2</button>
                        <button onclick="matchEnterScore(3)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">3</button>
                        <button onclick="matchEnterScore(4)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">4</button>
                        <button onclick="matchEnterScore(5)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">5</button>
                        <button onclick="matchEnterScore(6)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">6</button>
                        <button onclick="matchEnterScore(7)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">7</button>
                        <button onclick="matchEnterScore(8)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">8</button>
                        <button onclick="matchEnterScore(9)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">9</button>
                        <button onclick="matchClearScore()" class="neobrutalism-btn bg-red-400 px-4 py-3 rounded font-bold">C</button>
                        <button onclick="matchEnterScore(0)" class="neobrutalism-btn bg-blue-400 px-4 py-3 rounded font-bold">0</button>
                        <button onclick="matchBackspace()" class="neobrutalism-btn bg-orange-400 px-4 py-3 rounded font-bold">←</button>
                    </div>

                    <button onclick="matchSubmitScore()" class="neobrutalism-btn bg-green-400 px-6 py-3 rounded font-bold w-full">
                        Puanı Kaydet
                    </button>
                </div>

                <div class="neobrutalism-card bg-white p-4 rounded-lg">
                    <h3 class="text-xl font-bold mb-3">Tur Geçmişi</h3>
                    <div id="matchHistory" class="space-y-2 max-h-96 overflow-y-auto"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let tournament = null;
        let currentMatch = null;

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
                return players;
            } catch (error) {
                console.error('Oyuncular yüklenemedi:', error);
                return [];
            }
        }

        document.getElementById('playerCount').addEventListener('change', function() {
            generatePlayerSelects();
        });

        async function generatePlayerSelects() {
            const count = parseInt(document.getElementById('playerCount').value);
            const container = document.getElementById('playerSelects');
            const players = await loadPlayers();
            
            container.innerHTML = '<h3 class="font-bold text-lg mb-2 mt-4">Oyuncuları Seçin</h3>';
            
            for (let i = 1; i <= count; i++) {
                const div = document.createElement('div');
                div.className = 'mb-3';
                
                const label = document.createElement('label');
                label.className = 'block font-bold mb-2';
                label.textContent = `Oyuncu ${i}`;
                
                const select = document.createElement('select');
                select.id = `player${i}`;
                select.required = true;
                select.className = 'neobrutalism-input w-full px-4 py-2 rounded';
                
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '-- Oyuncu Seç --';
                select.appendChild(defaultOption);
                
                players.forEach(player => {
                    const option = document.createElement('option');
                    option.value = player.id;
                    option.textContent = player.name;
                    select.appendChild(option);
                });
                
                div.appendChild(label);
                div.appendChild(select);
                container.appendChild(div);
            }
        }

        document.getElementById('setupForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const legScore = parseInt(document.getElementById('legScore').value);
            const legsToWin = parseInt(document.getElementById('legsToWin').value);
            const finalScore = parseInt(document.getElementById('finalScore').value);
            const finalLegsToWin = parseInt(document.getElementById('finalLegsToWin').value);
            const playerCount = parseInt(document.getElementById('playerCount').value);
            
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
            
            const players = await loadPlayers();
            const selectedPlayerData = selectedPlayers.map(id => players.find(p => p.id === id));
            
            tournament = {
                legScore: legScore,
                legsToWin: legsToWin,
                finalScore: finalScore,
                finalLegsToWin: finalLegsToWin,
                players: selectedPlayerData,
                bracket: createBracket(selectedPlayerData),
                currentRound: 0
            };
            
            startTournament();
        });

        function createBracket(players) {
            const rounds = [];
            let currentRound = [];
            
            for (let i = 0; i < players.length; i += 2) {
                currentRound.push({
                    player1: players[i],
                    player2: players[i + 1],
                    winner: null
                });
            }
            
            rounds.push(currentRound);
            
            while (currentRound.length > 1) {
                const nextRound = [];
                for (let i = 0; i < currentRound.length; i += 2) {
                    nextRound.push({
                        player1: null,
                        player2: null,
                        winner: null
                    });
                }
                rounds.push(nextRound);
                currentRound = nextRound;
            }
            
            return rounds;
        }

        function startTournament() {
            document.getElementById('setupScreen').classList.add('hidden');
            document.getElementById('bracketScreen').classList.remove('hidden');
            displayBracket();
        }

        function displayBracket() {
            const roundNames = ['1. Tur', 'Çeyrek Final', 'Yarı Final', 'Final'];
            const bracket = document.getElementById('bracket');
            const currentRound = tournament.bracket[tournament.currentRound];
            
            const isFinal = tournament.currentRound === tournament.bracket.length - 1;
            const targetScore = isFinal ? tournament.finalScore : tournament.legScore;
            const legsNeeded = isFinal ? tournament.finalLegsToWin : tournament.legsToWin;
            
            const totalRounds = tournament.bracket.length;
            let roundName = '';
            if (totalRounds === 1) {
                roundName = 'Final';
            } else if (totalRounds === 2) {
                roundName = tournament.currentRound === 0 ? 'Yarı Final' : 'Final';
            } else if (totalRounds === 3) {
                roundName = ['Çeyrek Final', 'Yarı Final', 'Final'][tournament.currentRound];
            } else {
                roundName = roundNames[tournament.currentRound] || `Tur ${tournament.currentRound + 1}`;
            }
            
            document.getElementById('roundName').textContent = roundName + ` (${targetScore}, Best of ${legsNeeded * 2 - 1})`;
            
            bracket.innerHTML = currentRound.map((match, idx) => {
                if (!match.player1 || !match.player2) return '';
                
                return `
                    <div class="border-3 border-black rounded p-4">
                        <h3 class="font-bold mb-3 text-center">Maç ${idx + 1}</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col items-center">
                                <img src="${match.player1.image}" class="w-16 h-16 rounded-full object-cover border-2 border-black mb-2">
                                <p class="font-bold text-center">${match.player1.name}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <img src="${match.player2.image}" class="w-16 h-16 rounded-full object-cover border-2 border-black mb-2">
                                <p class="font-bold text-center">${match.player2.name}</p>
                            </div>
                        </div>
                        ${!match.winner ? `
                            <div class="mt-4">
                                <button onclick="startMatch(${tournament.currentRound}, ${idx})" 
                                    class="neobrutalism-btn bg-green-400 px-4 py-2 rounded font-bold w-full">
                                    Maçı Başlat
                                </button>
                            </div>
                        ` : `
                            <p class="mt-4 text-center font-bold text-lg">
                                🏆 Kazanan: ${match.winner.name}
                            </p>
                        `}
                    </div>
                `;
            }).join('');
        }

        function startMatch(roundIdx, matchIdx) {
            const match = tournament.bracket[roundIdx][matchIdx];
            const isFinal = roundIdx === tournament.bracket.length - 1;
            const targetScore = isFinal ? tournament.finalScore : tournament.legScore;
            const legsToWin = isFinal ? tournament.finalLegsToWin : tournament.legsToWin;
            
            currentMatch = {
                roundIdx: roundIdx,
                matchIdx: matchIdx,
                targetScore: targetScore,
                legsToWin: legsToWin,
                player1: {
                    id: match.player1.id,
                    name: match.player1.name,
                    image: match.player1.image,
                    score: targetScore,
                    legs: 0,
                    history: []
                },
                player2: {
                    id: match.player2.id,
                    name: match.player2.name,
                    image: match.player2.image,
                    score: targetScore,
                    legs: 0,
                    history: []
                },
                currentPlayer: 1
            };
            
            document.getElementById('bracketScreen').classList.add('hidden');
            document.getElementById('matchScreen').classList.remove('hidden');
            
            const roundNames = ['1. Tur', 'Çeyrek Final', 'Yarı Final', 'Final'];
            const totalRounds = tournament.bracket.length;
            let roundName = '';
            if (totalRounds === 1) roundName = 'Final';
            else if (totalRounds === 2) roundName = roundIdx === 0 ? 'Yarı Final' : 'Final';
            else if (totalRounds === 3) roundName = ['Çeyrek Final', 'Yarı Final', 'Final'][roundIdx];
            else roundName = roundNames[roundIdx] || `Tur ${roundIdx + 1}`;
            
            document.getElementById('matchTitle').textContent = `${roundName} - Maç ${matchIdx + 1}`;
            
            updateMatchDisplay();
            setupMatchKeyboard();
        }

        function setupMatchKeyboard() {
            const input = document.getElementById('matchScoreInput');
            input.removeEventListener('keydown', matchKeydownHandler);
            input.addEventListener('keydown', matchKeydownHandler);
            input.focus();
        }

        function matchKeydownHandler(e) {
            if (e.key >= '0' && e.key <= '9') {
                e.preventDefault();
                matchEnterScore(parseInt(e.key));
            } else if (e.key === 'Enter') {
                e.preventDefault();
                matchSubmitScore();
            } else if (e.key === 'Backspace' || e.key === 'Delete') {
                e.preventDefault();
                matchBackspace();
            } else if (e.key === 'Escape' || e.key.toLowerCase() === 'c') {
                e.preventDefault();
                matchClearScore();
            }
        }

        function updateMatchDisplay() {
            document.getElementById('matchPlayer1Image').src = currentMatch.player1.image;
            document.getElementById('matchPlayer1Name').textContent = currentMatch.player1.name;
            document.getElementById('matchPlayer1Legs').textContent = `Legs: ${currentMatch.player1.legs}`;
            document.getElementById('matchPlayer1Score').textContent = currentMatch.player1.score;
            
            document.getElementById('matchPlayer2Image').src = currentMatch.player2.image;
            document.getElementById('matchPlayer2Name').textContent = currentMatch.player2.name;
            document.getElementById('matchPlayer2Legs').textContent = `Legs: ${currentMatch.player2.legs}`;
            document.getElementById('matchPlayer2Score').textContent = currentMatch.player2.score;
            
            const current = currentMatch.currentPlayer === 1 ? currentMatch.player1 : currentMatch.player2;
            document.getElementById('matchCurrentPlayerName').textContent = current.name;
            
            document.getElementById('matchPlayer1Card').style.backgroundColor = 
                currentMatch.currentPlayer === 1 ? 'var(--color-green-400)' : 'var(--color-white)';
            document.getElementById('matchPlayer2Card').style.backgroundColor = 
                currentMatch.currentPlayer === 2 ? 'var(--color-green-400)' : 'var(--color-white)';
            
            updateMatchHistory();
        }

        function updateMatchHistory() {
            const history = document.getElementById('matchHistory');
            const allHistory = [];
            
            currentMatch.player1.history.forEach((score, i) => {
                allHistory.push({
                    round: i + 1,
                    p1: score,
                    p2: currentMatch.player2.history[i] || '-'
                });
            });
            
            history.innerHTML = allHistory.reverse().map(h => 
                `<div class="flex justify-between border-3 border-black rounded p-2">
                    <span class="font-bold">Tur ${h.round}</span>
                    <span>${currentMatch.player1.name}: ${h.p1}</span>
                    <span>${currentMatch.player2.name}: ${h.p2}</span>
                </div>`
            ).join('');
        }

        function matchEnterScore(digit) {
            const input = document.getElementById('matchScoreInput');
            if (input.value.length < 3) {
                input.value += digit;
            }
        }

        function matchClearScore() {
            document.getElementById('matchScoreInput').value = '';
        }

        function matchBackspace() {
            const input = document.getElementById('matchScoreInput');
            input.value = input.value.slice(0, -1);
        }

        function matchSubmitScore() {
            const scoreInput = document.getElementById('matchScoreInput');
            const score = parseInt(scoreInput.value) || 0;
            
            const current = currentMatch.currentPlayer === 1 ? currentMatch.player1 : currentMatch.player2;
            
            if (score > current.score) {
                alert('Puan geçersiz! Kalan puanınızdan büyük olamaz.');
                return;
            }
            
            const newScore = current.score - score;
            
            if (newScore === 0) {
                current.score = 0;
                current.history.push(score);
                current.legs++;
                
                if (current.legs >= currentMatch.legsToWin) {
                    alert(`🎉 ${current.name} maçı kazandı! (${currentMatch.player1.legs}-${currentMatch.player2.legs})`);
                    setWinner(currentMatch.roundIdx, currentMatch.matchIdx, currentMatch.currentPlayer);
                    return;
                } else {
                    alert(`${current.name} bu leg'i kazandı! Skor: ${currentMatch.player1.legs}-${currentMatch.player2.legs}`);
                    currentMatch.player1.score = currentMatch.targetScore;
                    currentMatch.player2.score = currentMatch.targetScore;
                    currentMatch.player1.history = [];
                    currentMatch.player2.history = [];
                    scoreInput.value = '';
                    updateMatchDisplay();
                    return;
                }
            }
            
            if (newScore === 1) {
                alert('Bust! 1 puana düştünüz, puan sayılmadı.');
                currentMatch.currentPlayer = currentMatch.currentPlayer === 1 ? 2 : 1;
                scoreInput.value = '';
                updateMatchDisplay();
                return;
            }
            
            current.score = newScore;
            current.history.push(score);
            
            currentMatch.currentPlayer = currentMatch.currentPlayer === 1 ? 2 : 1;
            scoreInput.value = '';
            updateMatchDisplay();
            document.getElementById('matchScoreInput').focus();
        }

        function backToBracket() {
            if (confirm('Maçtan çıkmak istediğinize emin misiniz? İlerleme kaydedilmeyecek.')) {
                currentMatch = null;
                document.getElementById('matchScreen').classList.add('hidden');
                document.getElementById('bracketScreen').classList.remove('hidden');
            }
        }

        function setWinner(roundIdx, matchIdx, playerNum) {
            const match = tournament.bracket[roundIdx][matchIdx];
            match.winner = playerNum === 1 ? currentMatch.player1 : currentMatch.player2;
            
            currentMatch = null;
            document.getElementById('matchScreen').classList.add('hidden');
            document.getElementById('bracketScreen').classList.remove('hidden');
            
            const allMatchesComplete = tournament.bracket[roundIdx].every(m => m.winner);
            
            if (allMatchesComplete && roundIdx < tournament.bracket.length - 1) {
                const nextRound = tournament.bracket[roundIdx + 1];
                for (let i = 0; i < tournament.bracket[roundIdx].length; i += 2) {
                    const nextMatchIdx = Math.floor(i / 2);
                    nextRound[nextMatchIdx].player1 = tournament.bracket[roundIdx][i].winner;
                    nextRound[nextMatchIdx].player2 = tournament.bracket[roundIdx][i + 1].winner;
                }
                tournament.currentRound++;
            }
            
            if (roundIdx === tournament.bracket.length - 1 && match.winner) {
                alert(`🎉 Turnuva Şampiyonu: ${match.winner.name}!`);
                saveTournamentResult(match.winner);
                return;
            }
            
            displayBracket();
        }

        async function saveTournamentResult(winner) {
            try {
                const participants = [];
                let placement = 1;
                
                participants.push({
                    player_id: winner.id,
                    player_name: winner.name,
                    final_score: 0,
                    placement: 1
                });
                
                const finalMatch = tournament.bracket[tournament.bracket.length - 1][0];
                const runnerUp = finalMatch.player1.id === winner.id ? finalMatch.player2 : finalMatch.player1;
                participants.push({
                    player_id: runnerUp.id,
                    player_name: runnerUp.name,
                    final_score: 0,
                    placement: 2
                });
                
                tournament.players.forEach(p => {
                    if (p.id !== winner.id && p.id !== runnerUp.id) {
                        participants.push({
                            player_id: p.id,
                            player_name: p.name,
                            final_score: 0,
                            placement: 3
                        });
                    }
                });
                
                await fetch('api_game_result.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        game_type: 'tournament',
                        game_data: {
                            leg_score: tournament.legScore,
                            legs_to_win: tournament.legsToWin,
                            final_score: tournament.finalScore,
                            final_legs_to_win: tournament.finalLegsToWin,
                            player_count: tournament.players.length
                        },
                        winner_id: winner.id,
                        participants: participants
                    })
                });
                
                resetTournamentWithoutConfirm();
            } catch (error) {
                console.error('Sonuç kaydedilemedi:', error);
                resetTournamentWithoutConfirm();
            }
        }

        function resetTournamentWithoutConfirm() {
            tournament = null;
            document.getElementById('setupScreen').classList.remove('hidden');
            document.getElementById('bracketScreen').classList.add('hidden');
            document.getElementById('setupForm').reset();
            generatePlayerSelects();
        }

        function resetTournament() {
            if (confirm('Turnuvayı sıfırlamak istediğinize emin misiniz?')) {
                resetTournamentWithoutConfirm();
            }
        }

        generatePlayerSelects();
    </script>
</body>
</html>

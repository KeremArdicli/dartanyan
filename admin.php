<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./index.css">
<link rel="stylesheet" href="./styles.css">
<link rel="icon" type="image/svg+xml" href="./favicon.svg">
<title>Admin - Dartanyan</title>
</head>
<body class="bg-yellow-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <a href="index.php" class="neobrutalism-btn bg-white px-4 py-2 rounded font-bold">← Ana Sayfa</a>
            <h1 class="text-3xl font-bold">Oyuncu Yönetimi</h1>
            <div class="w-28"></div>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="neobrutalism-card bg-white p-6 rounded-lg mb-8">
                <h2 class="text-2xl font-bold mb-4">Yeni Oyuncu Ekle</h2>
                <form id="addPlayerForm" class="space-y-4">
                    <div>
                        <label class="block font-bold mb-2">Ad Soyad</label>
                        <input type="text" id="playerName" required 
                            class="neobrutalism-input w-full px-4 py-2 rounded" 
                            placeholder="Oyuncu adı">
                    </div>
                    
                    <div>
                        <label class="block font-bold mb-2">Resim</label>
                        <input type="file" id="playerImage" accept="image/*" 
                            class="neobrutalism-input w-full px-4 py-2 rounded bg-white">
                        <p class="text-sm mt-1 opacity-60">veya mevcut resim seç:</p>
                        <select id="existingImage" class="neobrutalism-input w-full px-4 py-2 rounded mt-2">
                            <option value="">-- Mevcut resim seç --</option>
                        </select>
                    </div>

                    <button type="submit" class="neobrutalism-btn bg-green-400 px-6 py-3 rounded font-bold w-full">
                        Oyuncu Ekle
                    </button>
                </form>
            </div>

            <div class="neobrutalism-card bg-white p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Oyuncular</h2>
                <div id="playersList" class="space-y-3"></div>
            </div>
        </div>
    </div>

    <script>
        const existingImageSelect = document.getElementById('existingImage');
        
        async function loadExistingImages() {
            try {
                const response = await fetch('get_images.php');
                const images = await response.json();
                images.forEach(img => {
                    const option = document.createElement('option');
                    option.value = img;
                    option.textContent = img;
                    existingImageSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Resimler yüklenemedi:', error);
            }
        }

        async function displayPlayers() {
            try {
                const response = await fetch('api_players.php');
                const players = await response.json();
                const list = document.getElementById('playersList');
                
                if (players.length === 0) {
                    list.innerHTML = '<p class="opacity-60">Henüz oyuncu eklenmemiş</p>';
                    return;
                }
                
                list.innerHTML = players.map(player => `
                    <div class="flex items-center justify-between p-4 border-3 border-black rounded">
                        <div class="flex items-center gap-4">
                            <img src="${player.image}" alt="${player.name}" 
                                class="w-16 h-16 rounded-full object-cover border-2 border-black">
                            <span class="font-bold text-lg">${player.name}</span>
                        </div>
                        <button onclick="deletePlayer('${player.id}')" 
                            class="neobrutalism-btn bg-red-400 px-4 py-2 rounded font-bold">
                            Sil
                        </button>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Oyuncular yüklenemedi:', error);
            }
        }

        document.getElementById('addPlayerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const name = document.getElementById('playerName').value.trim();
            const imageFile = document.getElementById('playerImage').files[0];
            const existingImage = document.getElementById('existingImage').value;
            
            if (!name) {
                alert('Lütfen oyuncu adı girin');
                return;
            }

            let imagePath = './assets/ekip/USER.jpg';
            
            if (imageFile) {
                const formData = new FormData();
                formData.append('image', imageFile);
                
                try {
                    const response = await fetch('upload_image.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        imagePath = result.path;
                    } else {
                        alert('Resim yüklenemedi: ' + result.error);
                        return;
                    }
                } catch (error) {
                    alert('Resim yüklenirken hata oluştu');
                    return;
                }
            } else if (existingImage) {
                imagePath = './assets/ekip/' + existingImage;
            }
            
            try {
                const response = await fetch('api_players.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({name: name, image: imagePath})
                });
                
                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('playerName').value = '';
                    document.getElementById('playerImage').value = '';
                    document.getElementById('existingImage').value = '';
                    displayPlayers();
                } else {
                    alert('Oyuncu eklenemedi: ' + result.error);
                }
            } catch (error) {
                alert('Oyuncu eklenirken hata oluştu');
            }
        });

        async function deletePlayer(id) {
            if (confirm('Bu oyuncuyu silmek istediğinize emin misiniz?')) {
                try {
                    const response = await fetch('api_players.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        displayPlayers();
                    } else {
                        alert('Oyuncu silinemedi: ' + result.error);
                    }
                } catch (error) {
                    alert('Oyuncu silinirken hata oluştu');
                }
            }
        }

        loadExistingImages();
        displayPlayers();
    </script>
</body>
</html>

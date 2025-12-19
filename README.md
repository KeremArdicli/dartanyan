# 🎯 Dartanyan

<div align="center">

**Profesyonel Dart Oyun Yönetim Sistemi**

*Professional Dart Game Management System*

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![SQLite](https://img.shields.io/badge/SQLite-07405E?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

[Türkçe](#tr) | [English](#en)

</div>

---

## <a name="tr"></a>🇹🇷 Türkçe

### 📖 Proje Hakkında

Dartanyan, dart turnuvalarını ve oyunlarını yönetmek için geliştirilmiş modern bir web uygulamasıdır. Sezgisel arayüzü ve kapsamlı oyun modlarıyla dart salonları, kulüpler ve etkinlikler için ideal bir çözümdür.

### ✨ Özellikler

- 🎮 **Çoklu Oyun Modları**
  - **1v1**: Klasik karşılıklı maçlar (301, 501, 701)
  - **Turnuva**: Elemeli turnuva sistemi
  - **1-2-3**: Geleneksel 1-2-3 oyunu
  - **Cricket**: Stratejik dart oyunu (15-20 arası sayılar)
  - **Around the Clock**: Hız ve hassasiyet oyunu (1'den 20'ye)

- 👥 **Oyuncu Yönetimi**
  - Oyuncu profilleri oluşturma
  - Profil fotoğrafı yükleme
  - Oyuncu düzenleme ve silme

- 📊 **İstatistik ve Kayıt**
  - Otomatik skor takibi
  - Oyun geçmişi
  - Kazanan/kaybedenler kaydı
  - Detaylı oyun istatistikleri

- 🎨 **Modern Tasarım**
  - Neobrutalism tasarım dili
  - Responsive (mobil uyumlu) arayüz
  - Kullanıcı dostu navigasyon

### 🚀 Kurulum

#### Gereksinimler

- PHP 7.4 veya üzeri
- SQLite3 desteği
- Web sunucusu (Apache/Nginx)

#### Adımlar

1. **Projeyi klonlayın**
   ```bash
   git clone https://github.com/kullaniciadi/dartanyan.git
   cd dartanyan
   ```

2. **Veritabanını başlatın**
   ```bash
   php init_db.php
   ```

3. **Web sunucunuzu yapılandırın**
   - Apache için document root'u proje klasörüne ayarlayın
   - Nginx için PHP-FPM'i yapılandırın

4. **Uygulamaya erişin**
   ```
   http://localhost/dartanyan
   ```

### 📁 Proje Yapısı

```
dartanyan/
├── index.php              # Ana sayfa
├── 1v1.php               # 1v1 oyun modu
├── turnuva.php           # Turnuva modu
├── 123.php               # 1-2-3 oyunu
├── cricket.php           # Cricket oyunu
├── around-the-clock.php  # Around the Clock oyunu
├── admin.php             # Admin paneli
├── db.php                # Veritabanı bağlantısı
├── init_db.php           # Veritabanı başlatma
├── database.sqlite       # SQLite veritabanı
├── api_players.php       # Oyuncu API'si
├── api_game_result.php   # Oyun sonuçları API'si
├── upload_image.php      # Resim yükleme
├── get_images.php        # Resim listesi
└── storage.js            # Frontend depolama
```

### 🎮 Kullanım

1. **Oyuncu Ekleme**
   - Admin paneline gidin
   - "Oyuncu Ekle" butonuna tıklayın
   - İsim ve fotoğraf ekleyin

2. **Oyun Başlatma**
   - Ana sayfadan oyun modunu seçin
   - Oyuncuları seçin
   - Oyuna başlayın

3. **Skor Girişi**
   - Her atıştan sonra skoru girin
   - Sistem otomatik olarak hesaplar
   - Oyun sonunda kazananı belirler

### 🛠️ Teknolojiler

- **Backend**: PHP 7.4+
- **Veritabanı**: SQLite3
- **Frontend**: HTML5, CSS3, JavaScript
- **Stil**: Tailwind CSS (CDN)
- **Tasarım**: Neobrutalism

### 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

### 🤝 Katkıda Bulunma

Katkılarınızı bekliyoruz! Pull request göndermekten çekinmeyin.

1. Projeyi fork edin
2. Feature branch oluşturun (`git checkout -b feature/YeniOzellik`)
3. Değişikliklerinizi commit edin (`git commit -m 'Yeni özellik eklendi'`)
4. Branch'inizi push edin (`git push origin feature/YeniOzellik`)
5. Pull Request oluşturun

---

## <a name="en"></a>🇬🇧 English

### 📖 About The Project

Dartanyan is a modern web application developed for managing dart tournaments and games. With its intuitive interface and comprehensive game modes, it's an ideal solution for dart venues, clubs, and events.

### ✨ Features

- 🎮 **Multiple Game Modes**
  - **1v1**: Classic head-to-head matches (301, 501, 701)
  - **Tournament**: Elimination tournament system
  - **1-2-3**: Traditional 1-2-3 game
  - **Cricket**: Strategic dart game (numbers 15-20)
  - **Around the Clock**: Speed and precision game (1 to 20)

- 👥 **Player Management**
  - Create player profiles
  - Upload profile pictures
  - Edit and delete players

- 📊 **Statistics and Records**
  - Automatic score tracking
  - Game history
  - Winner/loser records
  - Detailed game statistics

- 🎨 **Modern Design**
  - Neobrutalism design language
  - Responsive (mobile-friendly) interface
  - User-friendly navigation

### 🚀 Installation

#### Requirements

- PHP 7.4 or higher
- SQLite3 support
- Web server (Apache/Nginx)

#### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/username/dartanyan.git
   cd dartanyan
   ```

2. **Initialize the database**
   ```bash
   php init_db.php
   ```

3. **Configure your web server**
   - For Apache, set document root to project folder
   - For Nginx, configure PHP-FPM

4. **Access the application**
   ```
   http://localhost/dartanyan
   ```

### 📁 Project Structure

```
dartanyan/
├── index.php              # Home page
├── 1v1.php               # 1v1 game mode
├── turnuva.php           # Tournament mode
├── 123.php               # 1-2-3 game
├── cricket.php           # Cricket game
├── around-the-clock.php  # Around the Clock game
├── admin.php             # Admin panel
├── db.php                # Database connection
├── init_db.php           # Database initialization
├── database.sqlite       # SQLite database
├── api_players.php       # Players API
├── api_game_result.php   # Game results API
├── upload_image.php      # Image upload
├── get_images.php        # Image listing
└── storage.js            # Frontend storage
```

### 🎮 Usage

1. **Adding Players**
   - Go to admin panel
   - Click "Add Player" button
   - Enter name and photo

2. **Starting a Game**
   - Select game mode from home page
   - Choose players
   - Start the game

3. **Score Entry**
   - Enter score after each throw
   - System calculates automatically
   - Determines winner at game end

### 🛠️ Technologies

- **Backend**: PHP 7.4+
- **Database**: SQLite3
- **Frontend**: HTML5, CSS3, JavaScript
- **Styling**: Tailwind CSS (CDN)
- **Design**: Neobrutalism

### 📄 License

This project is licensed under the MIT License.

### 🤝 Contributing

Contributions are welcome! Feel free to submit pull requests.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

<div align="center">

**Made with ❤️ for dart enthusiasts**

**Dart tutkunları için ❤️ ile yapıldı**

</div>

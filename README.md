Tentu! Berikut adalah isi lengkap `README.md` yang bisa langsung kamu **copy-paste dan tempelkan** ke proyekmu:

---

```markdown
# 📝 PHP Native Blog App

Aplikasi blog sederhana berbasis **PHP Native** (tanpa framework) yang mendukung:
- ✅ Registrasi & login user
- 📝 Menambahkan, mengedit, dan menghapus artikel
- 📜 Menampilkan daftar artikel di halaman utama

---

## 📌 Apa Itu PHP Native?

PHP Native berarti menggunakan PHP murni tanpa framework tambahan seperti Laravel atau CodeIgniter. Semua logika, routing, dan koneksi database ditangani secara manual menggunakan file PHP, cocok untuk:
- Pembelajaran dasar pemrograman web
- Prototipe ringan
- Deployment sederhana berbasis Docker

---

## ⚙️ Langkah Menjalankan Proyek

### 1. Persiapan

Pastikan sudah terinstall:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### 2. Jalankan dengan Docker

Buka terminal di direktori `src/`, lalu jalankan:

```bash
docker compose up --build
````

### 3. Akses Aplikasi

Buka browser dan akses:

```
http://localhost
```

---

## ⚠️ Konfigurasi Penting - Database

Aplikasi ini membutuhkan koneksi ke database **MySQL**. File konfigurasi ada di `conn.php`:

```php
$host = '192.168.0.80';  // IP atau nama service database
$db_name = 'web_blog';
$username = 'root';
$password = 'p455w0rd';
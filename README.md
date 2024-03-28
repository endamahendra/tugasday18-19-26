# Panduan Pengguna: Mengkloning dan Menyiapkan Proyek Laravel

1.git clone <URL_Repositori>
2.cd <Nama_Folder_Proyek>
3.composer install
4.npm install && npm run dev
5.cp .env.example .env
6.buat database
7.Edit file .env dan atur koneksi database sesuai detail database yang telah Anda buat.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nama_database>
DB_USERNAME=<nama_pengguna_database>
DB_PASSWORD=<kata_sandi_database>

7.php artisan key:generate
8.php artisan migrate
9.php artisan serve

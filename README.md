<b>Panduan Pengguna: Mengkloning dan Menyiapkan Proyek Laravel<b>

<p>1.git clone https://github.com/endamahendra/tugasday18-19-26.git </p>
<p>2.cd tugasday18-19-26</p>
<p>3.composer install</p>
<p>4.npm install && npm run dev</p>
<p>5.cp .env.example .env</p>
<p>6.buat database</p>
<p>7.Edit file .env dan atur koneksi database sesuai detail database yang telah Anda buat.</p>

<p>DB_CONNECTION=mysql</p>
<p>DB_HOST=127.0.0.1</p>
<p>DB_PORT=3306</p>
<p>DB_DATABASE=<nama_database></p>
<p>DB_USERNAME=<nama_pengguna_database></p>
<p>DB_PASSWORD=<kata_sandi_database></p>

<p>7.php artisan key:generate</p>
<p>8.php artisan migrate</p>
<p>9.php artisan serve</p>

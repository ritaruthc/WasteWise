# PILASAKI'
Finalis of ICONIC 2024
![Top Image](README/top.jpg)


## Latar Belakang

Website ini dikembangkan untuk meningkatkan kesadaran dan pengetahuan masyarakat tentang pemilahan sampah, serta memberikan akses informasi edukatif yang terorganisir dan mudah dicari.

## Tujuan

- Meningkatkan pemahaman masyarakat tentang jenis sampah dan cara pengelolaannya.

- Menyediakan artikel informatif dan terkini mengenai pengelolaan sampah.

- Mendukung Tujuan Pembangunan Berkelanjutan (SDGs) dalam pendidikan dan keberlanjutan kota.

## Fitur Utama

1. Sistem Manajemen Konten Artikel: Kategorisasi, fitur pencarian, dan riwayat artikel yang dilihat.
    ![Artikel](README/artikel.png)

2. Klasifikasi Sampah Otomatis: Menggunakan TensorFlow.js untuk menganalisis gambar sampah dan mengidentifikasi kategorinya.
    ![Recording](README/Recording%202025-02-13%20002927(1).gif)

    ![Klasifikasi](README/klasifikasi.png)

3. Forum Diskusi: Untuk memfasilitasi diskusi antara pengguna.
    ![Diskusi](README/diskusi.png)


Website ini bertujuan untuk mempromosikan praktik pengelolaan sampah yang lebih baik, mendidik masyarakat, dan berkontribusi pada isu-isu keberlanjutan dan perubahan iklim.


## Langkah-langkah Instalasi

1. Clone repositori:
    ```bash
    git clone https://github.com/PeterChen712/Pisah
    ```

2. Masuk ke repositori:
    ```bash 
    cd Pisah
    ```

3. Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```

4. Install dependencies PHP menggunakan Composer:
    ```bash
    composer install
    ```

5. Buat app key:
    ```bash
    php artisan key:generate
    ```

6. Aktifkan XAMPP seperti pada gambar ini
    ![XAMPP](README/step1.png)

7. Jalankan perintah ini di terminal:
    ```bash
    php artisan migrate
    ```

8. Jika ada pesan seperti ini:
    > The database 'pisah' does not exist on the 'mysql' connection. Would you like to create it? (yes/no) [yes]
    klik enter


9. Selanjutnya jalankan perintah ini:
    ```bash
    php artisan db:seed
    ```

10. Atur file `.env` sesuai konfigurasi berikut:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pisah
    DB_USERNAME=root
    DB_PASSWORD=
    ```

11. Jalankan server Laravel:
    ```bash
    php artisan serve
    ```

12. Buka aplikasi di browser:
    [http://localhost:8000](http://localhost:8000)

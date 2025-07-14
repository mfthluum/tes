<?php
// FILE: proses_pendaftaran.php

// 1. Konfigurasi Database
$servername = "localhost"; // Biasanya localhost
$username = "root";        // Username default XAMPP/WAMP (ganti jika Anda punya user lain)
$password = "";            // Password default XAMPP/WAMP (kosong, ganti jika ada password)
$dbname = "db_pondok";     // Nama database yang sudah kita buat

// 2. Buat Koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// 3. Ambil Data dari Formulir (Pastikan Metode Adalah POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape string untuk mencegah SQL Injection
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']);
    $tempat_lahir = $conn->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $asal_sekolah = $conn->real_escape_string($_POST['asal_sekolah']);
    $nama_wali = $conn->real_escape_string($_POST['nama_wali']);
    $no_hp_wali = $conn->real_escape_string($_POST['no_hp_wali']);
    $email_wali = isset($_POST['email_wali']) ? $conn->real_escape_string($_POST['email_wali']) : NULL; // Opsional
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $pesan_tambahan = isset($_POST['pesan']) ? $conn->real_escape_string($_POST['pesan']) : NULL; // Opsional

    // 4. Buat Query SQL untuk Menyimpan Data
    $sql = "INSERT INTO pendaftaran_santri (nama_lengkap, tempat_lahir, tanggal_lahir, asal_sekolah, nama_wali, no_hp_wali, email_wali, alamat, pesan_tambahan)
            VALUES ('$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$asal_sekolah', '$nama_wali', '$no_hp_wali', ";
    
    // Tambahkan email_wali jika tidak NULL
    $sql .= ($email_wali !== NULL) ? "'$email_wali', " : "NULL, ";
    
    $sql .= "'$alamat', ";
    
    // Tambahkan pesan_tambahan jika tidak NULL
    $sql .= ($pesan_tambahan !== NULL) ? "'$pesan_tambahan')" : "NULL)";

    // 5. Jalankan Query dan Berikan Respon
    if ($conn->query($sql) === TRUE) {
        // Pendaftaran berhasil
        echo "<!DOCTYPE html>
              <html lang='id'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Pendaftaran Berhasil!</title>
                  <link rel='stylesheet' href='style.css'>
                  <link href='https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap' rel='stylesheet'>
                  <style>
                      body {
                          display: flex;
                          justify-content: center;
                          align-items: center;
                          min-height: 100vh;
                          background-color: var(--light-bg);
                          text-align: center;
                      }
                      .success-message {
                          background-color: white;
                          padding: 50px;
                          border-radius: var(--border-radius);
                          box-shadow: 0 8px 20px rgba(0,0,0,0.15);
                          max-width: 600px;
                          animation: fadeIn 0.8s ease-out;
                      }
                      .success-message h2 {
                          color: var(--primary-color);
                          font-size: 2.5rem;
                          margin-bottom: 20px;
                      }
                      .success-message p {
                          font-size: 1.2rem;
                          margin-bottom: 30px;
                      }
                  </style>
              </head>
              <body>
                  <div class='success-message fade-in appear'>
                      <h2><span style='color: green;'>&#10003;</span> Pendaftaran Berhasil!</h2>
                      <p>Terima kasih, data pendaftaran Anda telah kami terima.</p>
                      <p>Kami akan segera menghubungi Anda untuk informasi lebih lanjut.</p>
                      <a href='index.html' class='btn btn-primary'>Kembali ke Beranda</a>
                      <a href='pendaftaran.html' class='btn' style='background-color: #f0f0f0; color: var(--primary-color); margin-left: 10px;'>Daftar Lagi</a>
                  </div>
              </body>
              </html>";
    } else {
        // Terjadi error saat pendaftaran
        echo "<!DOCTYPE html>
              <html lang='id'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Pendaftaran Gagal!</title>
                  <link rel='stylesheet' href='style.css'>
                  <link href='https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap' rel='stylesheet'>
                  <style>
                      body {
                          display: flex;
                          justify-content: center;
                          align-items: center;
                          min-height: 100vh;
                          background-color: var(--light-bg);
                          text-align: center;
                      }
                      .error-message {
                          background-color: white;
                          padding: 50px;
                          border-radius: var(--border-radius);
                          box-shadow: 0 8px 20px rgba(0,0,0,0.15);
                          max-width: 600px;
                          animation: fadeIn 0.8s ease-out;
                      }
                      .error-message h2 {
                          color: red;
                          font-size: 2.5rem;
                          margin-bottom: 20px;
                      }
                      .error-message p {
                          font-size: 1.2rem;
                          margin-bottom: 30px;
                      }
                  </style>
              </head>
              <body>
                  <div class='error-message fade-in appear'>
                      <h2><span style='color: red;'>&#x2717;</span> Pendaftaran Gagal!</h2>
                      <p>Terjadi kesalahan saat menyimpan data Anda.</p>
                      <p>Silakan coba lagi atau hubungi administrator.</p>
                      <p>Error: " . $conn->error . "</p>
                      <a href='pendaftaran.html' class='btn btn-primary'>Coba Lagi</a>
                      <a href='index.html' class='btn' style='background-color: #f0f0f0; color: var(--primary-color); margin-left: 10px;'>Kembali ke Beranda</a>
                  </div>
              </body>
              </html>";
    }
} else {
    // Jika diakses langsung tanpa POST request
    header("Location: pendaftaran.html"); // Redirect kembali ke halaman pendaftaran
    exit();
}

// Tutup koneksi
$conn->close();
?>
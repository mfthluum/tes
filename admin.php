<?php
session_start(); // Mulai session untuk manajemen login

// --- DETAIL KONEKSI DATABASE ---
// Pastikan ini sesuai dengan konfigurasi XAMPP Anda.
$servername = "localhost";
$username = "root"; // Default username XAMPP
$password = "";     // Default password XAMPP (kosong)
$dbname = "db_pondok"; // NAMA DATABASE ANDA DARI SCREENSHOT

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$login_error = ""; // Variabel untuk pesan error login

// --- LOGIKA LOGIN ADMIN ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Username dan password yang VALID untuk login admin
    // GANTI DENGAN USERNAME DAN PASSWORD YANG AMAN UNTUK LINGKUNGAN PRODUKSI!
    $valid_username = "admin";
    $valid_password = "adminponpes2025"; // Anda bisa ubah ini

    if ($input_username === $valid_username && $input_password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $input_username;
        header("Location: admin.php"); // Redirect ke halaman admin.php setelah login berhasil
        exit;
    } else {
        $login_error = "Username atau password salah!";
    }
}

// --- LOGIKA LOGOUT ADMIN ---
if (isset($_GET['logout'])) {
    session_destroy(); // Hancurkan semua session
    header("Location: admin.php"); // Redirect kembali ke halaman login
    exit;
}

// --- TAMPILKAN HALAMAN LOGIN JIKA BELUM LOGIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin - Pondok Pesantren Fathul Hidayah As-Sab'ah</title>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <style>
            /* Gaya CSS untuk halaman Login */
            body {
                background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('images/bg.jpeg') no-repeat center center/cover;
                color: white;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                text-align: center;
            }
            .login-container {
                background-color: rgba(0,0,0,0.6);
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.5);
                max-width: 400px;
                width: 90%;
            }
            .login-container h1 {
                color: white;
                margin-bottom: 30px;
                font-size: 2.5rem;
            }
            .login-form-admin {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .login-form-admin input[type="text"],
            .login-form-admin input[type="password"] {
                padding: 12px;
                border: none;
                border-radius: 5px;
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
                font-size: 1rem;
                width: 100%;
                box-sizing: border-box;
            }
            .login-form-admin input[type="text"]::placeholder,
            .login-form-admin input[type="password"]::placeholder {
                color: rgba(255, 255, 255, 0.7);
            }
            .login-form-admin button {
                background-color: var(--primary-color);
                color: white;
                padding: 12px 25px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                font-size: 1.1rem;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }
            .login-form-admin button:hover {
                background-color: #15632a;
                transform: translateY(-2px);
            }
            .error-message {
                color: #e74c3c;
                margin-top: 15px;
                font-weight: bold;
                font-size: 1rem;
            }
            .back-to-home {
                display: inline-block;
                margin-top: 25px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-weight: bold;
                transition: color 0.3s ease;
            }
            .back-to-home:hover {
                color: var(--secondary-color);
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h1>Login Admin</h1>
            <form action="admin.php" method="POST" class="login-form-admin">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <?php if ($login_error): ?>
                    <div class="error-message"><?php echo $login_error; ?></div>
                <?php endif; ?>
            </form>
            <a href="index.html" class="back-to-home">Kembali ke Beranda</a>
        </div>
    </body>
    </html>
    <?php
    exit; // Hentikan eksekusi script setelah menampilkan form login
}

// --- TAMPILKAN HALAMAN DASHBOARD ADMIN JIKA SUDAH LOGIN ---
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pondok Pesantren Fathul Hidayah As-Sab'ah</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS khusus untuk halaman admin setelah login */
        body {
            background-color: #f4f7f6;
            color: var(--text-color);
            padding-top: 30px;
            padding-bottom: 50px;
        }
        .admin-dashboard-container {
            background-color: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 30px auto;
            text-align: left;
        }
        .admin-dashboard-container h1 {
            color: var(--primary-color);
            font-size: 2.8rem;
            margin-bottom: 25px;
            text-align: center;
        }
        .admin-dashboard-container p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .dashboard-actions {
            text-align: center;
            margin-bottom: 40px;
        }
        .dashboard-actions .btn {
            margin: 0 10px;
        }

        .data-table-container {
            overflow-x: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.95rem;
        }
        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
            vertical-align: top;
        }
        .data-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        .data-table tbody tr:nth-child(even) {
            background-color: #f0f0f0;
        }
        .data-table tbody tr:hover {
            background-color: #e9e9e9;
        }
        .data-table .action-buttons {
            display: flex;
            gap: 5px;
        }
        .data-table .action-buttons .btn-small {
            padding: 5px 10px;
            font-size: 0.8rem;
            border-radius: 5px;
            text-transform: none;
            font-weight: normal;
        }
        .btn-edit { background-color: #3498db; color: white; }
        .btn-edit:hover { background-color: #2980b9; }
        .btn-delete { background-color: #e74c3c; color: white; }
        .btn-delete:hover { background-color: #c0392b; }
        .no-data {
            text-align: center;
            padding: 30px;
            font-style: italic;
            color: #777;
        }

        @media (max-width: 768px) {
            .admin-dashboard-container {
                padding: 20px;
                margin: 20px auto;
            }
            .admin-dashboard-container h1 {
                font-size: 2rem;
            }
            .dashboard-actions {
                flex-direction: column;
                gap: 15px;
            }
            .dashboard-actions .btn {
                width: 100%;
            }
            .data-table th, .data-table td {
                padding: 8px 10px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-dashboard-container">
        <h1>Selamat Datang, Admin!</h1>
        <p>Ini adalah halaman manajemen data pendaftar.</p>

        <div class="dashboard-actions">
            <a href="?logout=true" class="btn btn-secondary-outline">Logout</a>
            <a href="index.html" class="btn btn-secondary-outline">Kembali ke Beranda</a>
        </div>

        <h2>Data Pendaftar</h2>
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Tanggal Lahir</th>
                        <th>Asal Sekolah</th>
                        <th>Nama Wali</th>
                        <th>No HP Wali</th>
                        <th>Email Wali</th>
                        <th>Alamat</th>
                        <th>Pesan Tambahan</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ambil data pendaftar dari tabel pendaftaran_santri
                    // Query SQL ini mengambil semua kolom yang ada di tabel Anda
                    $sql = "SELECT id, nama_lengkap, tanggal_lahir, asal_sekolah,
                            nama_wali, no_hp_wali, email_wali, alamat,
                            pesan_tambahan, tanggal_daftar
                            FROM pendaftaran_santri ORDER BY tanggal_daftar DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data dari setiap baris
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"]. "</td>";
                            echo "<td>" . htmlspecialchars($row["nama_lengkap"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["tanggal_lahir"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["asal_sekolah"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["nama_wali"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["no_hp_wali"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["email_wali"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["alamat"]). "</td>";
                            echo "<td>" . htmlspecialchars($row["pesan_tambahan"]). "</td>";
                            echo "<td>" . $row["tanggal_daftar"]. "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<span>No Action Yet</span>"; // Placeholder untuk tombol Edit/Delete di masa depan
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='no-data'>Belum ada data pendaftar.</td></tr>";
                    }
                    $conn->close(); // Tutup koneksi setelah selesai mengambil data
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Ini adalah kurung kurawal penutup untuk blok if (!isset($_SESSION['loggedin']))
// Pastikan hanya ada satu ini di akhir file.
?>
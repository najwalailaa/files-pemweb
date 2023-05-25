<!DOCTYPE html>
<html>
<head>
    <title>Form Data Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        ul {
            list-style-type: none;
            margin: 60px 0 0 0;
            padding: 0;
        }

        ul li {
            display: inline;
            margin-right: 10px;
        }

        ul li a {
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <?php
    // Fungsi untuk mengunggah foto cover ke direktori "uploads"
    function uploadFoto()
    {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["foto_cover"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid
        $check = getimagesize($_FILES["foto_cover"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File yang diunggah bukan gambar.";
            $uploadOk = 0;
        }

        // Cek apakah file sudah ada di server
        if (file_exists($targetFile)) {
            echo "File sudah ada di server.";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES["foto_cover"]["size"] > 500000) {
            echo "Ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        // Cek format file gambar
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            echo "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Jika semua pengecekan berhasil, upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["foto_cover"]["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
                return null;
            }
        } else {
            return null;
        }
    }

    // Memproses form jika data sudah dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mengambil nilai dari form
        $kodeBuku = $_POST["kode_buku"];
        $judulBuku = $_POST["judul_buku"];
        $pengarang = $_POST["pengarang"];
        $penerbit = $_POST["penerbit"];
        $tahunTerbit = $_POST["tahun_terbit"];
        $halaman = $_POST["halaman"];
        $kategori = $_POST["kategori"];

        // Mengunggah foto cover dan mendapatkan path file yang diunggah
        $fotoCover = uploadFoto();

        // Memastikan file foto berhasil diunggah sebelum menyimpan data buku
        if ($fotoCover) {
            // Menyusun data buku yang akan disimpan
            $dataBuku = $kodeBuku . "|" . $judulBuku . "|" . $pengarang . "|" . $penerbit . "|" . $tahunTerbit . "|" . $halaman . "|" . $kategori . "|" . $fotoCover . "\n";

            // Menyimpan data buku ke file "buku.txt"
            $file = fopen("buku.txt", "a");
            fwrite($file, $dataBuku);
            fclose($file);

            echo "Data buku berhasil disimpan.";
        }
    }
    ?>
    <ul>
        <li><a href="tampil.php">Lihat Data</a></li>
    </ul>
    <h1>Form Data Buku</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
        <label for="kode_buku">Kode Buku:</label><br>
        <input type="text" id="kode_buku" name="kode_buku" required><br><br>

        <label for="judul_buku">Judul Buku:</label><br>
        <input type="text" id="judul_buku" name="judul_buku" required><br><br>

        <label for="pengarang">Pengarang:</label><br>
        <input type="text" id="pengarang" name="pengarang" required><br><br>

        <label for="penerbit">Penerbit:</label><br>
        <input type="text" id="penerbit" name="penerbit" required><br><br>

        <label for="tahun_terbit">Tahun Terbit:</label><br>
        <input type="text" id="tahun_terbit" name="tahun_terbit" required><br><br>

        <label for="halaman">Halaman:</label><br>
        <input type="text" id="halaman" name="halaman" required><br><br>

        <label for="kategori">Kategori:</label><br>
        <input type="text" id="kategori" name="kategori" required><br><br>

        <label for="foto_cover">Foto Cover:</label><br>
        <input type="file" id="foto_cover" name="foto_cover" required><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>

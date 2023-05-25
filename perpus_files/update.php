<?php
// Memproses form jika data sudah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil kode buku yang akan diupdate
    $kodeBukuToUpdate = $_POST["kode_buku"];

    // Mengambil nilai dari form
    $kodeBuku = $_POST["kode_buku"];
    $judulBuku = $_POST["judul_buku"];
    $pengarang = $_POST["pengarang"];
    $penerbit = $_POST["penerbit"];
    $tahunTerbit = $_POST["tahun_terbit"];
    $halaman = $_POST["halaman"];
    $kategori = $_POST["kategori"];

    // Membaca data buku dari file "buku.txt"
    $file = fopen("buku.txt", "r+");
    $tempFile = tmpfile();

    while (!feof($file)) {
        $line = fgets($file);
        $data = explode("|", $line);

        if (count($data) == 8 && $data[0] == $kodeBukuToUpdate) {
            $data[0] = $kodeBuku;
            $data[1] = $judulBuku;
            $data[2] = $pengarang;
            $data[3] = $penerbit;
            $data[4] = $tahunTerbit;
            $data[5] = $halaman;
            $data[6] = $kategori;
            $line = implode("|", $data) . "\n";
        }

        fwrite($tempFile, $line);
    }

    fseek($file, 0);
    ftruncate($file, 0);

    fseek($tempFile, 0);
    while (!feof($tempFile)) {
        $line = fgets($tempFile);
        fwrite($file, $line);
    }

    fclose($file);
    fclose($tempFile);

    // Redirect kembali ke halaman tampil.php setelah mengupdate data
    header("Location: tampil.php");
    exit();
}

// Mengambil kode buku yang akan diupdate dari parameter URL
$kodeBukuToUpdate = $_GET["kode_buku"];

// Membaca data buku yang akan diupdate dari file "buku.txt"
$file = fopen("buku.txt", "r");
while (!feof($file)) {
    $line = fgets($file);
    $data = explode("|", $line);

    if (count($data) == 8 && $data[0] == $kodeBukuToUpdate) {
        $kodeBuku = $data[0];
        $judulBuku = $data[1];
        $pengarang = $data[2];
        $penerbit = $data[3];
        $tahunTerbit = $data[4];
        $halaman = $data[5];
        $kategori = $data[6];
        break;
    }
}
fclose($file);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Data Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #ffffff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Update Data Buku</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="kode_buku" value="<?php echo $kodeBuku; ?>">

        <label for="judul_buku">Judul Buku:</label><br>
        <input type="text" id="judul_buku" name="judul_buku" value="<?php echo $judulBuku; ?>" required><br><br>

        <label for="pengarang">Pengarang:</label><br>
        <input type="text" id="pengarang" name="pengarang" value="<?php echo $pengarang; ?>" required><br><br>

        <label for="penerbit">Penerbit:</label><br>
        <input type="text" id="penerbit" name="penerbit" value="<?php echo $penerbit; ?>" required><br><br>

        <label for="tahun_terbit">Tahun Terbit:</label><br>
        <input type="text" id="tahun_terbit" name="tahun_terbit" value="<?php echo $tahunTerbit; ?>" required><br><br>

        <label for="halaman">Halaman:</label><br>
        <input type="text" id="halaman" name="halaman" value="<?php echo $halaman; ?>" required><br><br>

        <label for="kategori">Kategori:</label><br>
        <input type="text" id="kategori" name="kategori" value="<?php echo $kategori; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>

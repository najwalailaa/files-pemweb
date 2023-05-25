<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        h1 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #ffffff;
            border: 1px solid #dddddd;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #dddddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: #ffffff;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        a {
            text-decoration: none;
            color: #000000;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #dddddd;
        }

        a:hover {
            background-color: #cccccc;
        }
    </style>
</head>
<body>    
    <?php
            if (isset($_GET['statusdelete'])) {
                $status = $_GET['statusdelete'];
                if ($status == "success") {
                    echo '<br><br><div class="alert alert-success" role="alert">Data berhasil dihapus</div>';
                  }
                  elseif($status=='notsuccess'){
                    echo '<br><br><div class="alert alert-danger" role="alert">Data gagal dihapus</div>';
                  }
            }
            ?>
    <h1>Data Buku</h1>
    <table>
        <tr>
            <th>Kode Buku</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Halaman</th>
            <th>Kategori</th>
            <th>Foto Cover</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Membaca data buku dari file "buku.txt"
        $file = fopen("buku.txt", "r");
        while (!feof($file)) {
            $line = fgets($file);
            $data = explode("|", $line);

            if (count($data) == 8) {
                $kodeBuku = $data[0];
                $judulBuku = $data[1];
                $pengarang = $data[2];
                $penerbit = $data[3];
                $tahunTerbit = $data[4];
                $halaman = $data[5];
                $kategori = $data[6];
                $fotoCover = $data[7];
        ?>
        <tr>
            <td><?php echo $kodeBuku; ?></td>
            <td><?php echo $judulBuku; ?></td>
            <td><?php echo $pengarang; ?></td>
            <td><?php echo $penerbit; ?></td>
            <td><?php echo $tahunTerbit; ?></td>
            <td><?php echo $halaman; ?></td>
            <td><?php echo $kategori; ?></td>
            <td><img src="<?php echo $fotoCover; ?>" alt="Foto Cover"></td>
            <td>
                <a href="update.php?kode_buku=<?php echo $kodeBuku; ?>">Update</a>
                <a href="delete.php?kode_buku=<?php echo $kodeBuku; ?>">Delete</a>
            </td>
        </tr>
        <?php
            }
        }
        fclose($file);
        ?>
    </table>
</body>
</html>

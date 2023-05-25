<?php
if (isset($_GET['kode_buku'])) {
    // Menerima kode buku yang akan dihapus
    $kode_buku = $_GET['kode_buku'];

    // Membaca data dari file buku.txt
    $bukuData = file('buku.txt');

    // Menghapus data buku yang sesuai dengan kode buku
    foreach ($bukuData as $key => $data) {
        $buku = explode("\t", $data);
        if ($buku[0] == $kode_buku) {
            unset($bukuData[$key]);
            break;
        }
    }

    // Menyimpan data yang telah dihapus ke dalam file buku.txt
    $result = file_put_contents('buku.txt', implode("", $bukuData));

    if ($result !== false) {
        // Data buku berhasil disimpan
        header("Location: tampil.php?statusdelete=success");
        exit();
    } else {
        // Gagal menyimpan data buku
        header("Location: tampil.php?statusdelete=notsuccess");
        exit();
    }
}
?>

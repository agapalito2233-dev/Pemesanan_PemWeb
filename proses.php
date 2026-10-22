<?php
// Daftar menu dan harga (array asosiatif)
$daftarMenu = [
    "Nasi Goreng" => 15000,
    "Mie Ayam"    => 12000,
];

$errors = [];
$nama = $menu = "";
$jumlah = 0;

// Hanya terima request POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

// Ambil data dari form
$nama   = trim($_POST["nama"] ?? "");
$menu   = $_POST["menu"] ?? "";
$jumlah = $_POST["jumlah"] ?? "";

// Validasi ulang di sisi server (validasi JavaScript bisa dilewati)
if ($nama === "") {
    $errors[] = "Nama wajib diisi.";
} elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal 3 karakter.";
} elseif (!preg_match("/^[A-Za-z\s]+$/", $nama)) {
    $errors[] = "Nama hanya boleh berisi huruf.";
}

if (!array_key_exists($menu, $daftarMenu)) {
    $errors[] = "Menu tidak valid.";
}

if ($jumlah === "" || filter_var($jumlah, FILTER_VALIDATE_INT) === false) {
    $errors[] = "Jumlah harus berupa bilangan bulat.";
} elseif ((int)$jumlah < 1 || (int)$jumlah > 100) {
    $errors[] = "Jumlah harus antara 1 sampai 100.";
}

// Perhitungan (hanya jika tidak ada error)
if (empty($errors)) {
    $jumlah   = (int)$jumlah;
    $harga    = $daftarMenu[$menu];
    $subtotal = $harga * $jumlah;

    // Percabangan: diskon 10% jika subtotal >= Rp100.000
    if ($subtotal >= 100000) {
        $diskon = $subtotal * 0.10;
    } else {
        $diskon = 0;
    }
    $total = $subtotal - $diskon;
}

function rupiah($angka) {
    return "Rp" . number_format($angka, 0, ",", ".");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hasil Pesanan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <h1>Hasil Pesanan</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert">
        <strong>Pesanan gagal diproses:</strong>
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php else: ?>
      <p>Terima kasih, <strong><?= htmlspecialchars($nama) ?></strong>! Pesanan Anda:</p>
      <table class="hasil">
        <tr><td>Menu</td><td><?= htmlspecialchars($menu) ?></td></tr>
        <tr><td>Harga satuan</td><td><?= rupiah($harga) ?></td></tr>
        <tr><td>Jumlah</td><td><?= $jumlah ?></td></tr>
        <tr><td>Subtotal</td><td><?= rupiah($subtotal) ?></td></tr>
        <tr><td>Diskon</td><td><?= rupiah($diskon) ?></td></tr>
        <tr class="total"><td>Total bayar</td><td><?= rupiah($total) ?></td></tr>
      </table>
    <?php endif; ?>

    <a class="kembali" href="index.html">&larr; Kembali ke form</a>
  </div>
</body>
</html>

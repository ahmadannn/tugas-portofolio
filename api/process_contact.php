<?php
// Menerima request dari AJAX
header('Content-Type: application/json');

// Mencegah error jika mengakses langsung melalui browser tanpa metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Validasi sederhana
    if(empty($name) || empty($email) || empty($message)){
        echo json_encode([
            'status' => 'error',
            'message' => 'Semua kolom wajib diisi!'
        ]);
        exit;
    }

    // Di sini pada kondisi nyata, gunakan fungsi mail() atau simpan ke Database (MySQL)
    
    // --- FITUR BARU: Menyimpan data ke dalam file teks (TXT) agar mudah dicek oleh Anda ---
    $fileBackupPesan = __DIR__ . '/kumpulan_pesan.txt'; // Disimpan pada folder rujukan 'api/kumpulan_pesan.txt'
    $isiPesanLog = "==============================\n";
    $isiPesanLog .= "Waktu: " . date("Y-m-d H:i:s") . "\n";
    $isiPesanLog .= "Nama Pengirim: $name\n";
    $isiPesanLog .= "Email: $email\n";
    $isiPesanLog .= "Isi Pesan: $message\n";
    $isiPesanLog .= "==============================\n\n";

    // Fungsi otomatis membuat file txt dan mem-paste datanya di belakang tulisan lama (FILE_APPEND)
    file_put_contents($fileBackupPesan, $isiPesanLog, FILE_APPEND);
    // ---------------------------------------------------------------------------------------

    // Sebagai bahan simulasi respons ke Frontend (AJAX Response)
    echo json_encode([
        'status' => 'success',
        'message' => "Hore! Terima kasih {$name}. Backend PHP telah menerima pesan Anda dan menyimpannya di server."
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Hanya menerima request metode POST (AJAX)!'
    ]);
}
?>

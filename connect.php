<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "tests");

// Periksa koneksi
if (mysqli_connect_error()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data dari formulir
$inputData = json_decode(file_get_contents("php://input"), true);
$nama = $inputData['nama'];
$alamat = $inputData['alamat'];
$nomor_hp = $inputData['noHp'];
$shoppingCart = $inputData['shoppingCart'];

// Masukkan data ke dalam tabel 'form_data'
$sql = "INSERT INTO form_data (nama, alamat, nomor_hp) VALUES ('$nama', '$alamat', '$nomor_hp')";
if (mysqli_query($koneksi, $sql)) {
    $user_id = mysqli_insert_id($koneksi);

    // Insert shopping cart data into 'user_cart' table
    foreach ($shoppingCart as $cartItem) {
        $productName = $cartItem['name'];
        $productPrice = $cartItem['price'];
        $productImage = $cartItem['image'];
        $quantity = $cartItem['quantity'];

        $cartInsertSql = "INSERT INTO user_cart (user_id, product_name, product_price, product_image, quantity)
                          VALUES ('$user_id', '$productName', '$productPrice', '$productImage', '$quantity')";

        mysqli_query($koneksi, $cartInsertSql);
    }

    // Send a response to the client
    $response = ['success' => true, 'user_id' => $user_id];
    echo json_encode($response);
} else {
    // Send an error response to the client
    echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
}

// Tutup koneksi
mysqli_close($koneksi);
?>

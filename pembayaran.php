<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            background: radial-gradient(#fff, #ffd6d6); /* Tambahkan latar belakang radial-gradient di sini */
        }

        form {
            background-color: white; /* Optional: Memberi latar belakang putih pada formulir */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Masukkan Foto/Screenshot Bukti Pembayaran</h1>

    <?php
    // Check if the 'id' parameter is set in the URL
    $idFormData = isset($_GET['id']) ? $_GET['id'] : null;
    ?>

    <form action="upload.php?id=<?php echo $idFormData; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <input type="submit" value="Upload">
    </form>
</body>

</html>

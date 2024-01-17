<?php
if (isset($_FILES['image']['name'])) {
    // Database connection
    $db = new PDO('mysql:host=localhost;dbname=tests', 'root', '');

    // Retrieve the ID from the URL
    $idFormData = isset($_GET['id']) ? $_GET['id'] : null;

    // Check if the form data ID is present
    if (!$idFormData) {
        echo "Form data ID is missing.";
        exit;
    }

    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageType = $_FILES['image']['type'];

    // Insert the image data along with the form data ID
    $stmt = $db->prepare("INSERT INTO images (id_form_data, image_data, image_type) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $idFormData);
    $stmt->bindParam(2, $imageData, PDO::PARAM_LOB);
    $stmt->bindParam(3, $imageType);

    if ($stmt->execute()) {
          // Successful upload, redirect to index.html
          echo '<script>alert("Bukti pembayaran telah kami terima! Terima kasih telah berbelanja!"); window.location.href = "index.html";</script>';
    } else {
        echo "Error uploading image: " . $stmt->errorInfo()[2];
    }
} else {
    echo "Please select an image to upload.";
}
?>
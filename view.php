<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 30px;
            padding: 30px;
            text-align: center;
            background: radial-gradient(#fff, #ffd6d6);
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
            margin-top: 20px;
            border-radius: 15px;
            overflow: hidden;
            background-color: #fff; /* White background for the table */
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: center; /* Center-align text */
            padding: 8px;
        }

        th {
            background-color: #f2f2f2; /* Light grey background for the table header */
        }

        img {
            max-width: 100px;
            height: auto;
            cursor: pointer;
            display: block;
            margin: 0 auto; /* Center-align images */
        }

        .view-cart {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        #myModal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px; /* Updated padding-top value */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        #modalContent {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }

        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        #cartModal {
            display: none;
            position: fixed;
            z-index: 2;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        #cartContent {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }

        #cartCaption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        .cartClose {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        h1 {
            font-weight: bold; /* Make the heading bold */
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<h1>Data Customer</h1>

<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tests";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data from form_data and images tables
$sql = "SELECT form_data.id, form_data.nama, form_data.alamat, form_data.nomor_hp, images.image_data
        FROM form_data
        JOIN images ON form_data.id = images.id_form_data";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>
            <tr>
                <th>ID</th>
                <th>Nama Customer</th>
                <th>Alamat</th>
                <th>Nomor HP</th>
                <th>Bukti Pembayaran</th>
                <th>Action</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['nama'] . '</td>
                <td>' . $row['alamat'] . '</td>
                <td>' . $row['nomor_hp'] . '</td>
                <td><img src="data:image/jpeg;base64,' . base64_encode($row['image_data']) . '" alt="Customer Image" onclick="openModal(\'data:image/jpeg;base64,' . base64_encode($row['image_data']) . '\', \'' . $row['nama'] . '\')"></td>
                <td><button type="button" class="btn btn-primary" onclick="openCartModal(' . $row['id'] . ')">Lihat Cart</button></td>
              </tr>';
    }

    echo '</table>';
} else {
    echo "No data found";
}

$conn->close();
?>

<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalContent" src="" alt="Modal Image">
    <div id="caption"></div>
</div>

<div id="cartModal" class="modal">
    <span class="cartClose" onclick="closeCartModal()">&times;</span>
    <div id="cartContent">
        <!-- Cart data will be displayed here -->
    </div>
    <div id="cartCaption"></div>
</div>

<script>
    function openModal(imgSrc, caption) {
        document.getElementById("modalContent").src = imgSrc;
        document.getElementById("caption").innerHTML = caption;
        document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    function openCartModal(userId) {
        console.log("Open Cart Modal for user ID:", userId);

        // AJAX call to fetch cart data HTML content
        $.ajax({
            type: "GET",
            url: "get_cart_data.php",
            data: { user_id: userId },
            success: function (data) {
                // Update #cartContent with the received HTML content
                document.getElementById("cartContent").innerHTML = data;

                // Display the cart modal
                document.getElementById("cartModal").style.display = "block";
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    function closeCartModal() {
        document.getElementById("cartModal").style.display = "none";
    }
</script>

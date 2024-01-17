<?php
// get_cart_data.php

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Perform database query to retrieve cart data for the given user_id
    // Replace the following with your actual database connection and query

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tests";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM user_cart WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Quantity</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['product_name'] . '</td>
                    <td>' . $row['product_price'] . '</td>
                    <td>' . $row['quantity'] . '</td>
                  </tr>';
        }

        echo '</table>';
    } else {
        echo "No cart data found for user_id: $userId";
    }

    $conn->close();
} else {
    echo "Invalid user_id parameter";
}
?>

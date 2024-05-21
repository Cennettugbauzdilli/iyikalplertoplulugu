<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "donation_db";

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT first_name, last_name, address, phone, email, image_path FROM requests";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Verileri diziye ekle
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>

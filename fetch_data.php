<?php
include 'db.php';

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

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

// Form verilerini al
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$gsm = $_POST['gsm'];
$email = $_POST['email'];
$city = $_POST['city'];
$country = $_POST['country'];
$district = $_POST['district'];
$address = $_POST['address'];

// Veritabanına ekle
$sql = "INSERT INTO volunteers (first_name, last_name, phone, gsm, email, city, country, district, address) 
        VALUES ('$first_name', '$last_name', '$phone', '$gsm', '$email', '$city', '$country', '$district', '$address')";

if ($conn->query($sql) === TRUE) {
    echo "Başvuru başarılı!";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

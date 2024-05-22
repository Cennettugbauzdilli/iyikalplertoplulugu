<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $amount = $_POST['donation-amount'];
    $email = $_POST['donation-email'];

    // Veritabanı bağlantısı
    $servername = "localhost";  // veya sunucu adresi
    $username = "root";         // MySQL kullanıcı adı
    $password = "";             // MySQL şifresi
    $dbname = "donation_db";    // Veritabanı adı

    // Bağlantı oluşturma
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL sorgusu hazırlama
    $stmt = $conn->prepare("INSERT INTO donations (amount, email) VALUES (?, ?)");
    $stmt->bind_param("ds", $amount, $email);

    // Sorguyu çalıştır ve sonucu kontrol et
    if ($stmt->execute()) {
        echo "Donation successfully recorded!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Bağlantıyı kapat
    $stmt->close();
    $conn->close();
}
?>

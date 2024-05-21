
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    // Fotoğraf yükleme işlemi
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["toy-image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Dosya tipi kontrolü
    $check = getimagesize($_FILES["toy-image"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Dosya zaten varsa
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Dosya boyutu kontrolü
    if ($_FILES["toy-image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // İzin verilen dosya formatları
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Hata kontrolü
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["toy-image"]["tmp_name"], $targetFile)) {
            echo "The file ". basename( $_FILES["toy-image"]["name"]). " has been uploaded.";

            // Veritabanı bağlantısı
    $servername = "localhost";  // veya sunucu adresi
    $username = "root";         // MySQL kullanıcı adı
    $password = "12345";             // MySQL şifresi
    $dbname = "donation_db";    // Veritabanı adı

            // Bağlantı oluşturma
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Bağlantıyı kontrol et
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL sorgusu hazırlama
            $stmt = $conn->prepare("INSERT INTO requests (first_name, last_name, address, phone, email, image_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $firstName, $lastName, $address, $phone, $email, $targetFile);

            // Sorguyu çalıştır ve sonucu kontrol et
            if ($stmt->execute()) {
                echo "Request successfully recorded!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Bağlantıyı kapat
            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

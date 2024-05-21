<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$table = $_GET['table'];
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = array_keys($_POST);
    $values = array_values($_POST);

    $set = "";
    for ($i = 0; $i < count($fields); $i++) {
        $set .= "$fields[$i] = ?";
        if ($i < count($fields) - 1) {
            $set .= ", ";
        }
    }

    $sql = "UPDATE $table SET $set WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $types = str_repeat("s", count($fields)) . "i"; // Tüm alanlar için string tipi, son alan için integer tipi
    $values[] = $id; // ID'yi ekliyoruz
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    header("Location: admin_panel.php");
    exit();
}

$sql = "SELECT * FROM $table WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Edit Record</h2>
        <?php foreach ($data as $key => $value): ?>
            <?php if ($key != 'id'): ?>
                <label><?php echo ucfirst($key); ?>:</label>
                <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><br><br>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Update</button>
    </form>
</body>
</html>

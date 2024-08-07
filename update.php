<?php
include 'koneksi.php';

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nama'])) {
    $nama = trim($_GET['nama']);
    $sql = "SELECT * FROM rpl22 WHERE nama=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === FALSE) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Record not found");
    }
    $stmt->close();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $umur = intval(trim($_POST['umur']));
    $kelas = trim($_POST['kelas']);

    $sql = "UPDATE rpl22 SET umur=?, kelas=? WHERE nama=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === FALSE) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("iss", $umur, $kelas, $nama);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Siswa</title>
</head>
<body>
    <h2>Update Siswa</h2>
    <form method="POST" action="update.php">
        <input type="hidden" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>">
        Nama: <input type="text" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required><br><br>
        Umur: <input type="number" name="umur" value="<?php echo htmlspecialchars($row['umur']); ?>" required><br><br>
        Kelas: <input type="text" name="kelas" value="<?php echo htmlspecialchars($row['kelas']); ?>" required><br><br>
        <input type="submit" value="Update">
    </form>
    <a href="index.php">Back to Home</a>
</body>
</html>

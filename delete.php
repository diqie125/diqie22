<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nama'])) {
    $nama = trim($_GET['nama']);
    $sql = "DELETE FROM rpl22 WHERE nama=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Siswa</title>
</head>
<body>
    <h2>Delete Siswa</h2>
    <p>Record has been deleted.</p>
    <a href="index.php">Back to Home</a>
</body>
</html>

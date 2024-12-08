<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pelaporan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input data
$pelapor = $conn->real_escape_string($_POST['pelapor']);
$kepemilikan = $conn->real_escape_string($_POST['kepemilikan']);
$kategori_industri = $conn->real_escape_string($_POST['kategori_industri']);
$nama_industri = $conn->real_escape_string($_POST['nama_industri']);
$tanggal_berdiri = $conn->real_escape_string($_POST['tanggal_berdiri']);
$latitude = $conn->real_escape_string($_POST['latitude']);
$longitude = $conn->real_escape_string($_POST['longitude']);

// Insert data into the database
$sql = "INSERT INTO industri (pelapor, kepemilikan, kategori_industri, nama_industri, tanggal_berdiri, latitude, longitude) VALUES ('$pelapor', '$kepemilikan', '$kategori_industri', '$nama_industri', '$tanggal_berdiri', '$latitude', '$longitude')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
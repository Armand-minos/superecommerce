<?php
$servername = "localhost"; // Remplacez par votre serveur
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "ecommerce"; // Remplacez par le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données
$sql = "SELECT * FROM dashboard";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Retourner les données au format JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
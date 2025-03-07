<?php
$host = 'localhost'; // Hôte
$db = 'ecommerce';   // Nom de la base
$user = 'root';      // Nom utilisateur
$pass = '';          // Mot de passe

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<?php
$host = 'localhost'; // ou votre hôte
$db = 'ecommerce'; // Remplacez par votre nom de base de données
$user = 'root'; // Remplacez par votre nom d'utilisateur
$pass = ''; // Remplacez par votre mot de passe

header('Content-Type: application/json');

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les ventes
    $sql = "SELECT id_vente, client_id, montant_total, date_vente, dashboard_id FROM vente";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupérer les données
    $ventes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données au format JSON
    echo json_encode($ventes);

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
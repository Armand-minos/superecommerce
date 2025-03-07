<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['client_id'])) {
    die("Vous devez être connecté pour valider une commande.");
}

// Récupérer le client_id
$client_id = $_POST['client_id'];

// Ici, vous pouvez ajouter la logique pour créer une commande
// Par exemple, insérer les données dans une table de commandes

// Suppression des articles du panier après validation
$sql = "DELETE FROM panier WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();

// Vérifier si la suppression a réussi
if ($stmt->affected_rows > 0) {
    echo "Votre commande a été validée avec succès !";
} else {
    echo "Erreur lors de la validation de la commande.";
}

// Fermer la connexion
$conn->close();
?>
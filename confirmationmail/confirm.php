<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'ecommerce';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['token']) && isset($_GET['confirmation_code'])) {
    $token = $_GET['token'];
    $confirmation_code = $_GET['confirmation_code'];

    // Vérifier si le token existe
    $stmt = $pdo->prepare("SELECT * FROM email_confirmations WHERE token = ? AND confirmation_code = ?");
    $stmt->execute([$token, $confirmation_code]);
    $confirmation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($confirmation) {
        // Vérifier si la confirmation est expirée
        if (new DateTime() > new DateTime($confirmation['expiresAt'])) {
            echo "Le lien de confirmation a expiré.";
        } else {
            // Mettre à jour l'utilisateur pour confirmer son email
            $stmt = $pdo->prepare("UPDATE utilisateur SET email_confirmations_id = NULL WHERE id = ?");
            $stmt->execute([$confirmation['utilisateur_id']]);
            echo "Votre email a été confirmé avec succès.";
        }
    } else {
        echo "Le token ou le code de confirmation est invalide.";
    }
}
?>

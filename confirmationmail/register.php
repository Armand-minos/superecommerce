<?php
require 'vendor/autoload.php'; // Inclure PHPMailer

// Connexion à la base de données
$host = 'localhost';
$dbname = 'ecommerce';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Sécuriser le mot de passe
    $role = 'user'; // Par défaut 'user'

    // Vérification si l'email existe déjà dans la base de données
    $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE mail = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // Si l'email existe déjà, afficher un message d'erreur
        echo "Ce mail est déjà associé à un compte.";
    } else {
        // Si l'email n'existe pas, insérer l'utilisateur dans la table `utilisateur`
        $stmt = $pdo->prepare("INSERT INTO utilisateur (role, mail, mdp) VALUES (?, ?, ?)");
        $stmt->execute([$role, $email, $password]);
        $userId = $pdo->lastInsertId(); // Récupérer l'ID de l'utilisateur nouvellement inséré

        // Générer un token de confirmation
        $token = bin2hex(random_bytes(16));
        $confirmation_code = bin2hex(random_bytes(8)); // Code de confirmation pour le lien

        // Si dashboard_id peut être NULL, passez NULL ici
        $dashboard_id = NULL; // Utilisation de NULL ou une valeur par défaut existante dans votre table `dashboard`

        // Insérer la confirmation dans la table `email_confirmations`
        $stmt = $pdo->prepare("INSERT INTO email_confirmations (utilisateur_id, token, expiresAt, confirmation_code, dashboard_id) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 DAY), ?, ?)");
        $stmt->execute([$userId, $token, $confirmation_code, $dashboard_id]);
        $confirmationId = $pdo->lastInsertId(); // Récupérer l'ID de la confirmation

        // Mettre à jour l'utilisateur avec l'ID de confirmation
        $stmt = $pdo->prepare("UPDATE utilisateur SET email_confirmations_id = ? WHERE id = ?");
        $stmt->execute([$confirmationId, $userId]);

        // PHPMailer: envoyer l'email de confirmation
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Utilisez votre serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'armand.moisan08@gmail.com'; // Votre email
        $mail->Password = 'cpjb rmss qpqq iwyq'; // Votre mot de passe d'application Gmail ou mot de passe
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Paramètres de l'email
        $mail->setFrom('votreemail@gmail.com', 'Nom de votre site');
        $mail->addAddress($email); // L'adresse de l'utilisateur
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre inscription';
        $mail->Body    = "Bonjour,<br><br>Merci de vous être inscrit sur notre site. Veuillez confirmer votre inscription en cliquant sur le lien ci-dessous:<br><br>" .
                         "<a href='http://localhost/confirmation.php?token=$token&confirmation_code=$confirmation_code'>Cliquez ici pour confirmer votre email</a><br><br>" .
                         "Cordialement,<br> L'équipe.";

        // Envoi de l'email
        if ($mail->send()) {
            echo "Un email de confirmation a été envoyé à $email.";
        } else {
            echo "Erreur lors de l'envoi de l'email de confirmation.";
        }
    }
} else {
    // Affichage du formulaire si la méthode n'est pas POST
    ?>
    <form method="POST" action="register.php">
        <input type="email" name="email" placeholder="Votre email" required>
        <input type="password" name="password" placeholder="Votre mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
    <?php
}
?>

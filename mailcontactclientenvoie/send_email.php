<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Charge PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomClient = htmlspecialchars($_POST['nomClient']);
    $emailClient = htmlspecialchars($_POST['emailClient']);
    $adresseClient = htmlspecialchars($_POST['adresseClient']);
    $numCommande = htmlspecialchars($_POST['numCommande']);
    $numSuivi = htmlspecialchars($_POST['numSuivi']);

    // Configuration entreprise
    $entreprise = "Nom de l'entreprise";
    $adresseEntreprise = "Adresse de l'entreprise";
    $emailEntreprise = "votreemail@gmail.com";

    // Initialisation de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Remplacez par votre serveur SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'armand.moisan08@gmail.com'; // Remplacez par votre email
        $mail->Password   = 'cpjb rmss qpqq iwyq'; // Remplacez par votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // Port SMTP

        // Destinataires
        $mail->setFrom($emailEntreprise, $entreprise);
        $mail->addAddress($emailClient, $nomClient);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Suivi de votre commande - $numCommande";
        $mail->Body    = "
            <html>
            <head>
                <title>Suivi de votre commande</title>
            </head>
            <body>
                <h2>Bonjour $nomClient,</h2>
                <p>Merci pour votre commande chez <strong>$entreprise</strong>.</p>
                <p>Voici les détails de votre commande :</p>
                <ul>
                    <li><strong>Numéro de commande :</strong> $numCommande</li>
                    <li><strong>Numéro de suivi :</strong> $numSuivi</li>
                    <li><strong>Adresse de livraison :</strong> $adresseClient</li>
                </ul>
                <p>Suivez votre colis ici : <a href='https://tracking.example.com?num=$numSuivi'>Suivre mon colis</a></p>
                <br>
                <p><strong>$entreprise</strong><br>$adresseEntreprise<br>Email : $emailEntreprise</p>
            </body>
            </html>";

        $mail->send();
        echo "Email envoyé avec succès à $emailClient !";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}
?>

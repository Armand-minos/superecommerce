<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Chargement de PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécurisation des entrées utilisateur
    $nomClient = htmlspecialchars(trim($_POST['nomClient']));
    $emailClient = filter_var($_POST['emailClient'], FILTER_VALIDATE_EMAIL);
    $adresseClient = htmlspecialchars(trim($_POST['adresseClient']));
    $numCommande = htmlspecialchars(trim($_POST['numCommande']));
    $numSuivi = htmlspecialchars(trim($_POST['numSuivi']));
    
    // Vérification de l'email
    if (!$emailClient) {
        die("Email client invalide !");
    }

    // Configuration entreprise
    $entreprise = "Nom de l'Entreprise";
    $adresseEntreprise = "123 Rue Exemple, 75000 Paris";
    $emailEntreprise = "votreemail@gmail.com"; // Remplacer par l'email de l'entreprise
    $siretEntreprise = "SIRET : 0150 0000 25644 65 874"; // Numéro SIRET
    $capitalEntreprise = "Capital : 15 000€"; // Capital de l'entreprise
    $logoPath = "logo.png"; // Assurez-vous que le fichier logo.png existe

    // Initialisation de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Désactivation du mode debug SMTP
        $mail->SMTPDebug = 0;  // Désactive le débogage

        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'armand.moisan08@gmail.com'; // Remplacez par votre email
        $mail->Password = 'cpjb rmss qpqq iwyq'; // Remplacez par votre mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom($emailEntreprise, $entreprise);
        $mail->addAddress($emailClient, $nomClient);

        // Ajout du logo en pièce jointe
        if (file_exists($logoPath)) {
            $mail->AddEmbeddedImage($logoPath, 'logo_cid', 'logo.png');
        }

        // Ajouter une pièce jointe PDF si le fichier est téléchargé
        if (isset($_FILES['facture']) && $_FILES['facture']['error'] == UPLOAD_ERR_OK) {
            $pdfPath = $_FILES['facture']['tmp_name'];
            $pdfName = $_FILES['facture']['name'];
            $mail->addAttachment($pdfPath, $pdfName);
        }

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Suivi de votre commande - $numCommande";
        $mail->Body = "
            <html>
            <head>
                <title>Suivi de votre commande</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; }
                    .container { padding: 20px; max-width: 600px; margin: auto; }
                    .details { background: #f9f9f9; padding: 10px; border-radius: 5px; }
                    .signature { font-size: 14px; color: #666; }
                    hr { border: 0; height: 2px; background: linear-gradient(to right, #ccc, #000, #ccc); margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Bonjour $nomClient,</h2>
                    <p>Merci pour votre commande chez <strong>$entreprise</strong>.</p>
                    <p>Voici les détails de votre commande :</p>

                    <div class='details'>
                        <p><strong>Numéro de commande :</strong> $numCommande</p>
                        <p><strong>Numéro de suivi :</strong> $numSuivi</p>
                        <p><strong>Adresse de livraison :</strong> $adresseClient</p>
                    </div>

                    <p>suivez votre colis ici : <a href='https://tracking.example.com?num=$numSuivi'>Suivre mon colis</a></p>

                    <hr>

                    <table class='signature' width='100%'>
                        <tr>
                            <td width='120'>
                                <img src='cid:logo_cid' alt='Logo' width='100' style='border-radius: 5px;'>
                            </td>
                            <td>
                                <p><strong>$entreprise</strong></p>
                                <p> $adresseEntreprise</p>
                                <p><a href='mailto:$emailEntreprise'>$emailEntreprise</a></p>
                                <p>$siretEntreprise</p>
                                <p>$capitalEntreprise</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </body>
            </html>";

        // Envoi de l'email
        $mail->send();
        echo "Email envoyé avec succès à $emailClient !";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}
?>

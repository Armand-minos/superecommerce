<?php
session_start();
include 'db.php'; // Fichier de connexion à la base de données

if (isset($_POST['validate_cart'])) {
    $client_id = $_SESSION['client_id'];
    $adresse_livraison = $_POST['adresse_livraison'];
    $montant_total = $_POST['montant_total'];
    $method_payment = $_POST['method_payment'];
    $status = 'En cours';
    $date = date('Y-m-d H:i:s');

    // 1. Enregistrement dans la table commandes
    $numero_commandes = uniqid('CMD_');
    $query_commande = "INSERT INTO commandes (client_id, date_heure, status, numero_commandes, adresse_livraison, dashboard_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_commande = $conn->prepare($query_commande);
    $stmt_commande->execute([$client_id, $date, $status, $numero_commandes, $adresse_livraison, 1]);
    $commande_id = $conn->lastInsertId();

    // 2. Enregistrement des produits dans la table panier
    foreach ($_SESSION['panier'] as $produit_id => $details) {
        $quantite = $details['quantite'];
        $prix_ttc = $details['prix'];
        $total_ttc = $quantite * $prix_ttc;
        $tva = $total_ttc * 0.2; // TVA à 20%
        $frais_livraison = 5.00; // Exemple de frais fixes

        $query_panier = "INSERT INTO panier (client_id, produit_id, quantite, prix_ttc, tva, frais_livraison, total_ttc, dashboard_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_panier = $conn->prepare($query_panier);
        $stmt_panier->execute([$client_id, $produit_id, $quantite, $prix_ttc, $tva, $frais_livraison, $total_ttc, 1]);
    }

    // 3. Enregistrement du paiement dans la table payment
    $stripe_payment_id = uniqid('PAY_');
    $query_payment = "INSERT INTO payment (user_id, client_id, montant_payemnt, euro, stripe_payment_id, status, date_heure_transaction, date_heure_maj, description, method_payment, commandes_id, panier_id, dashboard_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_payment = $conn->prepare($query_payment);
    $stmt_payment->execute([$_SESSION['user_id'], $client_id, $montant_total, 'EUR', $stripe_payment_id, $status, $date, $date, 'Paiement pour commande', $method_payment, $commande_id, 0, 1]);

    // 4. Création de la facture
    $facture_id = uniqid('FAC_'); // Générer un ID de facture unique
    $query_facture = "INSERT INTO factures (facture_id, client_id, montant_total, date_facture, status, commandes_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_facture = $conn->prepare($query_facture);
    $stmt_facture->execute([$facture_id, $client_id, $montant_total, $date, 'En cours', $commande_id]);

    unset($_SESSION['panier']);
    header('Location: confirmation.php');
    exit();
}
?>

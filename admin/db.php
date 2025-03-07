<?php
$host = 'localhost'; // ou votre hôte
$db = 'ecommerce';
$user = 'root';
$pass = '';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Début de la transaction
    $pdo->beginTransaction();

    // Insertion dans la table client
    $sqlClient = "INSERT INTO client (nom, prenom, adresse, ville, code_postal, mail, utilisateur_id, payment_id, commandes_id, facture_id, dashboard_id) 
                  VALUES (:nom, :prenom, :adresse, :ville, :code_postal, :mail, :utilisateur_id, :payment_id, :commandes_id, :facture_id, :dashboard_id)";

    $stmtClient = $pdo->prepare($sqlClient);
    $stmtClient->execute([
        ':nom' => 'Dupont',
        ':prenom' => 'Jean',
        ':adresse' => '123 Rue de Paris',
        ':ville' => 'Paris',
        ':code_postal' => '75001',
        ':mail' => 'jean.dupont@example.com',
        ':utilisateur_id' => null,
        ':payment_id' => 1,
        ':commandes_id' => null,
        ':facture_id' => null,
        ':dashboard_id' => 1
    ]);
    $client_id = $pdo->lastInsertId();

    // Insertion dans la table commandes
    $sqlCommandes = "INSERT INTO commandes (client_id, facture_id, date_heure, status, numero_commandes, adresse_livraison, dashboard_id) 
                     VALUES (:client_id, :facture_id, :date_heure, :status, :numero_commandes, :adresse_livraison, :dashboard_id)";

    $stmtCommandes = $pdo->prepare($sqlCommandes);
    $stmtCommandes->execute([
        ':client_id' => $client_id,
        ':facture_id' => null,
        ':date_heure' => date('Y-m-d H:i:s'),
        ':status' => 'En attente',
        ':numero_commandes' => 'CMD123456',
        ':adresse_livraison' => '123 Rue de Paris, 75001 Paris',
        ':dashboard_id' => 1
    ]);
    $commandes_id = $pdo->lastInsertId();

    // Insertion dans la table panier
    $sqlPanier = "INSERT INTO panier (client_id, produit_id, quantite, prix_ttc, tva, frais_livraison, total_ttc, stock_id, dashboard_id) 
                  VALUES (:client_id, :produit_id, :quantite, :prix_ttc, :tva, :frais_livraison, :total_ttc, :stock_id, :dashboard_id)";

    $stmtPanier = $pdo->prepare($sqlPanier);
    $stmtPanier->execute([
        ':client_id' => $client_id,
        ':produit_id' => 1,
        ':quantite' => 2,
        ':prix_ttc' => 20.00,
        ':tva' => 4.00,
        ':frais_livraison' => 5.00,
        ':total_ttc' => 25.00,
        ':stock_id' => null,
        ':dashboard_id' => 1
    ]);
    $panier_id = $pdo->lastInsertId();

    // Insertion dans la table payment
    $sqlPayment = "INSERT INTO payment (user_id, client_id, montant_payemnt, euro, stripe_payment_id, status, date_heure_transaction, date_heure_maj, description, method_payment, commandes_id, facture_id, panier_id, dashboard_id) 
                   VALUES (:user_id, :client_id, :montant_payemnt, :euro, :stripe_payment_id, :status, :date_heure_transaction, :date_heure_maj, :description, :method_payment, :commandes_id, :facture_id, :panier_id, :dashboard_id)";

    $stmtPayment = $pdo->prepare($sqlPayment);
    $stmtPayment->execute([
        ':user_id' => 1,
        ':client_id' => $client_id,
        ':montant_payemnt' => 25.00,
        ':euro' => 'EUR',
        ':stripe_payment_id' => 'stripe_123456',
        ':status' => 'Succès',
        ':date_heure_transaction' => date('Y-m-d H:i:s'),
        ':date_heure_maj' => date('Y-m-d H:i:s'),
        ':description' => 'Achat de produits',
        ':method_payment' => 'Carte de crédit',
        ':commandes_id' => $commandes_id,
        ':facture_id' => null,
        ':panier_id' => $panier_id,
        ':dashboard_id' => 1
    ]);

    // Valider la transaction
    $pdo->commit();

    echo "Données insérées avec succès.";
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    $pdo->rollBack();
    echo "Erreur lors de l'insertion : " . $e->getMessage();
}
?>

<?php
session_start();
require 'db.php'; // Fichier de connexion à la base de données

// Ajout au panier
if (isset($_POST['produit_id'], $_POST['quantite'], $_POST['prix_ttc'])) {
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];
    $prix_ttc = $_POST['prix_ttc'];
    $tva = 20.00; // Exemple de TVA
    $frais_livraison = 5.00; // Exemple frais de livraison
    $total_ttc = ($prix_ttc * $quantite) + $frais_livraison;

    $stmt = $conn->prepare("INSERT INTO panier (produit_id, quantite, prix_ttc, tva, frais_livraison, total_ttc, dashboard_id, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$produit_id, $quantite, $prix_ttc, $tva, $frais_livraison, $total_ttc, 1, 0]);
}

// Suppression d'un produit du panier
if (isset($_GET['supprimer_id'])) {
    $supprimer_id = $_GET['supprimer_id'];
    $stmt = $conn->prepare("DELETE FROM panier WHERE id = ?");
    $stmt->execute([$supprimer_id]);
}



// Validation de la commande
if (isset($_POST['valider_commande'])) {
    $date_heure = date('Y-m-d H:i:s');
    $status = 'En attente';
    $adresse_livraison = $_POST['adresse_livraison'];
    $numero_commandes = 'CMD' . time();

    $conn->prepare("INSERT INTO commandes (client_id, date_heure, status, numero_commandes, adresse_livraison, dashboard_id) VALUES (?, ?, ?, ?, ?, ?)")
        ->execute([0, $date_heure, $status, $numero_commandes, $adresse_livraison, 1]);

    $commande_id = $conn->lastInsertId();

    foreach ($panier as $item) {
        $conn->prepare("UPDATE panier SET client_id = ?, dashboard_id = ? WHERE id = ?")
            ->execute([0, 1, $item['id']]);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<h1>Votre Panier</h1>

<?php if (!empty($panier)): ?>
    <table>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix TTC</th>
            <th>Total TTC</th>
            <th>Supprimer</th>
        </tr>
        <?php foreach ($panier as $item): ?>
            <tr>
                <td>
                    <?php
                    // Si l'image est vide, on affiche une image par défaut
                    $image = empty($item['image']) ? 'default.jpg' : $item['image'];
                    ?>
                    <img src="images/<?= $image; ?>" alt="<?= $item['reference']; ?>" style="width:50px; height:50px;">
                    <?= $item['reference']; ?>
                </td>
                <td><?= $item['quantite']; ?></td>
                <td><?= $item['prix_ttc']; ?>€</td>
                <td><?= $item['total_ttc']; ?>€</td>
                <td><a href="?supprimer_id=<?= $item['id']; ?>">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Votre panier est vide.</p>
<?php endif; ?>

<form method="POST">
    <label for="adresse_livraison">Adresse de livraison :</label>
    <input type="text" name="adresse_livraison" required>
    <button type="submit" name="valider_commande">Valider la commande</button>
</form>
</body>
</html>

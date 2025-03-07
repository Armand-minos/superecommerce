<?php
include("");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include("../admin/db.php");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ecommerce;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
</head>
<body>
<h1>Votre Panier</h1>
<table border="1">
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>Total</th>
    </tr>
    <?php
    if (!empty($_SESSION['panier'])) {
        $total = 0;
        foreach ($_SESSION['panier'] as $produit) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($produit['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($produit['quantite']) . "</td>";
            echo "<td>" . htmlspecialchars($produit['prix']) . "€</td>";
            echo "<td>" . htmlspecialchars($produit['quantite'] * $produit['prix']) . "€</td>";
            echo "</tr>";
            $total += $produit['quantite'] * $produit['prix'];
        }
        echo "<tr>
                <td colspan='3'><strong>Total</strong></td>
                <td><strong>$total €</strong></td>
              </tr>";
    } else {
        echo "<tr><td colspan='4'>Votre panier est vide.</td></tr>";
    }
    ?>
</table>
</body>
</html>

<?php
session_start();

// Affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation du panier
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajout d'un produit au panier
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $_SESSION['panier'][$id] = [
        'name' => $name,
        'price' => $price,
        'quantity' => isset($_SESSION['panier'][$id]) ? $_SESSION['panier'][$id]['quantity'] + 1 : 1
    ];
    
    echo json_encode($_SESSION['panier']);
    exit;
}

// Suppression d'un produit
if (isset($_POST['action']) && $_POST['action'] == 'remove') {
    $id = $_POST['id'];
    unset($_SESSION['panier'][$id]);
    echo json_encode($_SESSION['panier']);
    exit;
}

// Calcul du prix total
$total = 0;
foreach ($_SESSION['panier'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Fonction pour obtenir les frais de livraison via l'API Colissimo
function getColissimoShippingCost($weight, $destination) {
    $api_url = "https://api.laposte.fr/shipping/v1/price"; // URL de l'API Colissimo
    $api_key = "VOTRE_CLE_API"; // Remplacez par votre clé API

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-API-KEY: $api_key",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "weight" => $weight,
        "destination" => $destination
    ]));

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    return isset($data['price']) ? $data['price'] : 0; // Retourne le prix ou 0 en cas d'erreur
}

// Traitement de la validation de la commande
if (isset($_POST['action']) && $_POST['action'] == 'validate') {
    // Ici, vous pouvez traiter la commande (par exemple, enregistrer dans une base de données)
    // Pour l'exemple, nous allons juste vider le panier
    $_SESSION['panier'] = [];
    $message = "Votre commande a été validée avec succès !";
}

// Calcul des frais de livraison
$shipping_cost = 0;
if (isset($_POST['shipping'])) {
    $weight = 0.5; // Poids fictif (à ajuster selon vos produits)
    $destination = $_POST['shipping']; // Destination fictive (à ajuster selon vos besoins)
    
    if ($_POST['shipping'] == 'colissimo') {
        $shipping_cost = getColissimoShippingCost($weight, $destination);
    } elseif ($_POST['shipping'] == 'express') {
        $shipping_cost = 10.00; // Coût pour livraison express
    } else {
        $shipping_cost = 5.00; // Coût pour livraison standard
    }
}

// Calcul du total avec frais de livraison
$total_with_shipping = $total + $shipping_cost;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .cart-item { margin-bottom: 10px; }
        .cart-item button { margin-left: 10px; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function removeItem(id) {
            $.post("panier.php", { action: "remove", id: id }, function(response) {
                location.reload();
            }, "json");
        }
    </script>
</head>
<body>
    <h1>Votre Panier</h1>
    <div id="cart">
        <?php if (empty($_SESSION['panier'])): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['panier'] as $id => $item): ?>
                <div class="cart-item">
                    <?= htmlspecialchars($item['name']) ?> - <?= number_format($item['price'], 2) ?>€ x <?= $item['quantity'] ?>
                    <button onclick="removeItem('<?= $id ?>')">Supprimer</button>
                </div>
            <?php endforeach; ?>
            <div>
                <strong>Total: <?= number_format($total, 2) ?>€</strong>
            </div>
            <div>
                <strong>Frais de livraison: <?= number_format($shipping_cost, 2) ?>€</strong>
            </div>
            <div>
                <strong>Total avec livraison: <?= number_format($total_with_shipping, 2) ?>€</strong>
            </div>
        <?php endif; ?>
    </div>

    <h2>Ajouter un produit</h2>
    <form method="post" action="panier.php">
        <input type="hidden" name="id" value ="1">
        <input type="hidden" name="name" value="Produit 1">
        <input type="hidden" name="price" value="10.00">
        <button type="submit" name="action" value="add">Ajouter Produit 1 (10.00€)</button>
    </form>
    <form method="post" action="panier.php">
        <input type="hidden" name="id" value="2">
        <input type="hidden" name="name" value="Produit 2">
        <input type="hidden" name="price" value="20.00">
        <button type="submit" name="action" value="add">Ajouter Produit 2 (20.00€)</button>
    </form>

    <?php if (!empty($_SESSION['panier'])): ?>
        <h2>Choix de livraison</h2>
        <form method="post" action="panier.php">
            <label for="shipping">Mode de livraison:</label>
            <select name="shipping" id="shipping">
                <option value="standard">Livraison standard (5.00€)</option>
                <option value="express">Livraison express (10.00€)</option>
                <option value="colissimo">Colissimo</option>
            </select>
            <button type="submit" name="action" value="validate">Valider la commande</button>
        </form>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</body>
</html>
<?php
include 'db.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorieProduit = $_POST['categorie_produit'];
    $avisId = $_POST['avis_id'];
    $dashboardId = $_POST['dashboard_id'];
    $type = $_POST['type'];  // savon, savon_liquide, shampoon
    $name = $_POST['name'];
    $image = $_POST['image'];
    $poids = $_POST['poids'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $prixTTC = $_POST['prix_ttc'];
    $stockQuantite = $_POST['quantite_disponible'];
    $seuilAlerte = $_POST['seuil_alerte'];

    try {
        $pdo->beginTransaction();

        // 1. Ajouter dans la table produits
        $stmt = $pdo->prepare("INSERT INTO produits (categorie_produit, avis_id, references_articles_id, dashboard_id) 
            VALUES (?, ?, ?, ?)");
        $stmt->execute([$categorieProduit, $avisId, null, $dashboardId]);
        $produitId = $pdo->lastInsertId();

        // 2. Ajouter dans la table stock
        $stmt = $pdo->prepare("INSERT INTO stock (produit_id, quantite_disponible, seuil_alerte, date_derniere_maj, dashboard_id) 
            VALUES (?, ?, ?, NOW(), ?)");
        $stmt->execute([$produitId, $stockQuantite, $seuilAlerte, $dashboardId]);

        // 3. Ajouter dans la table correspondante selon le type
        $referenceId = null;
        if ($type == 'savon') {
            // Ajout dans la table savon
            $stmt = $pdo->prepare("INSERT INTO savon (produit_id, image, nom, poids, description, ingredients, prix_ttc, avis_id, dashboard_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$produitId, $image, $name, $poids, $description, $ingredients, $prixTTC, $avisId, $dashboardId]);
            $referenceId = $pdo->lastInsertId();
        } elseif ($type == 'savon_liquide') {
            // Ajout dans la table savon_liquide
            $stmt = $pdo->prepare("INSERT INTO savon_liquid (produit_id, image, nom, volume, description, ingredients, prix_ttc, avis_id, dashboard_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$produitId, $image, $name, $poids, $description, $ingredients, $prixTTC, $avisId, $dashboardId]);
            $referenceId = $pdo->lastInsertId();
        } elseif ($type == 'shampoon') {
            // Ajout dans la table shampoon
            $stmt = $pdo->prepare("INSERT INTO shampoon (produit_id, image, nom, volume, description, ingredients, prix_ttc, avis_id, dashboard_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$produitId, $image, $name, $poids, $description, $ingredients, $prixTTC, $avisId, $dashboardId]);
            $referenceId = $pdo->lastInsertId();
        }

        // 4. Mettre à jour la référence dans la table produits
        $stmt = $pdo->prepare("UPDATE produits SET references_articles_id = ? WHERE id = ?");
        $stmt->execute([$referenceId, $produitId]);

        $pdo->commit();
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }

    exit;
}


// Chargement des produits
$query = $pdo->query("SELECT * FROM references_articles");
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        #product-list {
            margin: 20px;
        }
        button {
            margin-left: 10px;
        }
        #product-form {
            display: none;
            margin: 20px;
        }
    </style>
</head>
<body>
<h1>Gestion des Produits</h1>
<div id="product-list">
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <div>
                <span><?php echo htmlspecialchars($product['reference']); ?> (<?php echo htmlspecialchars($product['type_article']); ?>)</span>
                <button onclick="editProduct(<?php echo $product['id']; ?>)">Modifier</button>
                <button onclick="deleteProduct(<?php echo $product['id']; ?>)">Supprimer</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun produit trouvé.</p>
    <?php endif; ?>
</div>
<button id="add-product">Ajouter un produit</button>

<div id="product-form">
    <h2 id="form-title">Ajouter un produit</h2>
    <input type="hidden" id="product-id">
    <label for="product-name">Nom du produit:</label>
    <input type="text" id="product-name" required>
    <label for="product-type">Type de produit:</label>
    <select id="product-type">
        <option value="savon">Savon</option>
        <option value="savon_liquide">Savon Liquide</option>
        <option value="shampoon">Shampoon</option>
    </select>
    <button id="save-product">Enregistrer</button>
    <button id="cancel">Annuler</button>
</div>

<script>
    document.getElementById('add-product').addEventListener('click', function () {
        document.getElementById('product-form').style.display = 'block';
        document.getElementById('form-title').innerText = 'Ajouter un produit';
        document.getElementById('product-id').value = '';
        document.getElementById('product-name').value = '';
    });

    document.getElementById('cancel').addEventListener('click', function () {
        document.getElementById('product-form').style.display = 'none';
    });

    document.getElementById('save-product').addEventListener('click', function () {
        const id = document.getElementById('product-id').value;
        const name = document.getElementById('product-name').value;
        const type = document.getElementById('product-type').value;

        const formData = new FormData();
        formData.append('name', name);
        formData.append('type', type);

        if (id) {
            formData.append('id', id);
            formData.append('update', '1');
        } else {
            formData.append('add', '1');
        }

        fetch('', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Erreur: ' + data.error);
                } else {
                    location.reload();
                }
            });
    });

    function deleteProduct(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('delete', '1');

            fetch('', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Erreur: ' + data.error);
                    } else {
                        location.reload();
                    }
                });
        }
    }
</script>
</body>
</html>

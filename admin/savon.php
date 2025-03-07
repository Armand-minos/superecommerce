<?php
include 'db.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

// Gestion des actions AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'];
    $savonData = $data['data'];

    try {
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO savon (produit_id, image, nom, poids, description, ingredients, prix_ttc, avis_id, reference_id, dashboard_id) VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?, ?)");
            $stmt->execute([38, $savonData['image'], $savonData['nom'], $savonData['poids'], $savonData['description'], $savonData['ingredients'], $savonData['prix'], 30, 1]);
        } elseif ($action === 'update') {
            $stmt = $pdo->prepare("UPDATE savon SET image = ?, nom = ?, poids = ?, description = ?, ingredients = ?, prix_ttc = ? WHERE id = ?");
            $stmt->execute([$savonData['image'], $savonData['nom'], $savonData['poids'], $savonData['description'], $savonData['ingredients'], $savonData['prix'], $savonData['id']]);
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM savon WHERE id = ?");
            $stmt->execute([$savonData['id']]);
        }
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit; // Terminer le script après le traitement de la requête AJAX
}

// Chargement des savons
$query = $pdo->query("SELECT * FROM savon");
$savons = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Gestion des Savons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            margin-left: 10px;
        }
        #savon-form {
            display: none;
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Gestion des Savons</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Poids</th>
                <th>Image</th>
                <th>Description</th>
                <th>Ingrédients</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="savon-list">
            <?php foreach ($savons as $savon): ?>
                <tr>
                    <td><?php echo htmlspecialchars($savon['nom']); ?></td>
                    <td><?php echo htmlspecialchars($savon['poids']); ?></td>
                    <td><?php echo htmlspecialchars($savon['image']); ?></td>
                    <td><?php echo htmlspecialchars($savon['description']); ?></td>
                    <td><?php echo htmlspecialchars($savon['ingredients']); ?></td>
                    <td><?php echo htmlspecialchars($savon['prix_ttc']); ?> €</td>
                    <td>
                        <button onclick="editSavon(<?php echo $savon['id']; ?>)">Modifier</button>
                        <button onclick="deleteSavon(<?php echo $savon['id']; ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button id="add-savon">Ajouter un Savon</button>

    <div id="savon-form">
        <h2 id="form-title">Ajouter un Savon</h2>
        <input type="hidden" id="savon-id">
        <label for="savon-nom">Nom du Savon:</label>
        <input type="text" id="savon-nom" required>
        <label for="savon-image">Image:</label>
        <input type="text" id="savon-image" required>
        <label for="savon-poids">Poids:</label>
        <input type="text" id="savon-poids" required>
        <label for="savon-description">Description:</label>
        <input type="text" id="savon-description" required>
        <label for="savon-ingredients">Ingrédients:</label>
        <input type="text" id="savon-ingredients" required>
        <label for="savon-prix">Prix:</label>
        <input type="text" id="savon-prix" required>
        <button id="save-savon">Enregistrer</button>
        <button id="cancel">Annuler</button>
    </div>

    <script>
        document.getElementById('add-savon').addEventListener('click', function() {
            document.getElementById('savon-form').style.display = 'block';
            document.getElementById('form-title').innerText = 'Ajouter un Savon';
            document.getElementById('savon-id').value = '';
            document.getElementById('savon-nom').value = '';
            document.getElementById('savon-image').value = '';
            document.getElementById('savon-poids').value = '';
            document.getElementById('savon-description').value = '';
            document.getElementById('savon-ingredients').value = '';
            document.getElementById('savon-prix').value = '';
        });

        document.getElementById('cancel').addEventListener('click', function() {
            document.getElementById('savon-form').style.display = 'none';
        });

        document.getElementById('save-savon').addEventListener('click', function() {
            const id = document.getElementById('savon-id').value;
            const nom = document.getElementById('savon-nom').value;
            const image = document.getElementById('savon-image').value;
            const poids = document.getElementById('savon-poids').value;
            const description = document.getElementById('savon-description').value;
            const ingredients = document.getElementById('savon-ingredients').value;
            const prix = document.getElementById('savon-prix').value;

            const action = id ? 'update' : 'add';
            const data = { id, nom, image, poids, description, ingredients, prix };

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action, data })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Erreur: ' + data.error);
                } else {
                    loadSavons();
                    document.getElementById('savon-form').style.display = 'none';
                }
            });
        });

        function loadSavons() {
            fetch('')
                .then(response => response.json())
                .then(data => {
                    const savonList = document.getElementById('savon-list');
                    savonList.innerHTML = '';
                    data.forEach(savon => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${savon.nom}</td>
                            <td>${savon.poids}</td>
                            <td>${savon.image}</td>
                            <td>${savon.description}</td>
                            <td>${savon.ingredients}</td>
                            <td>${savon.prix_ttc} €</td>
                            <td>
                                <button onclick="editSavon(${savon.id})">Modifier</button>
                                <button onclick="deleteSavon(${savon.id})">Supprimer</button>
                            </td>
                        `;
                        savonList.appendChild(row);
                    });
                });
        }

        function editSavon(id) {
            fetch(`get_savon.php?id=${id}`)
                .then(response => response.json())
                .then(savon => {
                    document.getElementById('savon-id').value = savon.id;
                    document.getElementById('savon-nom').value = savon.nom;
                    document.getElementById('savon-image').value = savon.image;
                    document.getElementById('savon-poids').value = savon.poids;
                    document.getElementById('savon-description').value = savon.description;
                    document.getElementById('savon-ingredients').value = savon.ingredients;
                    document.getElementById('savon-prix').value = savon.prix_ttc;
                    document.getElementById('savon-form').style.display = 'block';
                    document.getElementById('form-title').innerText = 'Modifier le Savon';
                });
        }

        function deleteSavon(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce savon ?')) {
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ action: 'delete', data: { id } })
                })
                .then(response => response.json())
                .then(data => {
                    loadSavons();
                });
            }
        }

        // Charger les savons au chargement de la page
        loadSavons();
    </script>
</body>
</html>
<?php
include 'db.php'; // Connexion à la base de données

// Ajouter un nouvel enregistrement dans le stock
if (isset($_POST['add_stock'])) {
    $quantiteDisponible = $_POST['quantite_disponible'];
    $seuilAlerte = $_POST['seuil_alerte'];

    // Validation des données
    if (empty($quantiteDisponible) || empty($seuilAlerte)) {
        echo json_encode(['status' => 'error', 'message' => 'Tous les champs sont requis.']);
        exit;
    }

    try {
        // Insertion d'un nouvel enregistrement
        $stmt = $pdo->prepare("INSERT INTO stock (quantite_disponible, seuil_alerte, date_derniere_maj) 
            VALUES (?, ?, NOW())");
        $stmt->execute([$quantiteDisponible, $seuilAlerte]);
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // En cas d'erreur de base de données, capturez l'erreur et affichez le message
        echo json_encode(['status' => 'error', 'message' => 'Erreur d\'insertion dans la base de données: ' . $e->getMessage()]);
    }
    exit;
}

// Modifier un enregistrement du stock
if (isset($_POST['update_stock'])) {
    $stockId = $_POST['stock_id'];
    $quantiteDisponible = $_POST['quantite_disponible'];
    $seuilAlerte = $_POST['seuil_alerte'];

    // Validation des données
    if (empty($quantiteDisponible) || empty($seuilAlerte)) {
        echo json_encode(['status' => 'error', 'message' => 'Tous les champs sont requis.']);
        exit;
    }

    try {
        // Mise à jour du stock
        $stmt = $pdo->prepare("UPDATE stock 
                               SET quantite_disponible = ?, seuil_alerte = ?, date_derniere_maj = NOW() 
                               WHERE id = ?");
        $stmt->execute([$quantiteDisponible, $seuilAlerte, $stockId]);
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // En cas d'erreur de base de données, capturez l'erreur et affichez le message
        echo json_encode(['status' => 'error', 'message' => 'Erreur de mise à jour dans la base de données: ' . $e->getMessage()]);
    }
    exit;
}

// Supprimer un enregistrement du stock
if (isset($_POST['delete_stock'])) {
    $stockId = $_POST['stock_id'];

    try {
        // Suppression du stock
        $stmt = $pdo->prepare("DELETE FROM stock WHERE id = ?");
        $stmt->execute([$stockId]);
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // En cas d'erreur de base de données, capturez l'erreur et affichez le message
        echo json_encode(['status' => 'error', 'message' => 'Erreur de suppression dans la base de données: ' . $e->getMessage()]);
    }
    exit;
}

// Charger tous les stocks
$query = $pdo->query("SELECT * FROM stock");
$stocks = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .btn {
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 5px;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
        }
        .btn-edit {
            background-color: #FF9800;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .form-container {
            margin-top: 20px;
            display: none;
        }
        .form-container input {
            padding: 8px;
            margin: 5px;
        }
        .form-container button {
            padding: 8px 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Gestion du Stock</h1>

    <button class="btn btn-add" id="addStockBtn">Ajouter un Stock</button>

    <div class="form-container" id="stockForm">
        <h3 id="formTitle">Ajouter un Stock</h3>
        <input type="hidden" id="stockId">
        <label for="quantiteDisponible">Quantité Disponible:</label>
        <input type="number" id="quantiteDisponible" required>
        <label for="seuilAlerte">Seuil d'Alerte:</label>
        <input type="number" id="seuilAlerte" required>
        <button class="btn" id="saveStockBtn">Enregistrer</button>
        <button class="btn" id="cancelBtn">Annuler</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Quantité Disponible</th>
                <th>Seuil d'Alerte</th>
                <th>Date Dernière Mise à Jour</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="stockTableBody">
            <?php foreach ($stocks as $stock): ?>
                <tr data-id="<?= $stock['id'] ?>">
                    <td><?= $stock['id'] ?></td>
                    <td><?= $stock['quantite_disponible'] ?></td>
                    <td><?= $stock['seuil_alerte'] ?></td>
                    <td><?= $stock['date_derniere_maj'] ?></td>
                    <td>
                        <button class="btn btn-edit" onclick="editStock(<?= $stock['id'] ?>)">Modifier</button>
                        <button class="btn btn-delete" onclick="deleteStock(<?= $stock['id'] ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        const addStockBtn = document.getElementById('addStockBtn');
        const stockForm = document.getElementById('stockForm');
        const stockTableBody = document.getElementById('stockTableBody');
        const saveStockBtn = document.getElementById('saveStockBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        addStockBtn.addEventListener('click', () => {
            stockForm.style.display = 'block';
            document.getElementById('formTitle').innerText = 'Ajouter un Stock';
            document.getElementById('stockId').value = '';
            document.getElementById('quantiteDisponible').value = '';
            document.getElementById('seuilAlerte').value = '';
        });

        cancelBtn.addEventListener('click', () => {
            stockForm.style.display = 'none';
        });

        saveStockBtn.addEventListener('click', () => {
            const stockId = document.getElementById('stockId').value;
            const quantiteDisponible = document.getElementById('quantiteDisponible').value;
            const seuilAlerte = document.getElementById('seuilAlerte').value;

            if (!quantiteDisponible || !seuilAlerte) {
                alert('Tous les champs sont requis.');
                return;
            }

            let formData = new FormData();
            formData.append('quantite_disponible', quantiteDisponible);
            formData.append('seuil_alerte', seuilAlerte);

            if (stockId) {
                formData.append('update_stock', 1);
                formData.append('stock_id', stockId);
            } else {
                formData.append('add_stock', 1);
            }

            fetch('stock.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'enregistrement du stock');
            });
        });

        function editStock(id) {
            const row = document.querySelector(`tr[data-id='${id}']`);
            const quantiteDisponible = row.children[1].textContent;
            const seuilAlerte = row.children[2].textContent;

            document.getElementById('formTitle').innerText = 'Modifier le Stock';
            document.getElementById('stockId').value = id;
            document.getElementById('quantiteDisponible').value = quantiteDisponible;
            document.getElementById('seuilAlerte').value = seuilAlerte;

            stockForm.style.display = 'block';
        }

        function deleteStock(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce stock ?')) {
                let formData = new FormData();
                formData.append('delete_stock', 1);
                formData.append('stock_id', id);

                fetch('stock.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>

<?php
include 'db.php';

// Récupérer les factures
$stmt = $pdo->query("SELECT * FROM facture");
$factures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Factures</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Client ID</th>
        <th>Numéro de Facture</th>
        <th>Montant TTC</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($factures as $facture): ?>
    <tr>
        <td><?php echo $facture['id']; ?></td>
        <td><?php echo $facture['client_id']; ?></td>
        <td><?php echo $facture['numero_facture']; ?></td>
        <td><?php echo $facture['montant_ttc']; ?></td>
        <td>
            <button onclick="editFacture(<?php echo $facture['id']; ?>)">Modifier</button>
            <button onclick="deleteFacture(<?php echo $facture['id']; ?>)">Supprimer</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Formulaire pour ajouter une nouvelle facture -->
<h3>Ajouter une nouvelle facture</h3>
<form id="addFactureForm">
    <label for="client_id">Client ID:</label>
    <input type="text" id="client_id" name="client_id" required>
    <label for="montant_ht">Montant HT:</label>
    <input type="text" id="montant_ht" name="montant_ht" required>
    <button type="submit">Ajouter</button>
</form>

<script>
document.getElementById('addFactureForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_facture.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadContent('factures'); // Recharge la liste des factures
    });
});
</script>
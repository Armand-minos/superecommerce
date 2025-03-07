<?php
include 'db.php';

// Récupérer les clients
$stmt = $pdo->query("SELECT * FROM client");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Clients</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($clients as $client): ?>
    <tr>
        <td><?php echo $client['id']; ?></td>
        <td><?php echo $client['nom']; ?></td>
        <td>
            <button onclick="editClient(<?php echo $client['id']; ?>)">Modifier</button>
            <button onclick="deleteClient(<?php echo $client['id']; ?>)">Supprimer</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Formulaire pour ajouter un nouveau client -->
<h3>Ajouter un nouveau client</h3>
<form id="addClientForm">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required>
    <button type="submit">Ajouter</button>
</form>

<script>
document.getElementById('addClientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_client.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadContent('clients'); // Recharge la liste des clients
    });
});
</script>
<?php
include 'db.php';

// Récupérer les utilisateurs
$stmt = $pdo->query("SELECT * FROM utilisateur");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Utilisateurs</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Description du Rôle</th>
        <th>Client ID</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($utilisateurs as $utilisateur): ?>
    <tr>
        <td><?php echo $utilisateur['id']; ?></td>
        <td><?php echo $utilisateur['mail']; ?></td>
        <td><?php echo $utilisateur['role']; ?></td>
        <td><?php echo $utilisateur['role_description']; ?></td>
        <td><?php echo $utilisateur['client_id']; ?></td>
        <td>
            <button onclick="editUtilisateur(<?php echo $utilisateur['id']; ?>)">Modifier</button>
            <button onclick="deleteUtilisateur(<?php echo $utilisateur['id']; ?>)">Supprimer</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Ajouter un nouvel utilisateur</h3>
<form id="addUtilisateurForm">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="role">Rôle:</label>
    <select id="role" name="role" required>
        <option value="admin">Admin</option>
        <option value="user">Utilisateur</option>
        <option value="gestionnaire">Gestionnaire</option>
    </select>
    
    <label for="role_description">Description du Rôle:</label>
    <input type="text" id="role_description" name="role_description" required>
    
    <label for="client_id">Client ID (laisser vide pour Admin/Gestionnaire):</label>
    <input type="number" id="client_id" name="client_id">
    
    <label for="dashboard_id">Dashboard ID:</label>
    <input type="number" id="dashboard_id" name="dashboard_id" required>
    
    <label for="mdp">Mot de passe:</label>
    <input type="password" id="mdp" name="mdp" required>
    
    <button type="submit">Ajouter</button>
</form>

<div id="content">
    <!-- La liste des utilisateurs sera chargée ici -->
</div>

<script>
function loadContent(page) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', page + '.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('content').innerHTML = this.responseText;
        }
    };
    xhr.send();
}

document.getElementById('addUtilisateurForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche le rechargement de la page
    const formData = new FormData(this);
    fetch('add_utilisateur.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Affiche le message de retour du serveur
        loadContent('utilisateurs'); // Recharge la liste des utilisateurs
    })
    .catch(error => {
        console.error('Erreur:', error); // Affiche les erreurs dans la console
    });
});

function deleteUtilisateur(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
        fetch('delete_utilisateur.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Affiche le message de retour du serveur
            loadContent('utilisateurs'); // Recharge la liste des utilisateurs
        })
        .catch(error => {
            console.error('Erreur:', error); // Affiche les erreurs dans la console
        });
    }
}

function editUtilisateur(id) {
    // Redirige vers le formulaire d'édition
    window.location.href = 'edit_utilisateur_form.php?id=' + id;
}
</script>
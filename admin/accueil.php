<?php include 'db.php' ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard E-commerce</title>
</head>
<body>
    <h1>Dashboard E-commerce</h1>
    <nav>
        <ul>
            <li><a href="#" onclick="loadContent('dashboard')">Tableau de bord</a></li>
            <li><a href="#" onclick="loadContent('commandes')">Commandes</a></li>
            <li><a href="#" onclick="loadContent('factures')">Factures</a></li>
            <li><a href="#" onclick="loadContent('produits')">Produits</a></li>
            <li><a href="#" onclick="loadContent('clients')">Clients</a></li>
            <li><a href="#" onclick="loadContent('utilisateurs')">Utilisateurs</a></li>
            <li><a href="#" onclick="loadContent('stocks')">Stocks</a></li>
        </ul>
    </nav>
    <div id="content">
        <!-- Contenu dynamique sera chargé ici -->
    </div>
    <script src="js/script.js"></script>
</body>
</html>
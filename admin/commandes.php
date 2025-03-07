<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord des Commandes</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Tableau de Bord des Commandes</h1>
        <table id="commandes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client ID</th>
                    <th>Facture ID</th>
                    <th>Date et Heure</th>
                    <th>Status</th>
                    <th>Numéro de Commande</th>
                    <th>Adresse de Livraison</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les données des commandes seront insérées ici -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Fonction pour charger les commandes
            function loadCommandes() {
                $.ajax({
                    url: 'db.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let rows = '';
                        $.each(data, function(index, commande) {
                            rows += `<tr>
                                <td>${commande.id}</td>
                                <td>${commande.client_id}</td>
                                <td>${commande.facture_id}</td>
                                <td>${commande.date_heure}</td>
                                <td>${commande.status}</td>
                                <td>${commande.numero_commandes}</td>
                                <td>${commande.adresse_livraison}</td>
                            </tr>`;
                        });
                        $('#commandes-table tbody').html(rows);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors du chargement des commandes:', error);
                    }
                });
            }

            // Charger les commandes au démarrage
            loadCommandes();
        });
    </script>
</body>
</html>
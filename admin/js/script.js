$(document).ready(function() {
    $.ajax({
        url: 'get_dashboard_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let html = '<table><tr><th>ID</th><th>Visites</th><th>Gestion Commandes</th><th>Statistiques</th><th>Gestion Factures</th><th>Compte Client</th><th>Contact Client</th><th>Produits Gestion</th></tr>';
            $.each(data, function(index, item) {

                html += '<tr>';
                html += '<td>' + item.id + '</td>';
                html += '<td>' + item.visites + '</td>';
                html += '<td>' + item.gestions_Commandes + '</td>';
                html += '<td>' + item.statistiques + '</td>';
                html += '<td>' + item.gestion_factures + '</td>';
                html += '<td>' + item.compte_client + '</td>';
                html += '<td>' + item.contact_client + '</td>';
                html += '<td>' + item.produits_gestion + '</td>';
                html += '</tr>';
            });
            html += '</table>';
            $('#dashboard-data').html(html);
        },
        error: function() {
            $('#dashboard-data').html('<p>Erreur lors de la récupération des données.</p>');

        }

    });

});
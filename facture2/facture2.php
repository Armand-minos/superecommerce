<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture AJAX PDF</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h2>Créer une facture</h2>

<form id="factureForm">
    <label>Nom de l'entreprise :</label>
    <input type="text" name="entreprise" required><br><br>

    <label>Nom du client :</label>
    <input type="text" name="client_nom" required><br><br>

    <label>Adresse du client :</label>
    <textarea name="client_adresse" required></textarea><br><br>

    <label>Date :</label>
    <input type="date" name="date_facture" value="<?= date('Y-m-d'); ?>" required><br><br>

    <table id="factureTable">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire (€)</th>
                <th>Total (€)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="ligne-produit">
                <td><input type="text" name="produit[]" required></td>
                <td><input type="number" name="quantite[]" class="quantite" min="1" required></td>
                <td><input type="number" name="prix[]" class="prix" step="0.01" required></td>
                <td class="total-ligne">0</td>
                <td><button type="button" class="supprimer-ligne">X</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" id="ajouterLigne">Ajouter Ligne</button>
    <br><br>
    <button type="submit">Générer PDF</button>
</form>

<script>
$(document).ready(function() {
    $("#ajouterLigne").click(function() {
        $("#factureTable tbody").append(`
            <tr class="ligne-produit">
                <td><input type="text" name="produit[]" required></td>
                <td><input type="number" name="quantite[]" class="quantite" min="1" required></td>
                <td><input type="number" name="prix[]" class="prix" step="0.01" required></td>
                <td class="total-ligne">0</td>
                <td><button type="button" class="supprimer-ligne">X</button></td>
            </tr>
        `);
    });

    $(document).on("click", ".supprimer-ligne", function() {
        $(this).closest("tr").remove();
    });

    $(document).on("input", ".quantite, .prix", function() {
        let ligne = $(this).closest("tr");
        let quantite = ligne.find(".quantite").val();
        let prix = ligne.find(".prix").val();
        let total = (quantite * prix).toFixed(2);
        ligne.find(".total-ligne").text(total);
    });

    $("#factureForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "generer_pdf.php",
            data: $(this).serialize(),
            success: function(response) {
                window.open(response, "_blank");

            },
            error: function(xhr, status, error) {
                console.log("Erreur AJAX : " + error);
                alert("Erreur de connexion au serveur !");
            }
        });
    });
});
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Envoi d'email via AJAX</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="container">
        <h2>Formulaire d'envoi d'email</h2>
        <form id="emailForm" enctype="multipart/form-data">
            <input type="text" id="nomClient" name="nomClient" placeholder="Nom du client" required>
            <input type="email" id="emailClient" name="emailClient" placeholder="Email du client" required>
            <input type="text" id="adresseClient" name="adresseClient" placeholder="Adresse du client" required>
            <input type="text" id="numCommande" name="numCommande" placeholder="Numéro de commande" required>
            <input type="text" id="numSuivi" name="numSuivi" placeholder="Numéro de suivi" required>
            <input type="file" id="facture" name="facture" accept="application/pdf">
            <button type="submit">Envoyer</button>
        </form>
        <p id="resultat"></p>
    </div>

    <script>
        $(document).ready(function(){
            $("#emailForm").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: "send_mail.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#resultat").html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>

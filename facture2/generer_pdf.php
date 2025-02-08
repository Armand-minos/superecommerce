<?php
require('fpdf.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entreprise = $_POST["entreprise"];
    $client_nom = $_POST["client_nom"];
    $client_adresse = $_POST["client_adresse"];
    $date_facture = $_POST["date_facture"];
    $produits = $_POST["produit"];
    $quantites = $_POST["quantite"];
    $prix = $_POST["prix"];

    $pdf = new FPDF();
    $pdf->AddPage();

    // En-tête
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Facture', 0, 1, 'C');

    // Informations de l'entreprise
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, utf8_decode("Entreprise : $entreprise"), 0, 1);
    $pdf->Cell(0, 10, utf8_decode("Date : $date_facture"), 0, 1);
    $pdf->Ln(5);

    // Coordonnées du client
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Client :", 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, utf8_decode("Nom : $client_nom"), 0, 1);
    $pdf->MultiCell(0, 10, utf8_decode("Adresse : $client_adresse"));
    $pdf->Ln(5);

    // Table des produits
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Produit', 1);
    $pdf->Cell(30, 10, 'Quantité', 1);
    $pdf->Cell(40, 10, 'Prix Unitaire', 1);
    $pdf->Cell(40, 10, 'Total', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $totalFacture = 0;

    for ($i = 0; $i < count($produits); $i++) {
        $total = $quantites[$i] * $prix[$i];
        $totalFacture += $total;

        $pdf->Cell(60, 10, utf8_decode($produits[$i]), 1);
        $pdf->Cell(30, 10, $quantites[$i], 1);
        $pdf->Cell(40, 10, number_format($prix[$i], 2, ',', ' ') . ' €', 1);
        $pdf->Cell(40, 10, number_format($total, 2, ',', ' ') . ' €', 1);
        $pdf->Ln();
    }

    // Total général
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(130, 10, 'Total Facture', 1);
    $pdf->Cell(40, 10, number_format($totalFacture, 2, ',', ' ') . ' €', 1);
    $pdf->Ln(10);

    // Pied de page
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, "SIRET : 123 456 789 00012 - Capital : 50 000€", 0, 1, 'C');

    // Vérifier si le dossier "factures" existe, sinon le créer
    $dossier = 'factures/';
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }

    // Nom du fichier basé sur le timestamp
    $file = $dossier . "facture_" . time() . ".pdf";
    $pdf->Output("F", $file);

    echo $file;
}
?>

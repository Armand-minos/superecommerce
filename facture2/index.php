<?php
require('/wamp64/www/projet-1/facture2/fpdf.php');

class PDF extends FPDF
{
    // Fonction pour décoder UTF-8 vers Windows-1252
    function utf8_decode(string $string): string {
        return iconv('UTF-8', 'windows-1252', $string);
    }

    // En-tête de la facture
    function Header()
    {
        // Logo
        $this->Image('logo.png', 10, 8, 33); // Remplacez 'logo.png' par le chemin de votre logo
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $this->utf8_decode('Nom de l\'entreprise'), 0, 1, 'C'); // Remplacez par le nom de votre entreprise
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, $this->utf8_decode('Adresse de l\'entreprise'), 0, 1, 'C'); // Remplacez par l'adresse de votre entreprise
        $this->Ln(10);
    }

    // Pied de page
    function Footer()
    {
        $this->SetY(-15);
        $this->SetLineWidth(0.5); // Épaisseur de la ligne
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 5, $this->utf8_decode('SIRET: 123 456 789 00012'), 0, 1, 'C'); // Remplacez par votre SIRET
        $this->Cell(0, 5, $this->utf8_decode('Capital: 10,000 ') . chr(128), 0, 1, 'C');
    }
}

// Création de la facture
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Coordonnées du client
$pdf->Cell(0, 10, $pdf->utf8_decode('Coordonnées du client:'), 0, 1);
$pdf->Cell(0, 10, $pdf->utf8_decode('Nom du client'), 0, 1); // Remplacez par le nom du client
$pdf->Cell(0, 10, $pdf->utf8_decode('Adresse du client'), 0, 1); // Remplacez par l'adresse du client
$pdf->Ln(10);

// Détails de la facture
$pdf->Cell(40, 10, $pdf->utf8_decode('Produit'), 1);
$pdf->Cell(60, 10, $pdf->utf8_decode('Description'), 1);
$pdf->Cell(30, 10, $pdf->utf8_decode('Prix HT'), 1);
$pdf->Cell(30, 10, $pdf->utf8_decode('Quantité'), 1);
$pdf->Cell(30, 10, $pdf->utf8_decode('Total HT'), 1);
$pdf->Ln();

// Exemple de produit
$nomProduit = $pdf->utf8_decode('Nom du produit'); // Remplacez par le nom du produit
$description = $pdf->utf8_decode('Description du produit'); // Remplacez par la description
$prixHT = 100; // Remplacez par le prix HT
$quantite = 2; // Remplacez par la quantité
$totalHT = $prixHT * $quantite;
$tva = 0.2; // 20% de TVA
$totalTTC = $totalHT * (1 + $tva);
$euro = chr(128); // Signe euro

$pdf->Cell(40, 10, $nomProduit, 1);
$pdf->Cell(60, 10, $description, 1);
$pdf->Cell(30, 10, number_format($prixHT, 2) . " $euro", 1);
$pdf->Cell(30, 10, $quantite, 1);
$pdf->Cell(30, 10, number_format($totalHT, 2) . " $euro", 1);
$pdf->Ln();

// Totaux
$pdf->Cell(160, 10, $pdf->utf8_decode('Total HT'), 1);
$pdf->Cell(30, 10, number_format($totalHT, 2) . " $euro", 1);
$pdf->Ln();
$pdf->Cell(160, 10, $pdf->utf8_decode('TVA (20%)'), 1);
$pdf->Cell(30, 10, number_format($totalHT * $tva, 2) . " $euro", 1);
$pdf->Ln();
$pdf->Cell(160, 10, $pdf->utf8_decode('Total TTC'), 1);
$pdf->Cell(30, 10, number_format($totalTTC, 2) . " $euro", 1);

// Footer
$pdf->Output();
?>

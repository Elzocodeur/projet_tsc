<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once('/var/www/html/projet_tsc/vendor/tecnickcom/tcpdf/tcpdf.php');

header('Content-Type: application/json');

// Fonction pour lire le fichier JSON
function readJSON($filename)
{
    $json_data = file_get_contents($filename);
    return json_decode($json_data, true);
}

// Fonction pour écrire dans le fichier JSON
function writeJSON($filename, $data)
{
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json_data);
}

// Fonction pour envoyer un email avec une pièce jointe
function envoyerEmailAvecPieceJointe($destinataire, $sujet, $message, $piecesJointes)
{
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Spécifiez le serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'gningeli03@gmail.com'; // Votre adresse email SMTP
        $mail->Password = 'acgs gybv eixg jcvp'; // Votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom('gningeli03@gmail.com', 'GP-monde');
        $mail->addAddress($destinataire);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $message;

        // Ajouter les pièces jointes
        foreach ($piecesJointes as $pieceJointe) {
            $mail->addAttachment($pieceJointe);
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Fonction pour générer une facture en format PDF
function genererFacturePDF($produit, $cargaison)
{
    // Création d'une instance de TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();

    $html = '
        <h1>Facture</h1>
        <table border="1" cellpadding="4">
            <tr>
                <th>Nom du client</th>
                <td>' . $produit['emeteur']['nom_client'] . '</td>
            </tr>
            <tr>
                <th>Prénom du client</th>
                <td>' . $produit['emeteur']['prenom_client'] . '</td>
            </tr>
            <tr>
                <th>Type de cargaison</th>
                <td>' . $cargaison['type'] . '</td>
            </tr>
            <tr>
                <th>Date de départ</th>
                <td>' . $cargaison['date_depart'] . '</td>
            </tr>
            <tr>
                <th>Date d\'arrivée</th>
                <td>' . $cargaison['date_arrivee'] . '</td>
            </tr>
            <tr>
                <th>Lieu de départ</th>
                <td>' . $cargaison['lieu_depart'] . '</td>
            </tr>
            <tr>
                <th>Lieu d\'arrivée</th>
                <td>' . $cargaison['lieu_arrivee'] . '</td>
            </tr>
            <tr>
                <th>Nom du produit</th>
                <td>' . $produit['nom_produit'] . '</td>
            </tr>
            <tr>
                <th>Poids du produit</th>
                <td>' . $produit['poids'] . ' kg</td>
            </tr>
            <tr>
                <th>Numéro du produit</th>
                <td>' . $produit['numero_produit'] . '</td>
            </tr>
        </table>
    ';

    $pdf->writeHTML($html);

    $fileName = 'facture_' . $produit['numero_produit'] . '.pdf';
    $filePath = '/var/www/html/projet_tsc/factures/' . $fileName; // Assurez-vous que ce répertoire existe et est accessible

    $pdf->Output($filePath, 'F');

    return $filePath;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'addProduit') {
            $produit = [
                "idproduit" => $_POST['idproduit'],
                "numero_produit" => $_POST['numero_produit'],
                "nom_produit" => $_POST['nom_produit'],
                "type_produit" => $_POST['type_produit'],
                "etape_produit" => $_POST['etape_produit'],
                "poids" => $_POST['poids'],
                "emeteur" => json_decode($_POST['emeteur'], true),
                "destinataire" => json_decode($_POST['destinataire'], true)
            ];

            // Ajouter le champ "toxicite" si présent et si le produit est de type "chimique"
            if (isset($_POST['toxicite']) && $_POST['type_produit'] === 'chimique') {
                $produit['toxicite'] = $_POST['toxicite'];
            }

            $cargaisonNum = $_POST['cargaisonNum'];
            $data = readJSON('cargaisons.json');

            // Rechercher la cargaison par son numéro
            $cargaisonKey = array_search($cargaisonNum, array_column($data['cargaisons'], 'numero'));

            if ($cargaisonKey === false) {
                echo json_encode(['status' => 'error', 'message' => 'La cargaison choisie n\'existe pas']);
                exit;
            }

            // Vérifier si la cargaison est fermée
            if ($data['cargaisons'][$cargaisonKey]['etat_globale'] === 'fermée') {
                echo json_encode(['status' => 'error', 'message' => 'Impossible d\'ajouter un produit à une cargaison fermée et en cours']);
                exit;
            }

            // Vérifier si le produit est de type chimique et si la cargaison est maritime
            if ($produit['type_produit'] === 'chimique' && $data['cargaisons'][$cargaisonKey]['type'] !== 'CargaisonMaritime') {
                echo json_encode(['status' => 'error', 'message' => 'Les produits chimiques ne peuvent être ajoutés qu\'aux cargaisons maritimes']);
                exit;
            }
            // Vérifier si le produit est de type fragile et si la cargaison est aerienne
            if ($produit['type_produit'] === 'fragile' && $data['cargaisons'][$cargaisonKey]['type'] !== 'CargaisonAérienne') {
                echo json_encode(['status' => 'error', 'message' => 'Les produits fragiles ne peuvent être ajoutés qu\'aux cargaisons Aeriennes']);
                exit;
            }
            // Vérifier si la valeur maximale est dépassée
            if ($produit['poids'] >= $data['cargaisons'][$cargaisonKey]['valeur_max']) {
                echo json_encode(['status' => 'error', 'message' => 'La cargaison a atteint sa taille maximale']);
                exit;
            }

            // Ajouter le produit à la cargaison choisie
            $data['cargaisons'][$cargaisonKey]['produits'][] = $produit;

            writeJSON('cargaisons.json', $data);

            $pdfPath = genererFacturePDF($produit, $data['cargaisons'][$cargaisonKey]);

            if (!$pdfPath) {
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la génération du PDF']);
                exit;
            }

            // Envoyer les emails
            $emailEmetteur = $produit['emeteur']['email_client'];
            $emailDestinataire = $produit['destinataire']['email_client'];

            $sujetEmetteur = 'Produit ajouté avec succès';
            $messageEmetteur = 'Votre colis a été ajouté à la cargaison. Merci de votre confiance.';

            $sujetDestinataire = 'Notification de Cargaison';
            $messageDestinataire = 'Le colis de ' . $produit['emeteur']['nom_client'] . ' a été ajouté à la cargaison numéro ' . $cargaisonNum .
                '. Merci de vous rendre à ' . $data['cargaisons'][$cargaisonKey]['lieu_arrivee'] . ' le ' . $data['cargaisons'][$cargaisonKey]['date_arrivee'] . '.';

            $emailEnvoyeEmetteur = envoyerEmailAvecPieceJointe($emailEmetteur, $sujetEmetteur, $messageEmetteur, [$pdfPath]);
            $emailEnvoyeDestinataire = envoyerEmailAvecPieceJointe($emailDestinataire, $sujetDestinataire, $messageDestinataire, [$pdfPath]);

            if ($emailEnvoyeEmetteur && $emailEnvoyeDestinataire) {
                echo json_encode(['status' => 'success', 'message' => 'Produit ajouté avec succès à la cargaison et emails envoyés']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'Produit ajouté avec succès à la cargaison mais échec de l\'envoi de l\'email']);
            }
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'Action non spécifiée ou incorrecte']);
}


<?php

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'addCargaison') {
            $newCargaison = [
                "idcargo" => uniqid(),
                "numero" => $_POST['numero'],
                "lieu_depart" => $_POST['lieu_depart'],
                "lieu_arrivee" => $_POST['lieu_arrivee'],
                "distance_km" => $_POST['distance_km'],
                "poids_suporter" => $_POST['poids_suporter'],
                "date_depart" => $_POST['date_depart'],
                "date_arrivee" => $_POST['date_arrivee'],
                "nom_cargaison" => $_POST['nom_cargaison'],
                "valeur_max" => $_POST['valeur_max'],
                "type" => $_POST['type'],
                "etat_avancement" => $_POST['etat_avancement'],
                "etat_globale" => $_POST['etat_globale']
                // "produit" => []
            ];

            $data = readJSON('cargaisons.json');
            $data['cargaisons'][] = $newCargaison;
            writeJSON('cargaisons.json', $data);

            echo json_encode(['message' => 'Cargaison ajoutée avec succès']);
            exit;
        } elseif ($action === 'addProduit') {
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
            echo json_encode(['status' => 'success', 'message' => 'Produit ajouté avec succès à la cargaison']);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'Action non spécifiée ou incorrecte']);
}

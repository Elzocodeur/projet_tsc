<?php

header('Content-Type: application/json');

// Fonction pour lire le fichier JSON
function readJSON($filename) {
    $json_data = file_get_contents($filename);
    return json_decode($json_data, true);
}

// Fonction pour écrire dans le fichier JSON
function writeJSON($filename, $data) {
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json_data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées via AJAX
    $requestData = json_decode(file_get_contents('php://input'), true);

    if (isset($requestData['action']) && $requestData['action'] === 'changerEtape') {
        // Récupérer les données de la requête
        $idCargaison = $requestData['idCargaison'];
        $nouvelleEtape = $requestData['nouvelleEtape'];

        // Lire les données JSON existantes
        $data = readJSON('cargaisons.json');

        // Rechercher la cargaison par son ID
        $cargaisonKey = array_search($idCargaison, array_column($data['cargaisons'], 'idcargo'));

        if ($cargaisonKey === false) {
            echo json_encode(['status' => 'error', 'message' => 'La cargaison choisie n\'existe pas']);
            exit;
        }


           // Vérifier si la cargaison peut être marquée comme "Perdu"
        if ($nouvelleEtape === 'perdu' && ($data['cargaisons'][$cargaisonKey]['etat_globale'] !== 'fermée' || $data['cargaisons'][$cargaisonKey]['etat_avancement'] !== 'en_route')) {
            echo json_encode(['status' => 'error', 'message' => 'La cargaison ne peut être marquée comme "Perdu" que si elle est fermée et en route']);
            exit;
        }

        // Vérifier si la cargaison est en cours qu'elle se referme automatiquement
        if ($nouvelleEtape === 'en_route' && $data['cargaisons'][$cargaisonKey]['etat_globale'] === 'ouvert') {
            $data['cargaisons'][$cargaisonKey]['etat_globale'] = 'fermée';
        }
        

        // Mettre à jour l'étape de la cargaison
        $data['cargaisons'][$cargaisonKey]['etat_avancement'] = $nouvelleEtape;

        // Écrire les données mises à jour dans le fichier JSON
        writeJSON('cargaisons.json', $data);

        echo json_encode(['status' => 'success', 'message' => 'Étape de la cargaison mise à jour avec succès']);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Action non spécifiée ou incorrecte']);

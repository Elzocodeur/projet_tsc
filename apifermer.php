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
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['action']) && $input['action'] === 'fermerCargaison') {
        $idcargo = $input['id'];

        $data = readJSON('cargaisons.json');
        $cargaisonKey = array_search($idcargo, array_column($data['cargaisons'], 'idcargo'));

        if ($cargaisonKey === false) {
            echo json_encode(['status' => 'error', 'message' => 'Cargaison non trouvée']);
            exit;
        }

        // Vérifier si la cargaison est déjà fermée
        if ($data['cargaisons'][$cargaisonKey]['etat_globale'] === 'fermée') {
            echo json_encode(['status' => 'error', 'message' => 'Cargaison déjà fermée']);
            exit;
        }
                   // Vérifier si la cargaison est perdue
                if ($data['cargaisons'][$cargaisonKey]['etat_avancement'] === 'perdu') {
                    echo json_encode(['status' => 'error', 'message' => 'Cargaison perdue']);
                    exit;
                }

        // Mettre à jour l'état de la cargaison pour la fermer
        $data['cargaisons'][$cargaisonKey]['etat_globale'] = 'fermée';

        writeJSON('cargaisons.json', $data);
        echo json_encode(['status' => 'success', 'message' => 'Cargaison fermée avec succès']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Action non spécifiée ou incorrecte']);
}
?>

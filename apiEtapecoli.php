
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

    if (isset($requestData['action']) && $requestData['action'] === 'updateEtape') {
        // Récupérer les données de la requête
        $cargaisonId = $requestData['cargaisonId'];
        $produitId = $requestData['produitId'];
        $nouvelleEtape = $requestData['newEtape'];

        // Lire les données JSON existantes
        $data = readJSON('cargaisons.json');

        // Trouver la cargaison par son ID
        $cargaisonIndex = array_search($cargaisonId, array_column($data['cargaisons'], 'idcargo'));

        if ($cargaisonIndex === false) {
            echo json_encode(['status' => 'error', 'message' => 'La cargaison choisie n\'existe pas']);
            exit;
        }

        // Trouver le produit par son ID dans la cargaison spécifiée
        $produitIndex = array_search($produitId, array_column($data['cargaisons'][$cargaisonIndex]['produits'], 'idproduit'));

        if ($produitIndex === false) {
            echo json_encode(['status' => 'error', 'message' => 'Le produit choisi n\'existe pas dans cette cargaison']);
            exit;
        }

        // Archiver le produit que si il n'est pas été recupèré par son destinataire
        if ($nouvelleEtape === 'archive' && $data['cargaisons'][$cargaisonIndex]['produits'][$produitIndex]['etape_produit'] !== 'non-recuperer') {
            echo json_encode(['status' => 'error', 'message' => 'Le produit ne peut pas etre archivé car il est toujours recuperable']);
            exit;
        }
        // Recuperer le produit que si la cargaison est arrivée
        if ($nouvelleEtape === 'recuperer' && $data['cargaisons'][$cargaisonIndex]['etat_avancement'] !== 'arrivee') {
            echo json_encode(['status' => 'error', 'message' => 'Le produit ne peut pas etre recuperer car la cargo n\'est pas encore arrivée']);
            exit;
        }
        // Marquer Perdu le produit que si la cargaison est arrivée 
        if ($nouvelleEtape === 'perdu' && $data['cargaisons'][$cargaisonIndex]['etat_avancement'] !== 'arrivee') {
            echo json_encode(['status' => 'error', 'message' => 'Le produit ne peut pas etre marqué comme Perdu car la cargo n\'est pas encore arrivée']);
            exit;
        }
        // Marquer Recuperer le produit que si la cargaison est arrivée 
        if ($nouvelleEtape === 'recuperer' && $data['cargaisons'][$cargaisonIndex]['etat_avancement'] !== 'arrivee') {
            echo json_encode(['status' => 'error', 'message' => 'Le produit ne peut pas etre marqué comme Recuperer car la cargo n\'est pas encore arrivée']);
            exit;
        }
        // // Ce qui est perdu ne peut pas etre archivé
        // if ($nouvelleEtape === 'archive' && $data['cargaisons'][$cargaisonIndex]['produits'][$produitIndex]['etape_produit'] === 'perdu') {
        //     echo json_encode(['status' => 'error', 'message' => 'Impossible d\'archiver ce produit car il a été perdu']);
        //     exit;
        // }

        // Mettre à jour l'étape du produit
        $data['cargaisons'][$cargaisonIndex]['produits'][$produitIndex]['etape_produit'] = $nouvelleEtape;

        // Écrire les données mises à jour dans le fichier JSON
        writeJSON('cargaisons.json', $data);

        echo json_encode(['status' => 'success', 'message' => 'État d\'avancement du produit mis à jour avec succès']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Action non spécifiée ou incorrecte']);
}
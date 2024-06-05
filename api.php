<?php


function readJSON($filename) {
    $json_data = file_get_contents($filename);
    return json_decode($json_data, true);
}

function writeJSON($filename, $data) {
    echo $filename;
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json_data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
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
            "etat_globale" => $_POST['etat_globale'],
            "produit" => []
        ];

        $data = readJSON('cargaisons.json');
        $data['cargaisons'][] = $newCargaison;
        writeJSON('cargaisons.json', $data);
        
        exit;
    }
    
    
    
    echo json_encode(['message' => 'cargaison ajouté avec succès']);
}



<?php

function readJSON($filename) {
    $json_data = file_get_contents($filename);
    return json_decode($json_data, true);
}

function writeJSON($filename, $data) {
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json_data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        $action = $data['action'];

        if ($action === 'getCargaisonDetails') {
            $numero = $data['numero'];
            $data = readJSON('cargaisons.json');
            foreach ($data['cargaisons'] as $cargaison) {
                if ($cargaison['numero'] === $numero) {
                    echo json_encode(['status' => 'success', 'cargaison' => $cargaison]);
                    exit;
                }
            }
            echo json_encode(['status' => 'error', 'message' => 'Cargaison non trouvée']);
            exit;
        }

        if ($action === 'deleteProduit') {
            $cargaisonId = $data['cargaisonId'];
            $idproduit = $data['produitId'];
            $data = readJSON('cargaisons.json');
            foreach ($data['cargaisons'] as &$cargaison) {
                if ($cargaison['idcargo'] === $cargaisonId) {
                    foreach ($cargaison['produits'] as $key => $produit) {
                        if ($produit['idproduit'] === $idproduit) {
                            unset($cargaison['produits'][$key]); 
                            // Réindexer le tableau pour éviter les trous dans les indices
                            $cargaison['produits'] = array_values($cargaison['produits']);
                            writeJSON('cargaisons.json', $data);
                            echo json_encode(['status' => 'success', 'message' => 'Produit supprimé', 'cargaison' => $cargaison]);
                            exit;
                        }
                    }
                }
            }
            echo json_encode(['status' => 'error', 'message' => 'Produit non trouvé']);
            exit;
        }
    }
}

?>

<?php

// Inclure l'autoloader de Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

require './vendor/autoload.php';

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

// Fonction pour envoyer un email
function envoyerEmail($destinataire, $sujet, $message)
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
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Fonction pour envoyer un SMS via InfoBip
function envoyerSMS($numero, $message)
{
    // require_once 'HTTP/Request2.php';
    $request = new HTTP_Request2();
    $request->setUrl('https://8gjzdr.api.infobip.com/sms/2/text/advanced');
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setConfig(array(
        'follow_redirects' => TRUE
    ));
    $request->setHeader(array(
        'Authorization' => 'App 633b92473c572a1487a29b7678a73113-ede9fb24-c77d-4d99-90ed-290b0d53a501',
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ));
    $request->setBody(json_encode([
        'messages' => [[
            'destinations' => [['to' => $numero]],
            'from' => 'ServiceSMS',
            'text' => $message
        ]]
    ]));

    try {
        $response = $request->send();
        if ($response->getStatus() == 200) {
            return true;
        } else {
            return false;
        }
    } catch (HTTP_Request2_Exception $e) {
        return false;
    }
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
                echo json_encode(['status' => 'error', 'message' => 'Les produits fragiles ne peuvent être ajoutés qu\'aux cargaisons Aériennes']);
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

            // Envoyer les emails
            $emailEmetteur = $produit['emeteur']['email_client'];
            $emailDestinataire = $produit['destinataire']['email_client'];

            $sujetEmetteur = 'Produit ajouté';
            $messageEmetteur = 'Votre coli a été ajouté à la cargaison merci de votre confiance.';

            $sujetDestinataire = 'Notification de Cargaison';
            $messageDestinataire = 'Le colis de ' . $produit['emeteur']['nom_client'] . ' est ajouté dans la cargaison numéro ' . $cargaisonNum .
                '. Merci de se rendre à ' . $data['cargaisons'][$cargaisonKey]['lieu_arrivee'] . ' le ' . $data['cargaisons'][$cargaisonKey]['date_arrivee'] . '.';

            $emailEnvoyeEmetteur = envoyerEmail($emailEmetteur, $sujetEmetteur, $messageEmetteur);
            $emailEnvoyeDestinataire = envoyerEmail($emailDestinataire, $sujetDestinataire, $messageDestinataire);

            // Envoyer les SMS
            $numeroEmetteur = $produit['emeteur']['telephone_client'];
            $numeroDestinataire = $produit['destinataire']['telephone_client'];

            $messageSMSEmetteur = 'Votre colis a été ajouté à la cargaison numéro ' . $cargaisonNum . '. Merci de votre confiance.';
            $messageSMSDestinataire = 'Le colis de ' . $produit['emeteur']['nom_client'] . ' est ajouté dans la cargaison numéro ' . $cargaisonNum .
                '. Merci de se rendre à ' . $data['cargaisons'][$cargaisonKey]['lieu_arrivee'] . ' le ' . $data['cargaisons'][$cargaisonKey]['date_arrivee'] . '.';

            $smsEnvoyeEmetteur = envoyerSMS($numeroEmetteur, $messageSMSEmetteur);
            $smsEnvoyeDestinataire = envoyerSMS($numeroDestinataire, $messageSMSDestinataire);

            if ($emailEnvoyeEmetteur && $emailEnvoyeDestinataire && $smsEnvoyeEmetteur && $smsEnvoyeDestinataire) {
                echo json_encode(['status' => 'success', 'message' => 'Produit ajouté avec succès à la cargaison et notifications envoyées']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'Produit ajouté avec succès à la cargaison mais échec de l\'envoi des notifications']);
            }
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'Action non spécifiée ou incorrecte']);
}





const envoieSMS  =() =>{
    const myHeaders = new Headers();
  myHeaders.append("Authorization", "App 633b92473c572a1487a29b7678a73113-ede9fb24-c77d-4d99-90ed-290b0d53a501");
  myHeaders.append("Content-Type", "application/json");
  myHeaders.append("Accept", "application/json");
  
  const raw = JSON.stringify({
      "messages": [
          {
              "destinations": [{"to":"+221776795840"}],
              "from": "ServiceSMS",
              "text": "Congratulations on sending your first message.\nGo ahead and check the delivery report in the next step."
          }
      ]
  });
  
  const requestOptions = {
      method: "POST",
      headers: myHeaders,
      body: raw,
      redirect: "follow"
  };
  
  fetch("https://8gjzdr.api.infobip.com/sms/2/text/advanced", requestOptions)
      .then((response) => response.text())
      .then((result) => console.log(result))
      .catch((error) => console.error(error));
  }




































const envoieSMS = (numero: string, message: string) => {
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "App 633b92473c572a1487a29b7678a73113-ede9fb24-c77d-4d99-90ed-290b0d53a501");
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("Accept", "application/json");
  
    const raw = JSON.stringify({
      "messages": [
        {
          "destinations": [{ "to": numero }],
          "from": "ServiceSMS",
          "text": message
        }
      ]
    });
  
    const requestOptions = {
      method: "POST",
      headers: myHeaders,
      body: raw,
      redirect: "follow"
    };
  
    fetch("https://8gjzdr.api.infobip.com/sms/2/text/advanced", requestOptions)
      .then((response) => response.text())
      .then((result) => console.log(result))
      .catch((error) => console.error(error));
  }
  
  
  function ajouterProduit(cargaisonNum: string): void {
    envoieSMS('+221776795840','message bien réçu');
    const idproduit = "PRD" + Math.floor(Math.random() * 1000);
  
    let formData = new FormData();
    formData.append("action", "addProduit"); 
    formData.append("idproduit", idproduit);
    formData.append("numero_produit", (document.getElementById("nom-produit") as HTMLInputElement)?.value.trim());
    formData.append("nom_produit", (document.getElementById("nom-produit") as HTMLInputElement).value.trim());
    formData.append("type_produit", (document.getElementById("type-produit") as HTMLSelectElement).value.trim());
    formData.append("etape_produit", (document.getElementById("etape-produit") as HTMLSelectElement).value.trim());
    formData.append("poids", (document.getElementById("poids-produit") as HTMLInputElement).value.trim());
  
    const toxiciteElement = document.getElementById("toxicite") as HTMLInputElement;
    if (toxiciteElement && (document.getElementById("type-produit") as HTMLSelectElement).value.trim() === 'chimique') {
      formData.append("toxicite", toxiciteElement.value.trim());
    }
  
    formData.append("cargaisonNum", cargaisonNum);
  
    const emeteur: Client = {
      idclient: "CLT" + Math.floor(Math.random() * 1000),
      nom_client: (document.getElementById("nom-client") as HTMLInputElement).value.trim(),
      prenom_client: (document.getElementById("prenom-client") as HTMLInputElement).value.trim(),
      telephone_client: parseInt((document.getElementById("telephone-client") as HTMLInputElement).value.trim(), 10),
      email_client: (document.getElementById("email-client") as HTMLInputElement).value.trim(),
    };
  
    formData.append("emeteur", JSON.stringify(emeteur));
  
    const destinataire: Client = {
      idclient: "DEST" + Math.floor(Math.random() * 1000),
      nom_client: (document.getElementById("nom-destinateur") as HTMLInputElement).value.trim(),
      prenom_client: (document.getElementById("prenom-destinateur") as HTMLInputElement).value.trim(),
      telephone_client: parseInt((document.getElementById("telephone-destinateur") as HTMLInputElement).value.trim(), 10),
      email_client: (document.getElementById("email-destinateur") as HTMLInputElement).value.trim(),
    };
  
    formData.append("destinataire", JSON.stringify(destinataire));
  
    fetch("apiAjoutProduit.php", {
      method: "POST",
      body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          icon: 'success',
          title: 'Succès',
          text: data.message,
          timer: 3000,
          showConfirmButton: false
        });
        (document.getElementById("form-add-produit") as HTMLFormElement).reset();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: data.message,
          timer: 3000,
          showConfirmButton: false
        });
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: "Erreur lors de l'ajout du produit",
        timer: 3000,
        showConfirmButton: false
      });
    });
  }
  
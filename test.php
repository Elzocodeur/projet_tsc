<option value="en_attente" ${cargaison.etat_avancement === "en_attente" ? "selected" : ""
          }>En attente</option>
    <option value="en_route" ${cargaison.etat_avancement === "en_route" ? "selected" : ""
          }>En route</option>
    <option value="arrivee" ${cargaison.etat_avancement === "arrivee" ? "selected" : ""
          }>Arrivée</option>
          <option value="perdu" ${cargaison.etat_avancement === "perdu" ? "selected" : ""
          }>perdu</option>

          <select class="etat-avancement-select bg-gradient-to-b from-blue-500 to-blue-800 text-white text-lg p-2 rounded" data-id="${cargaison.idcargo
          }">

      </select>


      ${
                      cargaison.etat_avancement !== "perdu" &&
                      cargaison.etat_avancement !== "arrivee" &&
                      cargaison.etat_avancement !== "en_route" &&
                      cargaison.etat_globale !== "fermee"
                        ? `
                    <option value="en_attente">En attente</option>
                  `
                        : ""
                    }



      function ajouterProduit(cargaisonNum: string): void {
  const idproduit = "PRD" + Math.floor(Math.random() * 1000);

  let formData = new FormData();
  formData.append("action", "addProduit");
  formData.append("idproduit", idproduit);
  formData.append(
    "numero_produit",
    (document.getElementById("nom-produit") as HTMLInputElement)?.value.trim()
  );
  formData.append(
    "nom_produit",
    (document.getElementById("nom-produit") as HTMLInputElement).value.trim()
  );
  formData.append(
    "type_produit",
    (document.getElementById("type-produit") as HTMLSelectElement).value.trim()
  );
  formData.append(
    "etape_produit",
    (document.getElementById("etape-produit") as HTMLSelectElement).value.trim()
  );
  formData.append(
    "poids",
    (document.getElementById("poids-produit") as HTMLInputElement).value.trim()
  );

  const toxiciteElement = document.getElementById(
    "toxicite"
  ) as HTMLInputElement;
  if (
    toxiciteElement &&
    (
      document.getElementById("type-produit") as HTMLSelectElement
    ).value.trim() === "chimique"
  ) {
    formData.append("toxicite", toxiciteElement.value.trim());
  }

  formData.append("cargaisonNum", cargaisonNum);

  const emeteur: Client = {
    idclient: "CLT" + Math.floor(Math.random() * 1000),
    nom_client: (
      document.getElementById("nom-client") as HTMLInputElement
    ).value.trim(),
    prenom_client: (
      document.getElementById("prenom-client") as HTMLInputElement
    ).value.trim(),
    telephone_client: parseInt(
      (
        document.getElementById("telephone-client") as HTMLInputElement
      ).value.trim(),
      10
    ),
    email_client: (
      document.getElementById("email-client") as HTMLInputElement
    ).value.trim(),
  };

  formData.append("emeteur", JSON.stringify(emeteur));

  const destinataire: Client = {
    idclient: "DEST" + Math.floor(Math.random() * 1000),
    nom_client: (
      document.getElementById("nom-destinateur") as HTMLInputElement
    ).value.trim(),
    prenom_client: (
      document.getElementById("prenom-destinateur") as HTMLInputElement
    ).value.trim(),
    telephone_client: parseInt(
      (
        document.getElementById("telephone-destinateur") as HTMLInputElement
      ).value.trim(),
      10
    ),
    email_client: (
      document.getElementById("email-destinateur") as HTMLInputElement
    ).value.trim(),
  };

  formData.append("destinataire", JSON.stringify(destinataire));

  fetch("apiAjoutProduit.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        // Envoie SMS à l'emetteur et au destinataire
        const emetteurNumero = `+221${emeteur.telephone_client}`;
        const destinataireNumero = `+221${destinataire.telephone_client}`;
        const messageEmetteur = `Votre colis a été ajouté à la cargaison numéro ${cargaisonNum}. Merci de votre confiance.`;
        const messageDestinataire = `Le colis de ${emeteur.nom_client} a été ajouté à la cargaison numéro ${cargaisonNum}. Merci de vous rendre à ${data.lieu_arrivee}  le ${data.date_arrivee}.`;

        // envoieSMS(emetteurNumero, messageEmetteur);
        // envoieSMS(destinataireNumero, messageDestinataire);
        (
          document.getElementById("form-add-produit") as HTMLFormElement
        ).reset();
      } else {
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: data.message,
          timer: 3000,
          showConfirmButton: false,
        });
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "Erreur lors de l'ajout du produit",
        timer: 3000,
        showConfirmButton: false,
      });
    });
}

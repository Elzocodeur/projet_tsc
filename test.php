<!-- -------------------------------------formulaire ajout produit------------------------ -->
<div id="modal-produit" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg modal-content w-9/12 relative">
        <!-- Search field -->
        <div class="absolute top-4 right-4">
            <input type="text" id="search-field" class="p-2 border border-gray-300 rounded" placeholder="Rechercher...">
        </div>
        <div class="pr-4">
            <h2 class="text-xl font-bold mb-4">Ajout produits</h2>
            <form id="form-add-produit">

                <input type="hidden" id="idcargo">

                <div class="mb-4 flex">
                    <div class="flex-1 ml-4">
                        <label for="nom-produit" class="block text-sm font-medium text-gray-700">Nom produit</label>
                        <input type="text" id="nom-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded" pattern="[A-Za-z\s]+" title="Le nom de cargaison ne doit contenir que des lettres et des espaces">
                        <span class="text-red-500 text-sm hidden" id="nom-cargaison-error">Nom de cargaison est obligatoire et ne doit contenir que des lettres et des espaces</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="poids-produit" class="block text-sm font-medium text-gray-700">Poids produit</label>
                        <input type="number" id="poids-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded" pattern="[A-Za-z\s]+" title="Le poids du produit doit être indiqué">
                        <span class="text-red-500 text-sm hidden" id="poids-produit-error">Poids produit est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="type-produit" class="block text-sm font-medium text-gray-700">Type produit</label>
                        <select id="type-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <option value="alimentaire">Alimentaire</option>
                            <option value="chimique">Chimique</option>
                            <option value="fragile">Fragile</option>
                            <option value="incassable">Incassable</option>
                        </select>
                        <span class="text-red-500 text-sm hidden" id="type-produit-error">Type produit est obligatoire</span>
                    </div>
                    <div class="flex-1 mr-4" id="toxicite-field" style="display: none;">
                        <label for="toxicite" class="block text-sm font-medium text-gray-700">Toxicité</label>
                        <input type="number" id="toxicite" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="toxicite-error">Toxicité est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="etape-produit" class="block text-sm font-medium text-gray-700">Étape produit</label>
                        <select id="etape-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <option value="en_attente">En attente</option>
                            <option value="En cours">En cours</option>
                            <option value="Récupéré">Récupéré</option>
                            <option value="Perdu">Perdu</option>
                            <option value="Archivé">Archivé</option>
                        </select>
                        <span class="text-red-500 text-sm hidden" id="etat-produit-error">Étape produit est obligatoire</span>
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="prenom-client" class="block text-sm font-medium text-gray-700">Prénom client</label>
                        <input type="text" id="prenom-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="prenom-client-error">Prénom client est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="nom-client" class="block text-sm font-medium text-gray-700">Nom client</label>
                        <input type="text" id="nom-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="nom-client-error">Nom client est obligatoire</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="telephone-client" class="block text-sm font-medium text-gray-700">Téléphone du client</label>
                        <input type="number" id="telephone-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="telephone-client-error">Numéro de téléphone est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="email-client" class="block text-sm font-medium text-gray-700">Adresse email client</label>
                        <input type="email" id="email-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="email-client-error">Adresse email incorrecte</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="nom-destinateur" class="block text-sm font-medium text-gray-700">Nom du destinateur</label>
                        <input type="text" id="nom-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="nom-destinateur-error">Nom du destinateur est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="prenom-destinateur" class="block text-sm font-medium text-gray-700">Prénom du destinateur</label>
                        <input type="text" id="prenom-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="prenom-destinateur-error">Prénom du destinateur est obligatoire</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="telephone-destinateur" class="block text-sm font-medium text-gray-700">Numéro de téléphone du destinateur</label>
                        <input type="number" id="telephone-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="telephone-destinateur-error">Numéro de téléphone est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="email-destinateur" class="block text-sm font-medium text-gray-700">Email destinateur</label>
                        <input type="email" id="email-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="email-destinateur-error">Email destinateur est obligatoire</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="adresse-destinateur" class="block text-sm font-medium text-gray-700">Adresse destinateur</label>
                        <input type="text" id="adresse-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="adresse-destinateur-error">Adresse destinateur est obligatoire</span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="btn-close-modal-produit" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Annuler</button>
                    <button id="ajouterprod" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>








<script src="js/produit.js">
















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
        
                envoieSMS(emetteurNumero, messageEmetteur);
                envoieSMS(destinataireNumero, messageDestinataire);

        Swal.fire({
          icon: "success",
          title: "Succès",
          text: data.message,
          timer: 3000,
          showConfirmButton: false,
        });
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



</script>







































// import { Console } from 'console';
// import { Cargaison } from './Model/cargaison.js';

// import { Cargaison } from "./Model/cargaison";

// import Swal from 'sweetalert2';

import { Produit } from "./Model/produit.js";

// Fonction pour ouvrir le modal et passer l'ID de la cargaison
function ouvrirModalProd(cargaisonNum: string | null): void {
  console.log("Ajouter dans la cargaison:", cargaisonNum);
  const modal = document.getElementById("modal-produit");
  if (modal) {
    modal.classList.remove("hidden");
    (document.getElementById("idcargo") as HTMLInputElement).value =
      cargaisonNum || "";
  }
}

// ------------------------------afficher cargaison------------------------------------
interface Cargaison {
  idcargo: string;
  numero: string;
  date_depart: string;
  date_arrivee: string;
  lieu_depart: string;
  lieu_arrivee: string;
  distance_km: string;
  etat_globale: string;
  etat_avancement: string;
  type: string;
}
let currentPage = 1;
const itemsPerPage = 5;
let totalPages = 1;
function affichage(page: number = currentPage): void {
  fetch("cargaisons.json")
    .then((response) => response.json())
    .then((data) => {
      const cargaisons: Cargaison[] = data.cargaisons;
      const cargaisonList = document.getElementById("cargaison-list");
      if (!cargaisonList) return;

      // Récupérer les valeurs de recherche
      const searchNumero = (
        document.getElementById("search-numero") as HTMLInputElement
      ).value.toLowerCase();
      const searchDateDepart = (
        document.getElementById("search-date-depart") as HTMLInputElement
      ).value;
      const searchDateArrivee = (
        document.getElementById("search-date-arrivee") as HTMLInputElement
      ).value;
      const searchLieuDepart = (
        document.getElementById("search-lieu-depart") as HTMLInputElement
      ).value.toLowerCase();
      const searchLieuArrivee = (
        document.getElementById("search-lieu-arrivee") as HTMLInputElement
      ).value.toLowerCase();
      const typeCargaison = (
        document.getElementById("type-filtre") as HTMLSelectElement
      ).value;

      // Filtrer les cargaisons en fonction des valeurs de recherche
      const cargaisonsFiltrees = cargaisons.filter(
        (cargaison) =>
          (searchNumero === "" ||
            cargaison.numero.toLowerCase().includes(searchNumero)) &&
          (searchDateDepart === "" ||
            cargaison.date_depart.includes(searchDateDepart)) &&
          (searchDateArrivee === "" ||
            cargaison.date_arrivee.includes(searchDateArrivee)) &&
          (searchLieuDepart === "" ||
            cargaison.lieu_depart.toLowerCase().includes(searchLieuDepart)) &&
          (searchLieuArrivee === "" ||
            cargaison.lieu_arrivee.toLowerCase().includes(searchLieuArrivee)) &&
          (typeCargaison === "" || cargaison.type === typeCargaison)
      );

      totalPages = Math.ceil(cargaisonsFiltrees.length / itemsPerPage);
      currentPage = page;

      const start = (currentPage - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const paginatedCargaisons = cargaisonsFiltrees.slice(start, end);

      cargaisonList.innerHTML = "";
      paginatedCargaisons.forEach((cargaison) => {
        const row = document.createElement("tr");

        row.innerHTML = `
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
            cargaison.numero
          }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.type
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.date_depart
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.date_arrivee
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.lieu_depart
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.lieu_arrivee
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.etat_globale
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${
              cargaison.etat_avancement
            }</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-view" type="button" data-id="${
                  cargaison.idcargo
                }"><i class="fas fa-solid fa-eye"></i></button>
                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-add-prod" type="button" data-id="${
                  cargaison.numero
                }"><i class=" fas fa-solid fa-plus"></i></button>
                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-fermer-cargo ${
                  cargaison.etat_globale === "fermee" ? "bg-red-500" : ""
                }" type="button" data-id="${
          cargaison.idcargo
        }"><i class="fas fa-solid fa-lock"></i></button>
                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-ouvrir-cargo ${
                  cargaison.etat_globale === "ouvert" ? "bg-green-500" : ""
                }" type="button" data-id="${
          cargaison.idcargo
        }"><i class="fas fa-solid fa-lock" title="ouvrir cargaison"></i></button>

          <select class="etat-avancement-select bg-gradient-to-b from-blue-500 to-blue-800 text-white text-lg p-2 rounded" data-id="${
            cargaison.idcargo
          }">
                    
                    ${
                      cargaison.etat_globale === "fermee" &&
                      cargaison.etat_avancement === "en_route"
                        ? `
                    <option value="en_route">En route</option>
                    <option value="perdu">Perdu</option>
                    <option value="arrivee">Arrivée</option>
                  `
                        : ""
                    }
                  ${
                    cargaison.etat_globale === "ouvert" &&
                    cargaison.etat_avancement === "En attente"
                      ? `
                    <option value="En attente">En attente</option>
                    <option value="en_route">En route</option>
                  `
                      : ""
                  }

                  ${
                    cargaison.etat_globale === "fermee" &&
                    cargaison.etat_avancement === "En attente"
                      ? `
                  <option value="En attente">En attente</option>
                  <option value="en_route">En route</option>
                    `
                      : ""
                  }

                    
        </select>



            </td>
          `;
        cargaisonList.appendChild(row);
      });

      // Mise à jour des événements des boutons "add"
      document.querySelectorAll(".btn-add-prod").forEach((button) => {
        button.addEventListener("click", (event) => {
          console.log(button);
          const target = (event.target as HTMLElement).closest(".btn-add-prod");
          if (target) {
            const cargaisonNum = target.getAttribute("data-id");
            ouvrirModalProd(cargaisonNum);
          }
        });
      });
      // Mise à jour des événements des boutons "voir"
      document.querySelectorAll(".btn-view").forEach((button) => {
        button.addEventListener("click", (event) => {
          const target = (event.target as HTMLElement).closest(".btn-view");
          if (target) {
            const cargaisonId = target.getAttribute("data-id");
            afficherDetailsCargaison(cargaisonId);
          }
        });
      });

      document.querySelectorAll(".btn-fermer-cargo").forEach((button) => {
        button.addEventListener("click", (event) => {
          const target = (event.target as HTMLElement).closest(
            ".btn-fermer-cargo"
          );
          if (target) {
            const cargaisonId = target.getAttribute("data-id");
            console.log(cargaisonId);
            fermerCargaison(cargaisonId);
          }
        });
      });

      document.querySelectorAll(".btn-ouvrir-cargo").forEach((button) => {
        button.addEventListener("click", (event) => {
          const target = (event.target as HTMLElement).closest(
            ".btn-ouvrir-cargo"
          );
          if (target) {
            const cargaisonId = target.getAttribute("data-id");
            console.log(cargaisonId);
            ouvrirCargaison(cargaisonId);
          }
        });
      });

      document.querySelectorAll(".etat-avancement-select").forEach((select) => {
        select.addEventListener("change", (event) => {
          const target = event.target as HTMLSelectElement;
          const cargaisonId = target.getAttribute("data-id");
          const newEtat = target.value;
          changerEtatAvancement(cargaisonId, newEtat);
        });
      });

      // Mise à jour des informations de pagination
      // const pageInfo = document.getElementById("page-info");
      // if (pageInfo) {
      //     pageInfo.textContent = `${currentPage} / ${totalPages}`;
      // }

      // Mise à jour des informations de pagination
      const pageInfo = document.getElementById("page-info");
      if (pageInfo) {
        pageInfo.textContent = `Page ${currentPage} sur ${totalPages}`;
      }

      // Activer/désactiver les boutons de pagination
      const prevButton = document.getElementById(
        "prev-page"
      ) as HTMLButtonElement;
      const nextButton = document.getElementById(
        "next-page"
      ) as HTMLButtonElement;
      if (prevButton) {
        prevButton.disabled = currentPage === 1;
      }
      if (nextButton) {
        nextButton.disabled = currentPage === totalPages;
      }
    });
}

document.getElementById("prev-page")?.addEventListener("click", () => {
  if (currentPage > 1) {
    affichage(currentPage - 1);
  }
});

document.getElementById("next-page")?.addEventListener("click", () => {
  if (currentPage < totalPages) {
    affichage(currentPage + 1);
  }
});

// Ajout d'un événement pour la recherche
document
  .querySelectorAll(
    "#search-numero, #search-date-depart, #search-date-arrivee, #search-lieu-depart, #search-lieu-arrivee, btn-recherche"
  )

  .forEach((element) => {
    element.addEventListener("input", () => {
      affichage(1);
    });
  });

document.querySelector("#type-filtre")?.addEventListener("change", () => {
  affichage(1);
});
// Appel initial pour afficher les cargaisons existantes
affichage();
// ------------------------------fin de la fonction afficher ----------------------------------------

interface Client {
  idclient: string;
  nom_client: string;
  prenom_client: string;
  telephone_client: number;
  email_client: string;
}

//--------------------Ajouter Produit--------------------------------------------

const envoieSMS = (numero: string, message: string) => {
  const myHeaders = new Headers();
  myHeaders.append(
    "Authorization",
    "App 633b92473c572a1487a29b7678a73113-ede9fb24-c77d-4d99-90ed-290b0d53a501"
  );
  myHeaders.append("Content-Type", "application/json");
  myHeaders.append("Accept", "application/json");

  const raw = JSON.stringify({
    messages: [
      {
        destinations: [{ to: numero }],
        from: "GP-Elzo",
        text: message,
      },
    ],
  });

  const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: raw
    // redirect: "follow",
  };

  fetch("https://8gjzdr.api.infobip.com/sms/2/text/advanced", requestOptions)
    .then((response) => response.text())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
};




// function ajouterProduit(cargaisonNum: string): void {
//   const idproduit = "PRD" + Math.floor(Math.random() * 1000);

//   let formData = new FormData();
//   formData.append("action", "addProduit");
//   formData.append("idproduit", idproduit);
//   formData.append(
//     "numero_produit",
//     (document.getElementById("nom-produit") as HTMLInputElement)?.value.trim()
//   );
//   formData.append(
//     "nom_produit",
//     (document.getElementById("nom-produit") as HTMLInputElement).value.trim()
//   );
//   formData.append(
//     "type_produit",
//     (document.getElementById("type-produit") as HTMLSelectElement).value.trim()
//   );
//   formData.append(
//     "etape_produit",
//     (document.getElementById("etape-produit") as HTMLSelectElement).value.trim()
//   );
//   formData.append(
//     "poids",
//     (document.getElementById("poids-produit") as HTMLInputElement).value.trim()
//   );

//   const toxiciteElement = document.getElementById(
//     "toxicite"
//   ) as HTMLInputElement;
//   if (
//     toxiciteElement &&
//     (
//       document.getElementById("type-produit") as HTMLSelectElement
//     ).value.trim() === "chimique"
//   ) {
//     formData.append("toxicite", toxiciteElement.value.trim());
//   }

//   formData.append("cargaisonNum", cargaisonNum);

//   const emeteur: Client = {
//     idclient: "CLT" + Math.floor(Math.random() * 1000),
//     nom_client: (
//       document.getElementById("nom-client") as HTMLInputElement
//     ).value.trim(),
//     prenom_client: (
//       document.getElementById("prenom-client") as HTMLInputElement
//     ).value.trim(),
//     telephone_client: parseInt(
//       (
//         document.getElementById("telephone-client") as HTMLInputElement
//       ).value.trim(),
//       10
//     ),
//     email_client: (
//       document.getElementById("email-client") as HTMLInputElement
//     ).value.trim(),
//   };

//   formData.append("emeteur", JSON.stringify(emeteur));

//   const destinataire: Client = {
//     idclient: "DEST" + Math.floor(Math.random() * 1000),
//     nom_client: (
//       document.getElementById("nom-destinateur") as HTMLInputElement
//     ).value.trim(),
//     prenom_client: (
//       document.getElementById("prenom-destinateur") as HTMLInputElement
//     ).value.trim(),
//     telephone_client: parseInt(
//       (
//         document.getElementById("telephone-destinateur") as HTMLInputElement
//       ).value.trim(),
//       10
//     ),
//     email_client: (
//       document.getElementById("email-destinateur") as HTMLInputElement
//     ).value.trim(),
//   };

//   formData.append("destinataire", JSON.stringify(destinataire));

//   fetch("apiAjoutProduit.php", {
//     method: "POST",
//     body: formData,
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       if (data.status === "success") {

//                 // Envoie SMS à l'emetteur et au destinataire
//                 const emetteurNumero = `+221${emeteur.telephone_client}`;

//                 const destinataireNumero = `+221${destinataire.telephone_client}`;
//                 const messageEmetteur = `Votre colis a été ajouté à la cargaison numéro ${cargaisonNum}. Merci de votre confiance.`;
//                 const messageDestinataire = `Le colis de ${emeteur.nom_client} a été ajouté à la cargaison numéro ${cargaisonNum}. Merci de vous rendre à ${data.lieu_arrivee}  le ${data.date_arrivee}.`;
        
//                 envoieSMS(emetteurNumero, messageEmetteur);
//                 envoieSMS(destinataireNumero, messageDestinataire);

//         Swal.fire({
//           icon: "success",
//           title: "Succès",
//           text: data.message,
//           timer: 3000,
//           showConfirmButton: false,
//         });
//         (
//           document.getElementById("form-add-produit") as HTMLFormElement
//         ).reset();
//       } else {
//         Swal.fire({
//           icon: "error",
//           title: "Erreur",
//           text: data.message,
//           timer: 3000,
//           showConfirmButton: false,
//         });
//       }
//     })
//     .catch((error) => {
//       console.error("Erreur:", error);
//       Swal.fire({
//         icon: "error",
//         title: "Erreur",
//         text: "Erreur lors de l'ajout du produit",
//         timer: 3000,
//         showConfirmButton: false,
//       });
//     });
// }



// Interface for client information
interface Client {
  idclient: string;
  nom_client: string;
  prenom_client: string;
  telephone_client: number;
  email_client: string;
}

// Add event listener for form submission
document.getElementById('form-add-produit')?.addEventListener('submit', function (e) {
  e.preventDefault();

  let isValid = true;

  // Validation for text fields to contain only letters and spaces
  const textFields = [
      'nom-produit', 'prenom-client', 'nom-client',
      'nom-destinateur', 'prenom-destinateur'
  ];
  textFields.forEach(function (id) {
      const element = document.getElementById(id) as HTMLInputElement;
      if (!/^[A-Za-z\s]+$/.test(element.value.trim())) {
          document.getElementById(id + '-error')!.classList.remove('hidden');
          isValid = false;
      } else {
          document.getElementById(id + '-error')!.classList.add('hidden');
      }
  });

  // Validation for phone number fields to be between 9 and 12 digits
  const phoneFields = ['telephone-client', 'telephone-destinateur'];
  phoneFields.forEach(function (id) {
      const element = document.getElementById(id) as HTMLInputElement;
      if (!/^\d{9,12}$/.test(element.value.trim())) {
          document.getElementById(id + '-error')!.classList.remove('hidden');
          isValid = false;
      } else {
          document.getElementById(id + '-error')!.classList.add('hidden');
      }
  });

  // Email validation
  const emailFields = ['email-client', 'email-destinateur'];
  emailFields.forEach(function (id) {
      const element = document.getElementById(id) as HTMLInputElement;
      if (!element.validity.valid) {
          document.getElementById(id + '-error')!.classList.remove('hidden');
          isValid = false;
      } else {
          document.getElementById(id + '-error')!.classList.add('hidden');
      }
  });

  if (isValid) {
      ajouterProduit("1234"); // Pass the actual cargaisonNum value here
  }
});





function ajouterProduit(cargaisonNum: string): void {
  const idproduit = "PRD" + Math.floor(Math.random() * 1000);

  const formData = new FormData();
  formData.append("action", "addProduit");
  formData.append("idproduit", idproduit);
  formData.append("numero_produit", (document.getElementById("nom-produit") as HTMLInputElement).value.trim());
  formData.append("nom_produit", (document.getElementById("nom-produit") as HTMLInputElement).value.trim());
  formData.append("type_produit", (document.getElementById("type-produit") as HTMLSelectElement).value.trim());
  formData.append("etape_produit", (document.getElementById("etape-produit") as HTMLSelectElement).value.trim());
  formData.append("poids", (document.getElementById("poids-produit") as HTMLInputElement).value.trim());

  const toxiciteElement = document.getElementById("toxicite") as HTMLInputElement;
  if (toxiciteElement && (document.getElementById("type-produit") as HTMLSelectElement).value.trim() === "chimique") {
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
          const emetteurNumero = `+221${emeteur.telephone_client}`;
          const destinataireNumero = `+221${destinataire.telephone_client}`;
          const messageEmetteur = `Votre colis a été ajouté à la cargaison numéro ${cargaisonNum}. Merci de votre confiance.`;
          const messageDestinataire = `Le colis de ${emeteur.nom_client} a été ajouté à la cargaison numéro ${cargaisonNum}. Merci de vous rendre à ${data.lieu_arrivee} le ${data.date_arrivee}.`;

          envoieSMS(emetteurNumero, messageEmetteur);
          envoieSMS(destinataireNumero, messageDestinataire);

          Swal.fire({
              icon: "success",
              title: "Succès",
              text: data.message,
              timer: 3000,
              showConfirmButton: false,
          });
          (document.getElementById("form-add-produit") as HTMLFormElement).reset();
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











document
  .getElementById("form-add-produit")
  ?.addEventListener("submit", (event) => {
    event.preventDefault();
    const cargaisonNum = (
      document.getElementById("idcargo") as HTMLInputElement
    ).value;
    ajouterProduit(cargaisonNum);
  });

// Fonction pour fermer une cargaison
function fermerCargaison(cargaisonId: string | null): void {
  if (!cargaisonId) {
    console.error("cargaisonId is null");
    return;
  }

  fetch("apifermer.php", {
    method: "POST",
    body: JSON.stringify({
      action: "fermerCargaison",
      id: cargaisonId,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        // alert(data.message);
        Swal.fire({
          icon: "success",
          title: "Succès",
          text: data.message,
          timer: 3000,
          showConfirmButton: false,
        });
        affichage(); // Rafraîchir le tableau après fermeture
      } else {
        // alert("Erreur lors de la fermeture de la cargaison : " + data.message);
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
      alert("Erreur lors de la fermeture de la cargaison");
    });
}

// Fonction pour ouvrir une cargaison
function ouvrirCargaison(cargaisonId: string | null): void {
  if (!cargaisonId) {
    console.error("cargaisonId is null");
    return;
  }

  fetch("apiouvrir.php", {
    method: "POST",
    body: JSON.stringify({
      action: "ouvrirCargaison",
      id: cargaisonId,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        //alert(data.message);
        Swal.fire({
          title: "Success!",
          text: data.message,
          icon: "success",
          timer: 3000,
          showConfirmButton: false,
        });
        affichage(); // Rafraîchir le tableau après fermeture
      } else {
        // alert("Erreur lors de l'ouverture de la cargaison : " + data.message);
        Swal.fire({
          title: "Erreur!",
          text: data.message,
          icon: "error",
          timer: 3000,
          showConfirmButton: false,
        });
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      // alert("Erreur lors de l'ouverture de la cargaison");
      Swal.fire({
        title: "Erreur!",
        text: "Erreur lors de l'ouverture de la cargaison",
        icon: "error",
        timer: 3000,
        showConfirmButton: false,
      });
    });
}
// Fonction changer etat_avancement d'une cargaison
function changerEtatAvancement(
  cargaisonId: string | null,
  newEtat: string
): void {
  if (!cargaisonId) return;

  fetch("apiEtat.php", {
    method: "POST",
    body: JSON.stringify({
      action: "changerEtape",
      idCargaison: cargaisonId,
      nouvelleEtape: newEtat,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          title: "Succès!",
          text: "État d'avancement mis à jour avec succès",
          icon: "success",
          timer: 3000,
          showConfirmButton: false,
        });
        affichage(); // Rafraîchir le tableau après la mise à jour
      } else {
        Swal.fire({
          title: "Erreur!",
          text: "Erreur lors de la mise à jour de l'état d'avancement",
          icon: "error",
          timer: 3000,
          showConfirmButton: false,
        });
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      Swal.fire({
        title: "Erreur!",
        text: "Erreur lors de la mise à jour de l'état d'avancement",
        icon: "error",
        timer: 3000,
        showConfirmButton: false,
      });
    });
}

function afficherDetailsCargaison(cargaisonId: string | null): void {
  if (!cargaisonId) {
    console.error("cargaisonId is null");
    return;
  }

  fetch("cargaisons.json")
    .then((response) => response.json())
    .then((data) => {
      const cargaison = data.cargaisons.find(
        (c: Cargaison) => c.idcargo === cargaisonId
      );
      if (cargaison) {
        let modalContent = `
          <p><strong>Numéro:</strong> ${cargaison.numero}</p>
          <p><strong>Date de départ:</strong> ${cargaison.date_depart}</p>
          <p><strong>Date d'arrivée:</strong> ${cargaison.date_arrivee}</p>
          <p><strong>Lieu de départ:</strong> ${cargaison.lieu_depart}</p>
          <p><strong>Lieu d'arrivée:</strong> ${cargaison.lieu_arrivee}</p>
          <p><strong>Distance (km):</strong> ${cargaison.distance_km}</p>
          <p><strong>État globale:</strong> ${cargaison.etat_globale}</p>
          <p><strong>État d'avancement:</strong> ${cargaison.etat_avancement}</p>
          <p><strong>Type:</strong> ${cargaison.type}</p>
          <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Détails Produits</h3>
        `;
        if (cargaison.produits && cargaison.produits.length > 0) {
          modalContent += `
            <table class="min-w-full divide-y divide-gray-200 mt-4">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom Produit</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poids</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étape</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200" id="produits-table-body">
          `;
          cargaison.produits.forEach((produit: Produit) => {
            modalContent += `
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">${
                  produit.idproduit
                }</td>
                <td class="px-6 py-4 whitespace-nowrap">${
                  produit.nom_produit
                }</td>
                <td class="px-6 py-4 whitespace-nowrap">${produit.poids}</td>
                <td class="px-6 py-4 whitespace-nowrap">${
                  produit.etape_produit
                }</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <select class="etat-avancement-select-prod  bg-gradient-to-r from-blue-400 to-blue-600 text-white text-lg" data-id="${
                    produit.idproduit
                  }"  data-cargaison-id="${
              cargaison.idcargo
            }" data-produit-id="${produit.idproduit}"  data-produit-etape="${
              produit.etape_produit
            }">
                    <option value="en_attente" ${
                      produit.etape_produit === "en_attente" ? "selected" : ""
                    }>En attente</option>
                    <option value="en_cours" ${
                      produit.etape_produit === "en_cours" ? "selected" : ""
                    }>En cours</option>
                    <option value="arrivee" ${
                      produit.etape_produit === "arrivee" ? "selected" : ""
                    }>Arrivée</option>
                    <option value="recuperer" ${
                      produit.etape_produit === "recuperer" ? "selected" : ""
                    }>Récupérer</option>
                    <option value="perdu" ${
                      produit.etape_produit === "perdu" ? "selected" : ""
                    }>Perdu</option>
                    <option value="archive" ${
                      produit.etape_produit === "archive" ? "selected" : ""
                    }>Archive</option>
                    <option value="annuler" ${
                      produit.etape_produit === "annuler" ? "selected" : ""
                    }>Annuler</option>
                    <option value="non-recuperer" ${
                      produit.etape_produit === "non-recuperer"
                        ? "selected"
                        : ""
                    }>non-recuperer</option>
                  </select>
                  <button class="text-red-600 hover:text-red-900 ml-2 deleteProduit" data-cargaison-id="${
                    cargaison.idcargo
                  }" data-produit-id="${
              produit.idproduit
            }" data-produit-etape="${produit.etape_produit}">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            `;
          });
          modalContent += `
              </tbody>
            </table>
          `;
        } else {
          modalContent += "<p>Aucun produit dans cette cargaison.</p>";
        }

        document.getElementById("modal-content")!.innerHTML = modalContent;
        document.getElementById("modal-detail")?.classList.remove("hidden");

        // Ajouter un écouteur d'événements pour le bouton de suppression
        document.querySelectorAll(".deleteProduit").forEach((item) => {
          item.addEventListener("click", (event: Event) => {
            const target = event.currentTarget as HTMLElement;
            const cargaisonId = target.getAttribute("data-cargaison-id");
            const produitId = target.getAttribute("data-produit-id");
            const produitEtape = target.getAttribute("data-produit-etape");

            console.log(`Produit ID: ${produitId}, Étape: ${produitEtape}`);

            if (cargaisonId && produitId && produitEtape) {
              supprimerProduit(cargaisonId, produitId, produitEtape);
            }
          });
        });

        // Ajouter un écouteur d'événements pour le bouton select pour changer etape produit
        document
          .querySelectorAll(".etat-avancement-select-prod")
          .forEach((select) => {
            select.addEventListener("change", (event) => {
              const target = event.target as HTMLSelectElement;
              const cargaisonId = target.getAttribute("data-cargaison-id");
              const produitId = target.getAttribute("data-produit-id");
              console.log(produitId);
              const newEtat = target.value;
              changerEtapeProduit(cargaisonId, produitId, newEtat);
            });
          });
      } else {
        console.error("Cargaison not found");
      }
    })
    .catch((error) => console.error("Error:", error));
}

function supprimerProduit(
  cargaisonId: string,
  produitId: string,
  etape: string
): void {
  console.log(
    `Tentative de suppression du produit avec ID: ${produitId} et étape: ${etape}`
  );
  if (etape != "en_attente") {
    Swal.fire({
      title: "Erreur!",
      text: "Vous ne pouvez supprimer un produit que si son étape est 'En attente'",
      icon: "error",
      timer: 3000,
      showConfirmButton: false,
    });
    return;
  } else {
    fetch("supprimer_produit.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ action: "deleteProduit", cargaisonId, produitId }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Réponse du serveur :", data);
        if (data.status === "success") {
          afficherDetailsCargaison(cargaisonId); // Rafraîchir la vue
          Swal.fire({
            title: "Succès!",
            text: `Produit avec ID: ${produitId} a été supprimé avec succès`,
            icon: "success",
            timer: 3000,
            showConfirmButton: false,
          });
        } else {
          Swal.fire({
            title: "Erreur!",
            text: data.message,
            icon: "error",
            timer: 3000,
            showConfirmButton: false,
          });
          console.error(
            "Erreur lors de la suppression du produit : " + data.message
          );
        }
      })
      .catch((error) => {
        console.error("Erreur:", error);
        Swal.fire({
          title: "Erreur!",
          text: "Erreur lors de la suppression du produit",
          icon: "error",
          timer: 3000,
          showConfirmButton: false,
        });
      });
  }
}

// Fonction changer etat_avancement d'un produit
function changerEtapeProduit(
  cargaisonId: string | null,
  produitId: string | null,
  newEtape: string
): void {
  fetch("apiEtapecoli.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      action: "updateEtape",
      cargaisonId,
      produitId,
      newEtape,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          title: "Succès!",
          text: "État d'avancement mis à jour avec succès",
          icon: "success",
          timer: 3000,
          showConfirmButton: false,
        });
        afficherDetailsCargaison(cargaisonId); // Rafraîchir la vue
      } else {
        // alert("Erreur lors de la mise à jour de l'étape : " + data.message);
        Swal.fire({
          title: "Erreur!",
          text: data.message,
          icon: "error",
          timer: 3000,
          showConfirmButton: false,
        });
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      alert("Erreur lors de la mise à jour de l'étape");
    });
}






// -------------------------------ajouter cargaison-------------------------------------------------

document.getElementById("ajouter")?.addEventListener("click", function (event) {
  event.preventDefault();

  const typeCargaison = document.getElementById("type-cargaison") as HTMLSelectElement;
  const nomCargaison = document.getElementById("nom-cargaison") as HTMLInputElement;
  const poidsSuporter = document.getElementById("poids-suporter") as HTMLSelectElement;
  const valeur = document.getElementById("valeur-max") as HTMLInputElement;
  const dateDepart = document.getElementById("date-depart") as HTMLInputElement;
  const dateArrivee = document.getElementById("date-arrivee") as HTMLInputElement;
  const depart = document.getElementById("depart") as HTMLInputElement;
  const arrivee = document.getElementById("arrivee") as HTMLInputElement;
  const distance = document.getElementById("distance") as HTMLInputElement;

  const typeCargaisonError = document.getElementById("type-cargaison-error") as HTMLSpanElement;
  const nomCargaisonError = document.getElementById("nom-cargaison-error") as HTMLSpanElement;
  const poidsSuporterError = document.getElementById("poids-suporter-error") as HTMLSpanElement;
  const valeurError = document.getElementById("valeur-error") as HTMLSpanElement;
  const dateDepartError = document.getElementById("date-depart-error") as HTMLSpanElement;
  const dateArriveeError = document.getElementById("date-arrivee-error") as HTMLSpanElement;
  const departError = document.getElementById("depart-error") as HTMLSpanElement;
  const arriveeError = document.getElementById("arrivee-error") as HTMLSpanElement;
  const distanceError = document.getElementById("distance-error") as HTMLSpanElement;

  let formIsValid = true;

  function validateField(field: HTMLInputElement | HTMLSelectElement, errorElement: HTMLElement) {
    if (field.value.trim() === "") {
      errorElement.classList.remove("hidden");
      formIsValid = false;
    } else {
      errorElement.classList.add("hidden");
    }
  }

  function validateDateField() {
    const today = new Date().toISOString().split("T")[0];

    if (dateDepart.value < today) {
      dateDepartError.textContent = "La date de départ doit être supérieure ou égale à la date du jour";
      dateDepartError.classList.remove("hidden");
      formIsValid = false;
    } else {
      dateDepartError.classList.add("hidden");
    }

    if (dateArrivee.value < dateDepart.value) {
      dateArriveeError.textContent = "La date d'arrivée doit être supérieure ou égale à la date de départ";
      dateArriveeError.classList.remove("hidden");
      formIsValid = false;
    } else {
      dateArriveeError.classList.add("hidden");
    }
  }

  function validateNomCargaison() {
    const regex = /^[a-zA-Z\s]*$/;
    if (!regex.test(nomCargaison.value)) {
      nomCargaisonError.textContent = "Le nom de la cargaison ne peut contenir que des lettres et des espaces";
      nomCargaisonError.classList.remove("hidden");
      formIsValid = false;
    } else {
      nomCargaisonError.classList.add("hidden");
    }
  }

  validateField(typeCargaison, typeCargaisonError);
  validateField(nomCargaison, nomCargaisonError);
  validateField(poidsSuporter, poidsSuporterError);
  validateField(valeur, valeurError);
  validateField(dateDepart, dateDepartError);
  validateField(dateArrivee, dateArriveeError);
  validateField(depart, departError);
  validateField(arrivee, arriveeError);
  validateField(distance, distanceError);
  validateDateField();
  validateNomCargaison();

  if (formIsValid) {
    const formData = new FormData();
    formData.append("action", "addCargaison");
    formData.append("numero", "CRG" + Math.floor(Math.random() * 1000));
    formData.append("type", typeCargaison.value);
    formData.append("nom_cargaison", nomCargaison.value);
    formData.append("poids_suporter", poidsSuporter.value);
    formData.append("valeur_max", valeur.value);
    formData.append("date_depart", dateDepart.value);
    formData.append("date_arrivee", dateArrivee.value);
    formData.append("lieu_depart", depart.value);
    formData.append("lieu_arrivee", arrivee.value);
    formData.append("distance_km", distance.value);
    formData.append("etat_avancement", "En attente");
    formData.append("etat_globale", "ouvert");

    fetch("api.php", {
      method: "POST",
      body: formData,
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Succès",
          text: data.message,
          timer: 3000,
          showConfirmButton: false,
        });
        // Rafraîchir le tableau après ajout
        affichage();

        // Fermer le modal
        const modal = document.getElementById("modal") as HTMLElement;
        if (modal) modal.classList.add("hidden");

        // Réinitialiser le formulaire
        (document.getElementById("form-add-cargaison") as HTMLFormElement).reset();
      } else {
        alert("Erreur lors de l'ajout de la cargaison");
      }
    });
  }
});




// ---------------------------------cacher afficher champ toxicité--------------------
document.addEventListener("DOMContentLoaded", () => {
  const typeProduitSelect: HTMLSelectElement | null = document.getElementById(
    "type-produit"
  ) as HTMLSelectElement;
  const toxiciteField: HTMLDivElement | null = document.getElementById(
    "toxicite-field"
  ) as HTMLDivElement;

  if (typeProduitSelect && toxiciteField) {
    typeProduitSelect.addEventListener("change", () => {
      if (typeProduitSelect.value === "chimique") {
        toxiciteField.style.display = "block";
      } else {
        toxiciteField.style.display = "none";
      }
    });
  }
});


// ---------------------------------client voir produit--------------------------------------------------

interface Product {
  idproduit: string;
  nom_produit: string;
  poids: string;
  etape_produit: string;
}

interface Cargaison {
  produits: Product[];
}

interface Data {
  cargaisons: Cargaison[];
}

// Modal handling
const modalclient = document.getElementById("productModal") as HTMLElement;
const btn = document.getElementById("view-product-btn") as HTMLButtonElement;
const span = document.getElementsByClassName("close")[0] as HTMLElement;
const productSearch = document.getElementById("product-search") as HTMLInputElement;
const productInfo = document.getElementById("product-info") as HTMLElement;
const noProductMessage = document.getElementById("no-product-message") as HTMLElement;

// Bouton pour ouvrir le modal
btn?.addEventListener('click', function(e: MouseEvent) {
  e.preventDefault();
  modalclient.classList.remove('hidden');
  modalclient.style.display = "block";
});

// Bouton pour fermer le modal
span?.addEventListener('click', function() {
  modalclient.style.display = "none";
});

// Fermer le modal en cliquant en dehors de celui-ci
window.addEventListener('click', function(event: MouseEvent) {
  if (event.target == modalclient) {
    modalclient.style.display = "none";
  }
});

// Fonction pour chercher un produit
function chercherProduit(id: string) {
  fetch('cargaisons.json')
    .then(response => response.json())
    .then((data: Data) => {
      // Vérifiez que data.cargaisons est défini et est un tableau
      if (data && Array.isArray(data.cargaisons)) {
        let productFound = false;
        for (const cargaison of data.cargaisons) {
          const product = cargaison.produits.find(p => p.idproduit === id);
          if (product) {
            document.getElementById('product-name')!.innerText = product.nom_produit;
            document.getElementById('product-weight')!.innerText = product.poids;
            document.getElementById('product-stage')!.innerText = product.etape_produit;
            productInfo.classList.remove('hidden');
            noProductMessage.classList.add('hidden');
            productFound = true;
            break;
          }
        }
        if (!productFound) {
          productInfo.classList.add('hidden');
          noProductMessage.classList.remove('hidden');
        }
      } else {
        console.error('Cargaisons non trouvées dans la réponse de l\'API');
        productInfo.classList.add('hidden');
        noProductMessage.classList.remove('hidden');
      }
    })
    .catch(error => {
      console.error('Erreur:', error);
      productInfo.classList.add('hidden');
      noProductMessage.classList.remove('hidden');
    });
}

// Ajouter un écouteur d'événements pour la recherche de produit
if (productSearch) {
  productSearch.addEventListener('input', function() {
    const productId = productSearch.value.trim();
    if (productId) {
      chercherProduit(productId);
    } else {
      productInfo.classList.add('hidden');
      noProductMessage.classList.add('hidden');
    }
  });
}




//----------------Section Fermer les modals------------------------------------------------

document.getElementById("btn-add")?.addEventListener("click", () => {
  const modal = document.getElementById("modal");
  if (modal) modal.classList.remove("hidden");
});

document.getElementById("btn-close-modal")?.addEventListener("click", () => {
  const modal = document.getElementById("modal");
  if (modal) modal.classList.add("hidden");
});

document
  .getElementById("btn-close-modal-produit")
  ?.addEventListener("click", () => {
    const modal = document.getElementById("modal-produit");
    if (modal) modal.classList.add("hidden");
  });

document.getElementById("close-modal-detail")?.addEventListener("click", () => {
  const modal = document.getElementById("modal-detail");
  if (modal) modal.classList.add("hidden");
});

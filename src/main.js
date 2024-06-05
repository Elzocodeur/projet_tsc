"use strict";
// import { Console } from 'console';
// import { Cargaison } from './Model/cargaison.js';
var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
Object.defineProperty(exports, "__esModule", { value: true });
//--------------------Ajouter Produit--------------------------------------------
function ajouterProduit(cargaisonNum) {
    var _a;
    var idproduit = "PRD" + Math.floor(Math.random() * 1000);
    var formData = new FormData();
    formData.append("action", "addProduit");
    formData.append("idproduit", idproduit);
    formData.append("numero_produit", (_a = document.getElementById("nom-produit")) === null || _a === void 0 ? void 0 : _a.value.trim());
    formData.append("nom_produit", document.getElementById("nom-produit").value.trim());
    formData.append("type_produit", document.getElementById("type-produit").value.trim());
    formData.append("etape_produit", document.getElementById("etape-produit").value.trim());
    formData.append("poids", document.getElementById("poids-produit").value.trim());
    var toxiciteElement = document.getElementById("toxicite");
    if (toxiciteElement && document.getElementById("type-produit").value.trim() === 'chimique') {
        formData.append("toxicite", toxiciteElement.value.trim());
    }
    formData.append("cargaisonNum", cargaisonNum);
    var emeteur = {
        idclient: "CLT" + Math.floor(Math.random() * 1000),
        nom_client: document.getElementById("nom-client").value.trim(),
        prenom_client: document.getElementById("prenom-client").value.trim(),
        telephone_client: parseInt(document.getElementById("telephone-client").value.trim(), 10),
        email_client: document.getElementById("email-client").value.trim(),
    };
    formData.append("emeteur", JSON.stringify(emeteur));
    var destinataire = {
        idclient: "DEST" + Math.floor(Math.random() * 1000),
        nom_client: document.getElementById("nom-destinateur").value.trim(),
        prenom_client: document.getElementById("prenom-destinateur").value.trim(),
        telephone_client: parseInt(document.getElementById("telephone-destinateur").value.trim(), 10),
        email_client: document.getElementById("email-destinateur").value.trim(),
    };
    formData.append("destinataire", JSON.stringify(destinataire));
    fetch("apiAjoutProduit.php", {
        method: "POST",
        body: formData,
    })
        .then(function (response) { return response.json(); })
        .then(function (data) {
        if (data.status === "success") {
            alert(data.message);
            document.getElementById("form-add-produit").reset();
        }
        else {
            alert("Erreur lors de l'ajout du produit : " + data.message);
        }
    })
        .catch(function (error) {
        console.error("Erreur:", error);
        alert("Erreur lors de l'ajout du produit");
    });
}
// Ajout de l'événement de soumission du formulaire de produit
(_a = document
    .getElementById("form-add-produit")) === null || _a === void 0 ? void 0 : _a.addEventListener("submit", function (event) {
    event.preventDefault();
    var cargaisonNum = document.getElementById("idcargo").value;
    ajouterProduit(cargaisonNum);
});
// Fonction pour fermer une cargaison
function fermerCargaison(cargaisonId) {
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
        .then(function (response) { return response.json(); })
        .then(function (data) {
        if (data.status === "success") {
            alert(data.message);
            affichage(); // Rafraîchir le tableau après fermeture
        }
        else {
            alert("Erreur lors de la fermeture de la cargaison : " + data.message);
        }
    })
        .catch(function (error) {
        console.error("Erreur:", error);
        alert("Erreur lors de la fermeture de la cargaison");
    });
}
// Fonction pour ouvrir une cargaison
function ouvrirCargaison(cargaisonId) {
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
        .then(function (response) { return response.json(); })
        .then(function (data) {
        if (data.status === "success") {
            //alert(data.message);
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
            //affichage(); // Rafraîchir le tableau après fermeture
        }
        else {
            alert("Erreur lors de l'ouverture de la cargaison : " + data.message);
        }
    })
        .catch(function (error) {
        console.error("Erreur:", error);
        alert("Erreur lors de l'ouverture de la cargaison");
    });
}
// Fonction changer etat_avancement d'une cargaison
function changerEtatAvancement(cargaisonId, newEtat) {
    if (!cargaisonId)
        return;
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
        .then(function (response) { return response.json(); })
        .then(function (data) {
        if (data.status === "success") {
            alert("État d'avancement mis à jour avec succès");
            affichage();
        }
        else {
            alert("Erreur lors de la mise à jour de l'état d'avancement");
        }
    })
        .catch(function (error) {
        console.error("Erreur:", error);
        alert("Erreur lors de la mise à jour de l'état d'avancement");
    });
}
function afficherDetailsCargaison(cargaisonId) {
    if (!cargaisonId) {
        console.error("cargaisonId is null");
        return;
    }
    fetch("cargaisons.json")
        .then(function (response) { return response.json(); })
        .then(function (data) {
        var _a;
        var cargaison = data.cargaisons.find(function (c) { return c.idcargo === cargaisonId; });
        if (cargaison) {
            var modalContent_1 = "\n          <p><strong>Num\u00E9ro:</strong> ".concat(cargaison.numero, "</p>\n          <p><strong>Date de d\u00E9part:</strong> ").concat(cargaison.date_depart, "</p>\n          <p><strong>Date d'arriv\u00E9e:</strong> ").concat(cargaison.date_arrivee, "</p>\n          <p><strong>Lieu de d\u00E9part:</strong> ").concat(cargaison.lieu_depart, "</p>\n          <p><strong>Lieu d'arriv\u00E9e:</strong> ").concat(cargaison.lieu_arrivee, "</p>\n          <p><strong>Distance (km):</strong> ").concat(cargaison.distance_km, "</p>\n          <p><strong>\u00C9tat globale:</strong> ").concat(cargaison.etat_globale, "</p>\n          <p><strong>\u00C9tat d'avancement:</strong> ").concat(cargaison.etat_avancement, "</p>\n          <p><strong>Type:</strong> ").concat(cargaison.type, "</p>\n          <h3 class=\"text-lg leading-6 font-medium text-gray-900 mt-4\">D\u00E9tails Produits</h3>\n        ");
            if (cargaison.produits && cargaison.produits.length > 0) {
                modalContent_1 += "\n            <table class=\"min-w-full divide-y divide-gray-200 mt-4\">\n              <thead class=\"bg-gray-50\">\n                <tr>\n                  <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">Code</th>\n                  <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">Nom Produit</th>\n                  <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">Poids</th>\n                  <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">\u00C9tape</th>\n                  <th scope=\"col\" class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">Action</th>\n                </tr>\n              </thead>\n              <tbody class=\"bg-white divide-y divide-gray-200\" id=\"produits-table-body\">\n          ";
                cargaison.produits.forEach(function (produit) {
                    modalContent_1 += "\n              <tr>\n                <td class=\"px-6 py-4 whitespace-nowrap\">".concat(produit.idproduit, "</td>\n                <td class=\"px-6 py-4 whitespace-nowrap\">").concat(produit.nom_produit, "</td>\n                <td class=\"px-6 py-4 whitespace-nowrap\">").concat(produit.poids, "</td>\n                <td class=\"px-6 py-4 whitespace-nowrap\">").concat(produit.etape_produit, "</td>\n                <td class=\"px-6 py-4 whitespace-nowrap\">\n                  <select class=\"etat-avancement-select bg-gradient-to-r from-blue-400 to-blue-600 text-white text-lg\" data-id=\"").concat(produit.idproduit, "\" onchange=\"changerEtapeProduit('").concat(cargaison.idcargo, "', '").concat(produit.idproduit, "', this.value)\">\n                    <option value=\"en_attente\" ").concat(produit.etape_produit === "en_attente" ? "selected" : "", ">En attente</option>\n                    <option value=\"en_cours\" ").concat(produit.etape_produit === "en_cours" ? "selected" : "", ">En cours</option>\n                    <option value=\"arrivee\" ").concat(produit.etape_produit === "arrivee" ? "selected" : "", ">Arriv\u00E9e</option>\n                    <option value=\"recuperer\" ").concat(produit.etape_produit === "recuperer" ? "selected" : "", ">R\u00E9cup\u00E9rer</option>\n                    <option value=\"perdu\" ").concat(produit.etape_produit === "perdu" ? "selected" : "", ">Perdu</option>\n                    <option value=\"archive\" ").concat(produit.etape_produit === "archive" ? "selected" : "", ">Archive</option>\n                    <option value=\"annuler\" ").concat(produit.etape_produit === "annuler" ? "selected" : "", ">Annuler</option>\n                  </select>\n                  <button class=\"text-red-600 hover:text-red-900 ml-2 deleteProduit\" data-cargaison-id=\"").concat(cargaison.idcargo, "\" data-produit-id=\"").concat(produit.idproduit, "\" data-produit-etape=\"").concat(produit.etape_produit, "\">\n                    <i class=\"fas fa-trash\"></i>\n                  </button>\n                </td>\n              </tr>\n            ");
                });
                modalContent_1 += "\n              </tbody>\n            </table>\n          ";
            }
            else {
                modalContent_1 += "<p>Aucun produit dans cette cargaison.</p>";
            }
            document.getElementById("modal-content").innerHTML = modalContent_1;
            (_a = document.getElementById("modal-detail")) === null || _a === void 0 ? void 0 : _a.classList.remove("hidden");
            // Ajouter un écouteur d'événements pour le bouton de suppression
            document.querySelectorAll('.deleteProduit').forEach(function (item) {
                item.addEventListener('click', function (event) {
                    var target = event.currentTarget;
                    var cargaisonId = target.getAttribute('data-cargaison-id');
                    var produitId = target.getAttribute('data-produit-id');
                    var produitEtape = target.getAttribute('data-produit-etape');
                    console.log("Produit ID: ".concat(produitId, ", \u00C9tape: ").concat(produitEtape));
                    if (cargaisonId && produitId && produitEtape) {
                        supprimerProduit(cargaisonId, produitId, produitEtape);
                    }
                });
            });
        }
        else {
            console.error("Cargaison not found");
        }
    })
        .catch(function (error) { return console.error("Error:", error); });
}
function supprimerProduit(cargaisonId, produitId, etape) {
    console.log("Tentative de suppression du produit avec ID: ".concat(produitId, " et \u00E9tape: ").concat(etape));
    if (etape != "En attente") {
        alert("Vous ne pouvez supprimer un produit que si son étape est 'En attente'");
        return;
    }
    else {
        fetch("supprimer_produit.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ action: "deleteProduit", cargaisonId: cargaisonId, produitId: produitId }),
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
            console.log('Réponse du serveur :', data);
            if (data.status === "success") {
                afficherDetailsCargaison(cargaisonId); // Rafraîchir la vue
                alert("Produit avec ID: ".concat(produitId, " a \u00E9t\u00E9 supprim\u00E9 avec succ\u00E8s"));
            }
            else {
                alert("Erreur lors de la suppression du produit : " + data.message);
                console.error("Erreur lors de la suppression du produit : " + data.message);
            }
        })
            .catch(function (error) {
            console.error("Erreur:", error);
            alert("Erreur lors de la suppression du produit");
        });
    }
}
function changerEtapeProduit(cargaisonId, produitId, newEtape) {
    fetch("supprimer_produit.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "updateEtape",
            cargaisonId: cargaisonId,
            produitId: produitId,
            newEtape: newEtape,
        }),
    })
        .then(function (response) { return response.json(); })
        .then(function (data) {
        if (data.status === "success") {
            afficherDetailsCargaison(cargaisonId); // Rafraîchir la vue
        }
        else {
            alert("Erreur lors de la mise à jour de l'étape : " + data.message);
        }
    })
        .catch(function (error) {
        console.error("Erreur:", error);
        alert("Erreur lors de la mise à jour de l'étape");
    });
}
// ---------------------------------------fin---------------------------------------
// Fonction pour ouvrir le modal et passer l'ID de la cargaison
function ouvrirModalProd(cargaisonNum) {
    console.log("Ajouter dans la cargaison:", cargaisonNum);
    var modal = document.getElementById("modal-produit");
    if (modal) {
        modal.classList.remove("hidden");
        document.getElementById("idcargo").value =
            cargaisonNum || "";
    }
}
var currentPage = 1;
var itemsPerPage = 5;
var totalPages = 1;
function affichage(page) {
    if (page === void 0) { page = currentPage; }
    fetch("cargaisons.json")
        .then(function (response) { return response.json(); })
        .then(function (data) {
        var cargaisons = data.cargaisons;
        var cargaisonList = document.getElementById("cargaison-list");
        if (!cargaisonList)
            return;
        // Récupérer les valeurs de recherche
        var searchNumero = document.getElementById("search-numero").value.toLowerCase();
        var searchDateDepart = document.getElementById("search-date-depart").value;
        var searchDateArrivee = document.getElementById("search-date-arrivee").value;
        var searchLieuDepart = document.getElementById("search-lieu-depart").value.toLowerCase();
        var searchLieuArrivee = document.getElementById("search-lieu-arrivee").value.toLowerCase();
        var typeCargaison = document.getElementById("type-filtre").value;
        // Filtrer les cargaisons en fonction des valeurs de recherche
        var cargaisonsFiltrees = cargaisons.filter(function (cargaison) {
            return (searchNumero === "" ||
                cargaison.numero.toLowerCase().includes(searchNumero)) &&
                (searchDateDepart === "" ||
                    cargaison.date_depart.includes(searchDateDepart)) &&
                (searchDateArrivee === "" ||
                    cargaison.date_arrivee.includes(searchDateArrivee)) &&
                (searchLieuDepart === "" ||
                    cargaison.lieu_depart.toLowerCase().includes(searchLieuDepart)) &&
                (searchLieuArrivee === "" ||
                    cargaison.lieu_arrivee.toLowerCase().includes(searchLieuArrivee)) &&
                (typeCargaison === "" || cargaison.type === typeCargaison);
        });
        totalPages = Math.ceil(cargaisonsFiltrees.length / itemsPerPage);
        currentPage = page;
        var start = (currentPage - 1) * itemsPerPage;
        var end = start + itemsPerPage;
        var paginatedCargaisons = cargaisonsFiltrees.slice(start, end);
        cargaisonList.innerHTML = "";
        paginatedCargaisons.forEach(function (cargaison) {
            var row = document.createElement("tr");
            row.innerHTML = "\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">".concat(cargaison.numero, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.type, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.date_depart, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.date_arrivee, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.lieu_depart, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.lieu_arrivee, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.etat_globale, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">").concat(cargaison.etat_avancement, "</td>\n            <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">\n                <button class=\"bg-blue-500 text-white px-1 py-1 rounded btn-view\" type=\"button\" data-id=\"").concat(cargaison.idcargo, "\"><i class=\"fas fa-solid fa-eye\"></i></button>\n                <button class=\"bg-blue-500 text-white px-1 py-1 rounded btn-add-prod\" type=\"button\" data-id=\"").concat(cargaison.numero, "\"><i class=\" fas fa-solid fa-plus\"></i></button>\n                <button class=\"bg-blue-500 text-white px-1 py-1 rounded btn-fermer-cargo ").concat(cargaison.etat_globale === "fermée" ? "bg-red-500" : "", "\" type=\"button\" data-id=\"").concat(cargaison.idcargo, "\"><i class=\"fas fa-solid fa-lock\"></i></button>\n                <button class=\"bg-blue-500 text-white px-1 py-1 rounded btn-ouvrir-cargo ").concat(cargaison.etat_globale === "ouvert" ? "bg-green-500" : "", "\" type=\"button\" data-id=\"").concat(cargaison.idcargo, "\"><i class=\"fas fa-solid fa-lock\" title=\"ouvrir cargaison\"></i></button>\n            \n\n\n        <select class=\"etat-avancement-select bg-gradient-to-b from-blue-500 to-blue-800 text-white text-lg p-2 rounded\" data-id=\"").concat(cargaison.idcargo, "\">\n    <option value=\"en_attente\" ").concat(cargaison.etat_avancement === "en_attente" ? "selected" : "", ">En attente</option>\n    <option value=\"en_route\" ").concat(cargaison.etat_avancement === "en_route" ? "selected" : "", ">En route</option>\n    <option value=\"arrivee\" ").concat(cargaison.etat_avancement === "arrivee" ? "selected" : "", ">Arriv\u00E9e</option>\n</select>\n\n\n            </td>\n          ");
            cargaisonList.appendChild(row);
        });
        // Mise à jour des événements des boutons "add"
        document.querySelectorAll(".btn-add-prod").forEach(function (button) {
            button.addEventListener("click", function (event) {
                console.log(button);
                var target = event.target.closest(".btn-add-prod");
                if (target) {
                    var cargaisonNum = target.getAttribute("data-id");
                    ouvrirModalProd(cargaisonNum);
                }
            });
        });
        // Mise à jour des événements des boutons "voir"
        document.querySelectorAll(".btn-view").forEach(function (button) {
            button.addEventListener("click", function (event) {
                var target = event.target.closest(".btn-view");
                if (target) {
                    var cargaisonId = target.getAttribute("data-id");
                    afficherDetailsCargaison(cargaisonId);
                }
            });
        });
        document.querySelectorAll(".btn-fermer-cargo").forEach(function (button) {
            button.addEventListener("click", function (event) {
                var target = event.target.closest(".btn-fermer-cargo");
                if (target) {
                    var cargaisonId = target.getAttribute("data-id");
                    console.log(cargaisonId);
                    fermerCargaison(cargaisonId);
                }
            });
        });
        document.querySelectorAll(".btn-ouvrir-cargo").forEach(function (button) {
            button.addEventListener("click", function (event) {
                var target = event.target.closest(".btn-ouvrir-cargo");
                if (target) {
                    var cargaisonId = target.getAttribute("data-id");
                    console.log(cargaisonId);
                    ouvrirCargaison(cargaisonId);
                }
            });
        });
        document.querySelectorAll(".etat-avancement-select").forEach(function (select) {
            select.addEventListener("change", function (event) {
                var target = event.target;
                var cargaisonId = target.getAttribute("data-id");
                var newEtat = target.value;
                changerEtatAvancement(cargaisonId, newEtat);
            });
        });
        // Mise à jour des informations de pagination
        // const pageInfo = document.getElementById("page-info");
        // if (pageInfo) {
        //     pageInfo.textContent = `${currentPage} / ${totalPages}`;
        // }
        // Mise à jour des informations de pagination
        var pageInfo = document.getElementById("page-info");
        if (pageInfo) {
            pageInfo.textContent = "Page ".concat(currentPage, " sur ").concat(totalPages);
        }
        // Activer/désactiver les boutons de pagination
        var prevButton = document.getElementById("prev-page");
        var nextButton = document.getElementById("next-page");
        if (prevButton) {
            prevButton.disabled = currentPage === 1;
        }
        if (nextButton) {
            nextButton.disabled = currentPage === totalPages;
        }
    });
}
(_b = document.getElementById("prev-page")) === null || _b === void 0 ? void 0 : _b.addEventListener("click", function () {
    if (currentPage > 1) {
        affichage(currentPage - 1);
    }
});
(_c = document.getElementById("next-page")) === null || _c === void 0 ? void 0 : _c.addEventListener("click", function () {
    if (currentPage < totalPages) {
        affichage(currentPage + 1);
    }
});
// Ajout d'un événement pour la recherche
document
    .querySelectorAll("#search-numero, #search-date-depart, #search-date-arrivee, #search-lieu-depart, #search-lieu-arrivee, btn-recherche")
    .forEach(function (element) {
    element.addEventListener("input", function () {
        affichage(1);
    });
});
(_d = document.querySelector("#type-filtre")) === null || _d === void 0 ? void 0 : _d.addEventListener("change", function () {
    affichage(1);
});
// Appel initial pour afficher les cargaisons existantes
affichage();
// ajouter cargaison
(_e = document
    .getElementById("form-add-cargaison")) === null || _e === void 0 ? void 0 : _e.addEventListener("submit", function (event) {
    event.preventDefault();
    var numero = "CRG" + Math.floor(Math.random() * 1000);
    var typeCargaison = document.getElementById("type-cargaison").value.trim();
    var nom_cargaison = document.getElementById("nom-cargaison").value.trim();
    var poids_suporter = document.getElementById("poids-suporter").value.trim();
    var date_depart = document.getElementById("date-depart").value.trim();
    var date_arrivee = document.getElementById("date-arrivee").value.trim();
    var lieu_depart = document.getElementById("depart").value.trim();
    var lieu_arrivee = document.getElementById("arrivee").value.trim();
    var distance_km = document.getElementById("distance").value.trim();
    var valeur_max = document.getElementById("valeur-max").value.trim();
    var etat_avancement = "en attente";
    var etat_globale = "ouvert";
    var formData = new FormData();
    formData.append("action", "addCargaison");
    formData.append("numero", numero);
    formData.append("lieu_depart", lieu_depart);
    formData.append("lieu_arrivee", lieu_arrivee);
    formData.append("distance_km", distance_km);
    formData.append("type", typeCargaison);
    formData.append("etat_avancement", etat_avancement);
    formData.append("etat_globale", etat_globale);
    formData.append("poids_suporter", poids_suporter);
    formData.append("date_depart", date_depart);
    formData.append("date_arrivee", date_arrivee);
    formData.append("nom_cargaison", nom_cargaison);
    formData.append("valeur_max", valeur_max);
    fetch("api.php", {
        method: "POST",
        body: formData,
    })
        .then(function (response) { return response.json(); })
        .then(function (data) {
        if (data.status === "success") {
            alert(data.message);
            // Mettre à jour le tableau avec les nouvelles données
            affichage();
            // Réinitialiser les données du formulaire en utilisant reset()
            document.getElementById("form-add-cargaison").reset();
            // Fermer le modal
            var modals = document.getElementById("modal");
            if (modals) {
                modals.classList.add("hidden");
            }
            else {
                console.error("Modal not found");
            }
        }
        else {
            alert("Erreur lors de l'ajout de la cargaison");
        }
    })
        .catch(function (error) {
        console.error("Erreur:", error);
        alert("Erreur lors de l'ajout de la cargaison");
    });
    return false;
});
document.addEventListener("DOMContentLoaded", function (event) {
    affichage();
});
// // ******************validation du formulaire****************
(_f = document.getElementById("ajouter")) === null || _f === void 0 ? void 0 : _f.addEventListener("click", function (event) {
    event.preventDefault();
    var typeCargaison = document.getElementById("type-cargaison");
    var nomCargaison = document.getElementById("nom-cargaison");
    var poidsSuporter = document.getElementById("poids-suporter");
    var valeur = document.getElementById("valeur-max");
    var dateDepart = document.getElementById("date-depart");
    var dateArrivee = document.getElementById("date-arrivee");
    var depart = document.getElementById("depart");
    var arrivee = document.getElementById("arrivee");
    var distance = document.getElementById("distance");
    var typeCargaisonError = document.getElementById("type-cargaison-error");
    var nomCargaisonError = document.getElementById("nom-cargaison-error");
    var poidsSuporterError = document.getElementById("poids-suporter-error");
    var valeurError = document.getElementById("valeur-error");
    var dateDepartError = document.getElementById("date-depart-error");
    var dateArriveeError = document.getElementById("date-arrivee-error");
    var departError = document.getElementById("depart-error");
    var arriveeError = document.getElementById("arrivee-error");
    var distanceError = document.getElementById("distance-error");
    var formIsValid = true;
    function validateField(field, errorElement) {
        if (field.value.trim() === "") {
            errorElement.classList.remove("hidden");
            formIsValid = false;
        }
        else {
            errorElement.classList.add("hidden");
        }
    }
    function validateDateField() {
        var today = new Date().toISOString().split("T")[0];
        if (dateDepart.value < today) {
            dateDepartError.textContent =
                "La date de départ doit être supérieure ou égale à la date du jour";
            dateDepartError.classList.remove("hidden");
            formIsValid = false;
        }
        else {
            dateDepartError.classList.add("hidden");
        }
        if (dateArrivee.value < dateDepart.value) {
            dateArriveeError.textContent =
                "La date d'arrivée doit être supérieure ou égale à la date de départ";
            dateArriveeError.classList.remove("hidden");
            formIsValid = false;
        }
        else {
            dateArriveeError.classList.add("hidden");
        }
    }
    function validateNomCargaison() {
        var regex = /^[a-zA-Z\s]*$/;
        if (!regex.test(nomCargaison.value)) {
            nomCargaisonError.textContent =
                "Le nom de la cargaison ne peut contenir que des lettres et des espaces";
            nomCargaisonError.classList.remove("hidden");
            formIsValid = false;
        }
        else {
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
        var formData = new FormData();
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
        formData.append("etat_avancement", "en attente");
        formData.append("etat_globale", "ouvert");
        fetch("api.php", {
            method: "POST",
            body: formData,
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
            if (data.status === "success") {
                alert(data.message);
                affichage(); // Rafraîchir le tableau après ajout
                // Fermer le modal
                var modal = document.getElementById("modal");
                if (modal)
                    modal.classList.add("hidden");
                // Réinitialiser le formulaire
                document.getElementById("form-add-cargaison").reset();
            }
            else {
                alert("Erreur lors de l'ajout de la cargaison");
            }
        });
    }
});
// ---------------------------------cacher afficher champ toxicité--------------------
document.addEventListener('DOMContentLoaded', function () {
    var typeProduitSelect = document.getElementById('type-produit');
    var toxiciteField = document.getElementById('toxicite-field');
    if (typeProduitSelect && toxiciteField) {
        typeProduitSelect.addEventListener('change', function () {
            if (typeProduitSelect.value === 'chimique') {
                toxiciteField.style.display = 'block';
            }
            else {
                toxiciteField.style.display = 'none';
            }
        });
    }
});
//----------------Section Fermer les modals------------------------------------------------
(_g = document.getElementById("btn-add")) === null || _g === void 0 ? void 0 : _g.addEventListener("click", function () {
    var modal = document.getElementById("modal");
    if (modal)
        modal.classList.remove("hidden");
});
(_h = document.getElementById("btn-close-modal")) === null || _h === void 0 ? void 0 : _h.addEventListener("click", function () {
    var modal = document.getElementById("modal");
    if (modal)
        modal.classList.add("hidden");
});
(_j = document
    .getElementById("btn-close-modal-produit")) === null || _j === void 0 ? void 0 : _j.addEventListener("click", function () {
    var modal = document.getElementById("modal-produit");
    if (modal)
        modal.classList.add("hidden");
});
(_k = document.getElementById("close-modal-detail")) === null || _k === void 0 ? void 0 : _k.addEventListener("click", function () {
    var modal = document.getElementById("modal-detail");
    if (modal)
        modal.classList.add("hidden");
});

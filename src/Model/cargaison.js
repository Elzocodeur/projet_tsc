"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
Object.defineProperty(exports, "__esModule", { value: true });
exports.CargaisonRoutière = exports.CargaisonAérienne = exports.CargaisonMaritime = exports.Cargaison = void 0;
var Cargaison = /** @class */ (function () {
    function Cargaison(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, type, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        this.cargaisons = [];
        this.produits = [];
        this.idcargo = idcargo;
        this.numero = numero;
        this.poids_max = poids_max;
        this.prix_total = prix_total;
        this.lieu_depart = lieu_depart;
        this.lieu_arrivee = lieu_arrivee;
        this.distance_km = distance_km;
        this.poids_suporter = poids_suporter;
        this.date_depart = date_depart;
        this.date_arrivee = date_arrivee;
        this.nom_cargaison = nom_cargaison;
        this.valeur_max = valeur_max;
        this.type = type;
        this.etat_avancement = etat_avancement;
        this.etat_globale = etat_globale;
    }
    Cargaison.prototype.ajouterCargaison = function (cargaison) {
        this.cargaisons.unshift(cargaison);
    };
    Cargaison.prototype.listerCargaisons = function () {
        return this.cargaisons;
    };
    // static filtrerCargaisonsParType(type: string): Promise<Cargaison[]> {
    //   return new Promise((resolve, reject) => {
    //     // Assume that you have an API endpoint that returns a list of cargaisons
    //     // based on the provided type
    //     fetch('api.php?type=' + type)
    //       .then(response => response.json())
    //       .then(data => {
    //         resolve(data.cargaisons);
    //       })
    //       .catch(error => {
    //         reject(error);
    //       });
    //   });
    // }
    Cargaison.prototype.filtrerCargaisonsParType = function (type) {
        return this.cargaisons.filter(function (cargaison) { return cargaison.type === type; });
    };
    Cargaison.prototype.ajouterProdui = function (produit) {
        if (this.type === "Plein" && this.produits.length >= this.valeur_max) {
            console.log("Limite de nombre de produits atteinte");
            return false; // Limite de nombre de produits atteinte
        }
        var poidsTotal = this.produits.reduce(function (total, prod) { return total + prod.poids; }, 0) + produit.poids;
        if (this.type === "PleinPoids" && poidsTotal > this.poids_max) {
            console.log("Limite de poids atteinte");
            return false; // Limite de poids atteinte
        }
        this.produits.push(produit);
        return true; // Produit ajouté avec succès
    };
    return Cargaison;
}());
exports.Cargaison = Cargaison;
var CargaisonMaritime = /** @class */ (function (_super) {
    __extends(CargaisonMaritime, _super);
    function CargaisonMaritime(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        return _super.call(this, idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonMaritime', poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) || this;
    }
    return CargaisonMaritime;
}(Cargaison));
exports.CargaisonMaritime = CargaisonMaritime;
var CargaisonAérienne = /** @class */ (function (_super) {
    __extends(CargaisonAérienne, _super);
    function CargaisonAérienne(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        return _super.call(this, idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonAérienne', poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) || this;
    }
    return CargaisonAérienne;
}(Cargaison));
exports.CargaisonAérienne = CargaisonAérienne;
var CargaisonRoutière = /** @class */ (function (_super) {
    __extends(CargaisonRoutière, _super);
    function CargaisonRoutière(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        return _super.call(this, idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonRoutère', poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) || this;
    }
    return CargaisonRoutière;
}(Cargaison));
exports.CargaisonRoutière = CargaisonRoutière;

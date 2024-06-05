"use strict";
// import { Client } from "./client.js";
// import { Destinataire } from "./destinataire.js";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Produit = void 0;
var Produit = /** @class */ (function () {
    function Produit(idproduit, numero_produit, nom_produit, type_produit, etape_produit, poids, emeteur, destinataire) {
        this.produit = [];
        this.client = [];
        this.idproduit = idproduit;
        this.numero_produit = numero_produit;
        this.nom_produit = nom_produit;
        this.type_produit = type_produit;
        this.etape_produit = etape_produit;
        this.poids = poids;
        this.emeteur = emeteur;
        this.destinataire = destinataire;
    }
    return Produit;
}());
exports.Produit = Produit;

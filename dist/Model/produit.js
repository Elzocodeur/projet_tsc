// import { Client } from "./client.js";
// import { Destinataire } from "./destinataire.js";
class Produit {
    idproduit;
    numero_produit;
    nom_produit;
    type_produit;
    etape_produit;
    poids;
    produit = [];
    client = [];
    emeteur;
    destinataire;
    constructor(idproduit, numero_produit, nom_produit, type_produit, etape_produit, poids, emeteur, destinataire) {
        this.idproduit = idproduit;
        this.numero_produit = numero_produit;
        this.nom_produit = nom_produit;
        this.type_produit = type_produit;
        this.etape_produit = etape_produit;
        this.poids = poids;
        this.emeteur = emeteur;
        this.destinataire = destinataire;
    }
}
export { Produit };

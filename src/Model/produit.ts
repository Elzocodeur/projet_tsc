// import { Client } from "./client.js";
// import { Destinataire } from "./destinataire.js";

export interface Client{
  idclient: string;
  nom_client: string;
  prenom_client: string;
  telephone_client: number;
  email_client: string;
}

class Produit {
    idproduit: string;
    numero_produit: string;
    nom_produit: string;
    type_produit: string;
    etape_produit: string;
    poids: number;
    private produit: Produit[] = [];
    private client: Client[] = [];
    emeteur:Client ;
    destinataire:Client;
    
  
    constructor(
      idproduit: string,
      numero_produit: string,
      nom_produit: string,
      type_produit: string,
      etape_produit: string,
      poids: number,
      emeteur:Client,
      destinataire:Client
    ) {
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
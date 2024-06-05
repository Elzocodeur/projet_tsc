import { Produit } from "./produit.js";

class Cargaison {
    idcargo: string;
    numero: string;
    poids_max: number;
    prix_total: number;
    lieu_depart: string;
    lieu_arrivee: string;
    distance_km: number;
    poids_suporter: number;
    date_depart: number;
    date_arrivee: number;
    nom_cargaison: string;
    valeur_max: number;
    type: string;
    etat_avancement: string;
    etat_globale: string;
    private cargaisons: Cargaison[] = [];
    private produits: Produit[] = [];
  
    constructor(
      idcargo: string,
      numero: string,
      poids_max: number,
      prix_total: number,
      lieu_depart: string,
      lieu_arrivee: string,
      distance_km: number,
      type: string,
      poids_suporter: number,
      date_depart: number,
      date_arrivee: number,
      nom_cargaison: string,
      valeur_max: number,
      etat_avancement: string,
      etat_globale: string
    ) {
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
  
    ajouterCargaison(cargaison: Cargaison): void {
      this.cargaisons.unshift(cargaison);
    }
  
    listerCargaisons(): Cargaison[] {
      return this.cargaisons;
    }
  
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
    filtrerCargaisonsParType(type: string): Cargaison[] {
      return this.cargaisons.filter(cargaison => cargaison.type === type);
    }

    ajouterProdui(produit: Produit): boolean {
      if (this.type === "Plein" && this.produits.length >= this.valeur_max) {
        console.log("Limite de nombre de produits atteinte");
        return false; // Limite de nombre de produits atteinte
      }
  
      const poidsTotal = this.produits.reduce((total, prod) => total + prod.poids, 0) + produit.poids;
      if (this.type === "PleinPoids" && poidsTotal > this.poids_max) {
        console.log("Limite de poids atteinte");
        return false; // Limite de poids atteinte
      }
  
      this.produits.push(produit);
      return true; // Produit ajouté avec succès
    }
  }
  
  
  class CargaisonMaritime extends Cargaison {
    constructor(
        idcargo: string,
        numero: string,
        poids_max: number,
        prix_total: number,
        lieu_depart: string,
        lieu_arrivee: string,
        distance_km: number,
        poids_suporter: number,
        date_depart: number,
        date_arrivee: number,
        nom_cargaison: string,
        valeur_max: number,
        etat_avancement: string,
        etat_globale: string
    ) {
        super(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonMaritime',poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale);
    }
}
  
  class CargaisonAérienne extends Cargaison {
    constructor(
      idcargo: string,
      numero: string,
      poids_max: number,
      prix_total: number,
      lieu_depart: string,
      lieu_arrivee: string,
      distance_km: number,
      poids_suporter: number,
      date_depart: number,
      date_arrivee: number,
      nom_cargaison: string,
      valeur_max: number,
      etat_avancement: string,
      etat_globale: string
      ) {
        super(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonAérienne',poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale);
      }
  }
  
  class CargaisonRoutière extends Cargaison {
    constructor(
      idcargo: string,
      numero: string,
      poids_max: number,
      prix_total: number,
      lieu_depart: string,
      lieu_arrivee: string,
      distance_km: number,
      poids_suporter: number,
      date_depart: number,
      date_arrivee: number,
      nom_cargaison: string,
      valeur_max: number,
      etat_avancement: string,
      etat_globale: string
      ) {
        super(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonRoutère',poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale);
      }
  }
  
  export { Cargaison, CargaisonMaritime, CargaisonAérienne, CargaisonRoutière };  
  
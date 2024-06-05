class Cargaison {
    idcargo;
    numero;
    poids_max;
    prix_total;
    lieu_depart;
    lieu_arrivee;
    distance_km;
    poids_suporter;
    date_depart;
    date_arrivee;
    nom_cargaison;
    valeur_max;
    type;
    etat_avancement;
    etat_globale;
    cargaisons = [];
    produits = [];
    constructor(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, type, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
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
    ajouterCargaison(cargaison) {
        this.cargaisons.unshift(cargaison);
    }
    listerCargaisons() {
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
    filtrerCargaisonsParType(type) {
        return this.cargaisons.filter(cargaison => cargaison.type === type);
    }
    ajouterProdui(produit) {
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
    constructor(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        super(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonMaritime', poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale);
    }
}
class CargaisonAérienne extends Cargaison {
    constructor(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        super(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonAérienne', poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale);
    }
}
class CargaisonRoutière extends Cargaison {
    constructor(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale) {
        super(idcargo, numero, poids_max, prix_total, lieu_depart, lieu_arrivee, distance_km, 'CargaisonRoutère', poids_suporter, date_depart, date_arrivee, nom_cargaison, valeur_max, etat_avancement, etat_globale);
    }
}
export { Cargaison, CargaisonMaritime, CargaisonAérienne, CargaisonRoutière };

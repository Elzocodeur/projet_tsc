class Destinataire {
    iddest;
    nom_dest;
    prenom_dest;
    adresse_dest;
    telephone_dest;
    email_dest;
    destinataire = [];
    constructor(iddest, nom_dest, prenom_dest, adresse_dest, telephone_dest, email_dest) {
        this.iddest = iddest;
        this.nom_dest = nom_dest;
        this.prenom_dest = prenom_dest;
        this.adresse_dest = adresse_dest;
        this.telephone_dest = telephone_dest;
        this.email_dest = email_dest;
    }
}
export { Destinataire };

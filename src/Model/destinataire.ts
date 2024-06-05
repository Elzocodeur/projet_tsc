class Destinataire {
    iddest: string;
    nom_dest: string;
    prenom_dest: string;
    adresse_dest: string;
    telephone_dest: number;
    email_dest: string;
    private destinataire: Destinataire[] = [];
  
    constructor(
      iddest: string,
      nom_dest: string,
      prenom_dest: string,
      adresse_dest: string,
      telephone_dest: number,
      email_dest: string,
    ) {
      this.iddest = iddest;
      this.nom_dest = nom_dest;
      this.prenom_dest = prenom_dest;
      this.adresse_dest = adresse_dest;
      this.telephone_dest = telephone_dest;
      this.email_dest = email_dest;
    }
}

export { Destinataire };
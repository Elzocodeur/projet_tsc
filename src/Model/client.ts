class Client {
    idclient: string;
    nom_client: string;
    prenom_client: string;
    telephone_client: number;
    email_client: string;
    private client: Client[] = [];
  
    constructor(
      idclient: string,
      nom_client: string,
      prenom_client: string,
      telephone_client: number,
      email_client: string,
    ) {
      this.idclient = idclient;
      this.nom_client = nom_client;
      this.prenom_client = prenom_client;
      this.telephone_client = telephone_client;
      this.email_client = email_client;
    }
}

export { Client};
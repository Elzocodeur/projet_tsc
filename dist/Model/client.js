class Client {
    idclient;
    nom_client;
    prenom_client;
    telephone_client;
    email_client;
    client = [];
    constructor(idclient, nom_client, prenom_client, telephone_client, email_client) {
        this.idclient = idclient;
        this.nom_client = nom_client;
        this.prenom_client = prenom_client;
        this.telephone_client = telephone_client;
        this.email_client = email_client;
    }
}
export { Client };

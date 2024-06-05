"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Client = void 0;
var Client = /** @class */ (function () {
    function Client(idclient, nom_client, prenom_client, telephone_client, email_client) {
        this.client = [];
        this.idclient = idclient;
        this.nom_client = nom_client;
        this.prenom_client = prenom_client;
        this.telephone_client = telephone_client;
        this.email_client = email_client;
    }
    return Client;
}());
exports.Client = Client;

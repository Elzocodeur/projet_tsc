"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Destinataire = void 0;
var Destinataire = /** @class */ (function () {
    function Destinataire(iddest, nom_dest, prenom_dest, adresse_dest, telephone_dest, email_dest) {
        this.destinataire = [];
        this.iddest = iddest;
        this.nom_dest = nom_dest;
        this.prenom_dest = prenom_dest;
        this.adresse_dest = adresse_dest;
        this.telephone_dest = telephone_dest;
        this.email_dest = email_dest;
    }
    return Destinataire;
}());
exports.Destinataire = Destinataire;

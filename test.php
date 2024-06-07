<option value="en_attente" ${cargaison.etat_avancement === "en_attente" ? "selected" : ""
          }>En attente</option>
    <option value="en_route" ${cargaison.etat_avancement === "en_route" ? "selected" : ""
          }>En route</option>
    <option value="arrivee" ${cargaison.etat_avancement === "arrivee" ? "selected" : ""
          }>Arrivée</option>
          <option value="perdu" ${cargaison.etat_avancement === "perdu" ? "selected" : ""
          }>perdu</option>

          <select class="etat-avancement-select bg-gradient-to-b from-blue-500 to-blue-800 text-white text-lg p-2 rounded" data-id="${cargaison.idcargo
          }">

      </select>



                <select class="etat-avancement-select bg-gradient-to-b from-blue-500 to-blue-800 text-white text-lg p-2 rounded" data-id="${cargaison.idcargo}">
                  <option value="en_attente" ${cargaison.etat_globale === "fermée" && cargaison.etat_avancement === "en_route" ? "selected" : ""}>Perdu</option>
                  <option value="arrivee" ${cargaison.etat_globale === "fermée" && cargaison.etat_avancement === "en_route" ? "selected" : ""}>Arrivée</option>
                  <option value="en_route" ${cargaison.etat_globale === "ouvert" && cargaison.etat_avancement === "en_attente" ? "selected" : ""}>En route</option>
                  <option value="perdu" ${cargaison.etat_globale === "ouvert" && cargaison.etat_avancement === "en_attente" ? "selected" : ""}>Perdu</option>
                  <option value="en_route" ${cargaison.etat_globale === "en_route" ? "selected" : ""}>Perdu</option>
                  ${cargaison.etat_avancement === "perdu" || cargaison.etat_avancement === "arrivee" ? 'disabled' : ''}
                </select>
    


                ${cargaison.etat_avancement !== "perdu" && cargaison.etat_avancement !== "arrivee" ? `
            <option value="en_attente">En attente</option>
            <option value="en_route">En route</option>
            <option value="arrivee">Arrivée</option>
            <option value="perdu">Perdu</option>
          ` : ''}


          
















          <select class="etat-avancement-select bg-gradient-to-b from-blue-500 to-blue-800 text-white text-lg p-2 rounded" data-id="${cargaison.idcargo}">
          ${cargaison.etat_globale === "fermée" && cargaison.etat_avancement === "en_route" ? `
            <option value="en_route">En route</option>
            <option value="perdu">Perdu</option>
            <option value="arrivee">Arrivée</option>
          ` : ''}
          ${cargaison.etat_globale === "ouvert" && cargaison.etat_avancement === "en_attente" ? `
            <option value="en_attente">En attente</option>
            <option value="en_route">En route</option>
          ` : ''}

          ${cargaison.etat_globale === "fermee" && cargaison.etat_avancement === "en_attente" ? `
          <option value="en_attente">En attente</option>
          <option value="en_route">En route</option>
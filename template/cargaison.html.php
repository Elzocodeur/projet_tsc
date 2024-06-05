<?php
// Charger les données depuis le fichier JSON
$data = json_decode(file_get_contents('cargaisons.json'), true);
$cargaisons = $data['cargaisons'];
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


<main id="main-content" class="main-content flex-grow p-8 shifted ml-56">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Gestion des Cargaisons</h1>

        <!-- Formulaire de recherche -->
        <div class="mb-4 mx-8 flex space-x-20">
            <form id="search-form" class="flex space-x-4">
                <input type="text" id="search-numero" placeholder="Recherche par Numéro" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="date" id="search-date-depart" placeholder="Recherche par Date de Départ" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="date" id="search-date-arrivee" placeholder="Recherche par Date d'Arrivée" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" id="search-lieu-depart" placeholder="Recherche par Lieu de Départ" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" id="search-lieu-arrivee" placeholder="Recherche par Lieu d'Arrivée" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
            <select id="type-filtre" class="type-filtre bg-blue-500 text-white px-4 py-2 rounded-md">
    <option value="">Tous les types</option>
    <option value="CargaisonMaritime">Maritime</option>
    <option value="CargaisonAérienne">Aérienne</option>
    <option value="CargaisonRoutière">Routière</option>
</select>


        </div>

        <div id="output" class="bg-white p-4 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 table">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Type</th>
                        <th>Date de Départ</th>
                        <th>Date d'Arrivée</th>
                        <th>Lieu de Départ</th>
                        <th>Lieu d'Arrivée</th>
                        <th>Etat_globale</th>
                        <th>Etape</th>
                        <th class="pl-4 text-xl">Action</th>
                    </tr>
                </thead>
                <tbody id="cargaison-list">
                    <?php foreach ($cargaisons as $cargaison) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['numero']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['type']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['date_depart']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['date_arrivee']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['lieu_depart']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['lieu_arrivee']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['etat_globale']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cargaison['etat_avancement']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-view" type="button" data-id="<?php echo $cargaison['idcargo']; ?>"><i class="fas fa-solid fa-eye"></i></button>
                                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-add-prod" type="button" data-id="<?php echo $cargaison['numero']; ?>"><i class=" fas fa-solid fa-plus"></i></button>
                                <button class="bg-blue-500 text-white px-1 py-1 rounded btn-fermer-cargo" type="button" data-id="<?php echo $cargaison['numero']; ?>"><i class="fas fa-solid fa-lock"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- <div class="pagination">
                <button id="prev-page" class="bg-blue-500 text-white px-2 py-1 rounded" type="button"><i class="fas fa-solid fa-arrow-left"></i></button>
                <span id="page-info" class="mx-2"></span>
                <button id="next-page" class="bg-blue-500 text-white px-2 py-1 rounded" type="button"><i class="fas fa-solid fa-arrow-right"></i></button>
            </div> -->

            <div class="pagination">
                <button id="prev-page" class="bg-blue-500 text-white px-2 py-1 rounded" type="button">Précédent</button>
                <span id="page-info" class="mx-2"></span>
                <button id="next-page" class="bg-blue-500 text-white px-2 py-1 rounded" type="button">Suivant</button>
            </div>
        </div>
    </div>
</main>

<!-- -------------------------------------formulaire ajout produit------------------------ -->
<!-- -------------------------------------formulaire ajout produit------------------------ -->
<div id="modal-produit" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg modal-content w-9/12 relative">
        <!-- Search field -->
        <div class="absolute top-4 right-4">
            <input type="text" id="search-field" class="p-2 border border-gray-300 rounded" placeholder="Rechercher...">
        </div>
        <div class="pr-4">
            <h2 class="text-xl font-bold mb-4">Ajout produits</h2>
            <form id="form-add-produit">

                <input type="hidden" id="idcargo">

                <div class="mb-4 flex">
                    <div class="flex-1 ml-4">
                        <label for="nom-produit" class="block text-sm font-medium text-gray-700">Nom produit</label>
                        <input type="text" id="nom-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded" pattern="[A-Za-z\s]+" title="Le nom de cargaison ne doit contenir que des lettres et des espaces">
                        <span class="text-red-500 text-sm hidden" id="nom-cargaison-error">Nom de cargaison est obligatoire et ne doit contenir que des lettres et des espaces</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="poids-produit" class="block text-sm font-medium text-gray-700">Poids produit</label>
                        <input type="number" id="poids-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded" pattern="[A-Za-z\s]+" title="Le poids du produit doit être indiqué">
                        <span class="text-red-500 text-sm hidden" id="poids-produit-error">Poids produit est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="type-produit" class="block text-sm font-medium text-gray-700">Type produit</label>
                        <select id="type-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <option value="alimentaire">Alimentaire</option>
                            <option value="chimique">Chimique</option>
                            <option value="fragile">Fragile</option>
                            <option value="incassable">Incassable</option>
                        </select>
                        <span class="text-red-500 text-sm hidden" id="type-produit-error">Type produit est obligatoire</span>
                    </div>
                    <div class="flex-1 mr-4" id="toxicite-field" style="display: none;">
                        <label for="toxicite" class="block text-sm font-medium text-gray-700">Toxicité</label>
                        <input type="number" id="toxicite" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="toxicite-error">Toxicité est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="etape-produit" class="block text-sm font-medium text-gray-700">Étape produit</label>
                        <select id="etape-produit" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <option value="En attente">En attente</option>
                            <option value="En cours">En cours</option>
                            <option value="Récupéré">Récupéré</option>
                            <option value="Perdu">Perdu</option>
                            <option value="Archivé">Archivé</option>
                        </select>
                        <span class="text-red-500 text-sm hidden" id="etat-produit-error">Étape produit est obligatoire</span>
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="prenom-client" class="block text-sm font-medium text-gray-700">Prénom client</label>
                        <input type="text" id="prenom-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="prenom-client-error">Prénom client est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="nom-client" class="block text-sm font-medium text-gray-700">Nom client</label>
                        <input type="text" id="nom-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="nom-client-error">Nom client est obligatoire</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="telephone-client" class="block text-sm font-medium text-gray-700">Téléphone du client</label>
                        <input type="number" id="telephone-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="telephone-client-error">Numéro de téléphone est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="email-client" class="block text-sm font-medium text-gray-700">Adresse email client</label>
                        <input type="email" id="email-client" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="email-client-error">Adresse email incorrecte</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="nom-destinateur" class="block text-sm font-medium text-gray-700">Nom du destinateur</label>
                        <input type="text" id="nom-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="nom-destinateur-error">Nom du destinateur est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="prenom-destinateur" class="block text-sm font-medium text-gray-700">Prénom du destinateur</label>
                        <input type="text" id="prenom-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="prenom-destinateur-error">Prénom du destinateur est obligatoire</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="telephone-destinateur" class="block text-sm font-medium text-gray-700">Numéro de téléphone du destinateur</label>
                        <input type="number" id="telephone-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="telephone-destinateur-error">Numéro de téléphone est obligatoire</span>
                    </div>
                </div>

                <div class="mb-4 flex">
                    <div class="flex-1 mr-4">
                        <label for="email-destinateur" class="block text-sm font-medium text-gray-700">Email destinateur</label>
                        <input type="email" id="email-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="email-destinateur-error">Email destinateur est obligatoire</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <label for="adresse-destinateur" class="block text-sm font-medium text-gray-700">Adresse destinateur</label>
                        <input type="text" id="adresse-destinateur" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        <span class="text-red-500 text-sm hidden" id="adresse-destinateur-error">Adresse destinateur est obligatoire</span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="btn-close-modal-produit" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Annuler</button>
                    <button id="ajouterprod" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- -------------details modal----------------------------- -->
<div id="modal-detail" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-500 hover:text-gray-700" id="close-modal-detail">
                    <i class="fas fa-times"></i>
                </button>
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Détails de la Cargaison</h3>
                        <div class="mt-2">
                            <div class="text-sm text-gray-500" id="modal-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
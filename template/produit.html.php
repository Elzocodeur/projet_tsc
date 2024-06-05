 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> 


<main id="main-content" class="main-content flex-grow p-8 shifted ml-56">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Gestion des Produits</h1>

        <!-- Formulaire de recherche -->
        <div class="mb-4 mx-8 flex space-x-20">
            <form id="recherche" class="flex space-x-4">
                <input type="text" id="search-libelle" placeholder="Recherche par Libelle" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <!-- <input type="date" id="search-date-depart" placeholder="Recherche par Date de Départ" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="date" id="search-date-arrivee" placeholder="Recherche par Date d'Arrivée" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" id="search-lieu-depart" placeholder="Recherche par Lieu de Départ" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" id="search-lieu-arrivee" placeholder="Recherche par Lieu d'Arrivée" class="p-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"> -->
            </form>
            <select id="type-filtrer" class="type-filtrer">
                    <option value="">Tous les types</option>
                    <option value="Alimentaire">alimentaire</option>
                    <option value="Chimique">chimique</option>
                    <option value="Incassable">incassable</option>
                    <option value="Fragile">fragile</option>
            </select>
        </div>

        <div id="output" class="bg-white p-4 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 table">
                <thead>
                    <tr>
                        <th>Libelle</th>
                        <th>Type</th>
                        <th>Poids</th>
                        <th class="pl-4 text-xl">Action</th>
                    </tr>
                </thead>
                <tbody id="produit-list">
                    <!-- <?php foreach ($cargaisons as $cargaison) : ?>
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
                            </td>
                        </tr>
                    <?php endforeach; ?> -->
                </tbody>
            </table>

            <div class="pagination">
                <button id="prev-page" class="bg-blue-500 text-white px-2 py-1 rounded" type="button"><i class="fas fa-solid fa-arrow-left"></i></button>
                <span id="page-info" class="mx-2"></span>
                <button id="next-page" class="bg-blue-500 text-white px-2 py-1 rounded" type="button"><i class="fas fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</main>








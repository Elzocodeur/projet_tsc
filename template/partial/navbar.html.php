<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
    <style>
        .submenu {
            display: none;
        }

        .menu-item:hover .submenu {
            display: block;
        }



        /* map */
        #map {
            height: 370px;
            /* ou une hauteur appropriée selon vos besoins */
            width: 40%;
            margin-top: 5%;
        }

        .modal-content {
            display: flex;
            flex-direction: row;
            width: 50%;
        }

        .modal-content>div {
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="navbar bg-gray-100 shadow-xl py-3 shadow-xl">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Logo</a>
        </div>
        <div class="flex-none gap-2">
            <div class="form-control">
                <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" id="recherche-filtre" />
                <!-- <input type="text" placeholder="Rechercher..." class="p-2 rounded mr-20 text-black" id="recherche-filtre"> -->

            </div>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                    </div>
                </div>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li>
                        <a class="justify-between">
                            Profile
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li><a>Settings</a></li>
                    <li><a>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- *****************************side barre********************************************************* -->
    <div class="h-screen w-64 bg-black text-white fixed flex">
        <ul class="list-none p-0 m-0">
            <li class="menu-item relative">
                <a href="#" class="flex justify-between items-center p-4 hover:bg-gray-700">
                    <span>
                        <i class="fas fa-ship w-6"></i>
                        Cargaisons</span>
                    <i class="fas fa-chevron-down ml-2"></i>
                </a>
                <ul class="submenu list-none p-0 m-0 bg-gray-800">
                    <!-- <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Liste cargaisons</a></li> -->
                    <!-- <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Ajouter cargaison</a></li> -->
                    <li class="mb-2 flex items-center btn-add">
                        <i class="fas fa-plus ml-4 cursor-pointer"></i>
                        <a href="#" class="block p-2 ml-2">
                            <button id="btn-add" class="text-white bg-blue-500 px-4 py-2 rounded">Ajouter </button>
                        </a>
                    </li>


                </ul>
            </li>
            <li class="menu-item relative">
                <a href="#" class="flex justify-between items-center p-4 hover:bg-gray-700">
                    <span><i class="fas fa-list mr-2"></i> Produit</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="submenu list-none p-0 m-0 bg-gray-800">
                    <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Sous-menu 1</a></li>
                    <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Sous-menu 2</a></li>
                    <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Sous-menu 3</a></li>
                </ul>
            </li>
            <li class="menu-item relative">
                <a href="#" class="flex justify-between items-center p-4 hover:bg-gray-700">
                    <span><i class="fas fa-cog mr-2"></i> Paramètre</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="submenu list-none p-0 m-0 bg-gray-800">
                    <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Sous-menu 1</a></li>
                    <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Sous-menu 2</a></li>
                    <li><a href="#" class="block p-4 pl-8 hover:bg-gray-700">Sous-menu 3</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg modal-content w-9/12">
            <div class="pr-4">
                <h2 class="text-xl font-bold mb-4">Ajouter une cargaison</h2>
                <form id="form-add-cargaison">
                    <input type="hidden" class="form-control" id="produit-id">
                    <div class="mb-4 flex">
                        <div class="flex-1 mr-4">
                            <label for="type-cargaison" class="block text-sm font-medium text-gray-700">Type de cargaison</label>
                            <select id="type-cargaison" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                                <option value="CargaisonMaritime">Maritime</option>
                                <option value="CargaisonAérienne">Aérienne</option>
                                <option value="CargaisonRoutière">Routière</option>
                            </select>
                            <span class="text-red-500 text-sm hidden" id="type-cargaison-error">Type de cargaison est obligatoire</span>
                        </div>
                        <div class="flex-1 ml-4">
                            <label for="nom-cargaison" class="block text-sm font-medium text-gray-700">Nom Cargaison</label>
                            <input type="text" id="nom-cargaison" class="mt-1 block w-full p-2 border border-gray-300 rounded" pattern="[A-Za-z\s]+" title="Le nom de cargaison ne doit contenir que des lettres et des espaces">
                            <span class="text-red-500 text-sm hidden" id="nom-cargaison-error">Nom de cargaison est obligatoire et ne doit contenir que des lettres et des espaces</span>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="flex-1 mr-4">
                            <label class="block text-sm font-medium text-gray-700" for="poids-suporter">Poids supporter</label>
                            <select class="mt-1 block w-full p-2 border border-gray-300 rounded" id="poids-suporter">
                                <option value="poids">Poids en kg/t</option>
                                <option value="nombre">Nombre de produits</option>
                            </select>
                            <span class="text-red-500 text-sm hidden" id="poids-suporter-error">Poids supporter est obligatoire</span>
                        </div>
                        <div class="flex-1 ml-4" id="champ-saisi">
                            <label class="block text-sm font-medium text-gray-700" for="valeur"></label>
                            <input class="mt-1 block w-full p-2 border border-gray-300 rounded" type="number" id="valeur-max" placeholder="">
                            <span class="text-red-500 text-sm hidden" id="valeur-error">Valeur est obligatoire</span>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="flex-1 mr-4">
                            <label for="date-depart" class="block text-sm font-medium text-gray-700">Date départ</label>
                            <input type="date" id="date-depart" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <span class="text-red-500 text-sm hidden" id="date-depart-error">Date de départ incorrecte</span>
                        </div>
                        <div class="flex-1 ml-4">
                            <label for="date-arrivee" class="block text-sm font-medium text-gray-700">Date arrivée</label>
                            <input type="date" id="date-arrivee" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                            <span class="text-red-500 text-sm hidden" id="date-arrivee-error">Date d'arrivée est obligatoire</span>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="flex-1 mr-4">
                            <label for="depart" class="block text-sm font-medium text-gray-700">Lieu Départ</label>
                            <input type="text" id="depart" class="mt-1 block w-full p-2 border border-gray-300 rounded" readonly>
                            <span class="text-red-500 text-sm hidden" id="depart-error">Lieu de départ est obligatoire</span>
                        </div>
                        <div class="flex-1 ml-4">
                            <label for="arrivee" class="block text-sm font-medium text-gray-700">Lieu Arrivée</label>
                            <input type="text" id="arrivee" class="mt-1 block w-full p-2 border border-gray-300 rounded" readonly>
                            <span class="text-red-500 text-sm hidden" id="arrivee-error">Lieu d'arrivée est obligatoire</span>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="flex-1 mr-4">
                            <label for="distance" class="block text-sm font-medium text-gray-700">Distance</label>
                            <input type="number" id="distance" class="mt-1 block w-full p-2 border border-gray-300 rounded" readonly>
                            <span class="text-red-500 text-sm hidden" id="distance-error">Distance est obligatoire</span>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="btn-close-modal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Annuler</button>
                        <button id="ajouter" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
                    </div>
                </form>
            </div>
            <div id="map"></div>
        </div>
    </div>
    <script type="module" src="./dist/main.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        let map, departMarker, arriveeMarker;

        map = L.map("map").setView([0, 0], 2);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 18,
        }).addTo(map);

        map.on("click", function(e) {
            if (!departMarker) {
                departMarker = L.marker(e.latlng, {
                        draggable: true
                    }).addTo(map)
                    .bindPopup("Lieu de départ")
                    .openPopup();
                updateInputWithLocationName(e.latlng, "depart");

                departMarker.on('dragend', function(event) {
                    let marker = event.target;
                    let position = marker.getLatLng();
                    updateInputWithLocationName(position, "depart");
                    if (arriveeMarker) {
                        calculateDistance(position, arriveeMarker.getLatLng());
                    }
                });

            } else if (!arriveeMarker) {
                arriveeMarker = L.marker(e.latlng, {
                        draggable: true
                    }).addTo(map)
                    .bindPopup("Lieu d'arrivée")
                    .openPopup();
                updateInputWithLocationName(e.latlng, "arrivee");
                calculateDistance(departMarker.getLatLng(), e.latlng);

                arriveeMarker.on('dragend', function(event) {
                    let marker = event.target;
                    let position = marker.getLatLng();
                    updateInputWithLocationName(position, "arrivee");
                    calculateDistance(departMarker.getLatLng(), position);
                });
            } else {
                arriveeMarker.setLatLng(e.latlng);
                updateInputWithLocationName(e.latlng, "arrivee");
                calculateDistance(departMarker.getLatLng(), e.latlng);
            }
        });

        function updateInputWithLocationName(latlng, inputId) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}`)
                .then(response => response.json())
                .then(data => {
                    if (inputId === "depart") {
                        const country = data.address.country || `${latlng.lat}, ${latlng.lng}`;
                        document.getElementById(inputId).value = country;
                    } else if (inputId === "arrivee") {
                        const country = data.address.country || `${latlng.lat}, ${latlng.lng}`;
                        document.getElementById(inputId).value = country;
                    }
                })
                .catch(error => {
                    console.error('Error fetching location name:', error);
                    document.getElementById(inputId).value = `${latlng.lat}, ${latlng.lng}`;
                });
        }


        function calculateDistance(start, end) {
            const lat1 = start.lat;
            const lon1 = start.lng;
            const lat2 = end.lat;
            const lon2 = end.lng;

            const R = 6371; // Radius of the Earth in km
            const dLat = ((lat2 - lat1) * Math.PI) / 180;
            const dLon = ((lon2 - lon1) * Math.PI) / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos((lat1 * Math.PI) / 180) *
                Math.cos((lat2 * Math.PI) / 180) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;

            document.getElementById("distance").value = distance.toFixed(2);
        }

        const choixSelect = document.getElementById("poids-suporter");
        const champSaisi = document.getElementById("champ-saisi");
        const labelValeur = document.querySelector("#champ-saisi label");
        const inputValeur = document.getElementById("valeur-max");

        choixSelect.addEventListener("change", function() {
            if (this.value === "poids") {
                champSaisi.classList.remove("hidden");
                labelValeur.textContent = "Poids maximal";
                inputValeur.placeholder = "Entrez le poids maximal";
            } else if (this.value === "nombre") {
                champSaisi.classList.remove("hidden");
                labelValeur.textContent = "Nombre maximal de produits";
                inputValeur.placeholder = "Entrez le nombre maximal de produits";
            } else {
                champSaisi.classList.add("hidden");
            }
        });

        // Invalidate the map size to ensure it renders correctly
        setTimeout(() => {
            map.invalidateSize();
        }, 100);




        // document.getElementById('form-add-cargaison').addEventListener('submit', (event) => {
        //     event.preventDefault();

        //     const numero = "CRG" + Math.floor(Math.random() * 1000);
        //     const typeCargaison = document.getElementById('type-cargaison').value.trim();
        //     const nom_cargaison = document.getElementById('nom-cargaison').value.trim();
        //     const poids_suporter = document.getElementById('poids-suporter').value.trim();
        //     const date_depart = document.getElementById('date-depart').value.trim();
        //     const date_arrivee = document.getElementById('date-arrivee').value.trim();
        //     const lieu_depart = document.getElementById('depart').value.trim();
        //     const lieu_arrivee = document.getElementById('arrivee').value.trim();
        //     const distance_km = document.getElementById('distance').value.trim();
        //     const etat_avancement = "en attente";
        //     const etat_globale = "ouvert";

        //     const formData = new FormData();
        //     formData.append('action', 'addCargaison');
        //     formData.append('numero', numero);
        //     formData.append('lieu_depart', lieu_depart);
        //     formData.append('lieu_arrivee', lieu_arrivee);
        //     formData.append('distance_km', distance_km);
        //     formData.append('type', typeCargaison);
        //     formData.append('etat_avancement', etat_avancement);
        //     formData.append('etat_globale', etat_globale);
        //     formData.append('poids_suporter', poids_suporter);
        //     formData.append('date_depart', date_depart);
        //     formData.append('date_arrivee', date_arrivee);
        //     formData.append('nom_cargaison', nom_cargaison);

        //     fetch('api.php', {
        //             method: 'POST',
        //             body: formData
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.status === "success") {
        //                 alert(data.message);
        //                 afficherCargaisons(); // Rafraîchir le tableau après ajout
        //                 const modal = document.getElementById('modal');
        //                 if (modal) modal.classList.add('hidden');
        //             } else {
        //                 alert('Erreur lors de l\'ajout de la cargaison');
        //             }
        //         })
        //     // .catch(error => console.error('Erreur:', error));
        // });
    </script>
</body>

</html>
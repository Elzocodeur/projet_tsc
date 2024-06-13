<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <title>gestion cargaisons</title>

    <!-- <link rel="stylesheet" href="./dist/css/style.css"> -->

    <style>
        .background-image {
            background-image: url('https://static.vecteezy.com/ti/photos-gratuite/p2/21869194-transport-et-la-logistique-importer-exportation-et-transport-industrie-de-un-camion-recipient-cargaison-bateau-generatif-ai-gratuit-photo.JPG');
            background-size: cover;
            background-position: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Background transparent noir */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-neutral-100 h-screen flex justify-center items-center relative">

    <div class="background-image absolute inset-0"></div>
    <div class="overlay"></div>
    <div class="relative z-10 w-full max-w-md bg-white bg-opacity-80 rounded-lg p-6 shadow-lg">
        <div class="text-center mb-4">
            <a href="cargaison" class="text-3xl font-bold"><b>GP-</b>monde</a>
        </div>
        <div class="card-body mx-6">
            <p class="login-box-msg text-center text-lg mb-4">Gestion de cargaisons</p>
            <div id="error-message" class="text-red-500 mb-4 hidden">Login ou mot de passe incorrect</div>
            <form id="login-form">
                <div class="input-group mb-3 flex items-center">
                    <input type="email" id="email" class="form-control border border-gray-300 rounded-l-lg p-2 flex-grow" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text bg-gray-200 border border-gray-300 rounded-r-lg p-2">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 flex items-center">
                    <input type="password" id="password" class="form-control border border-gray-300 rounded-l-lg p-2 flex-grow" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text bg-gray-200 border border-gray-300 rounded-r-lg p-2">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <button type="submit" class="btn btn-primary btn-block px-4 py-2 bg-blue-600 text-white rounded-lg">Se connecter</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary btn-block px-4 py-2 bg-gray-600 text-white rounded-lg" id="view-product-btn">Voir produit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

 
  <!-- Product Modal -->
<div id="productModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
  <div class="modal-content relative bg-white rounded-lg shadow-lg mx-auto my-20 p-6 w-1/3">
    <span class="close absolute top-2 right-2 cursor-pointer text-2xl">&times;</span>
    <h2 class="text-2xl mb-4">Rechercher un produit</h2>
    <input type="text" id="product-search" class="form-control border border-gray-300 rounded-lg p-2 w-full mb-4" placeholder="Entrez l'ID du produit">
    <div id="product-info" class="hidden">
      <table class="w-full table-auto border-collapse border border-gray-400">
        <thead>
          <tr>
            <th class="border border-gray-300 px-4 py-2">Nom du produit</th>
            <th class="border border-gray-300 px-4 py-2">Poids</th>
            <th class="border border-gray-300 px-4 py-2">État d'avancement</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-gray-300 px-4 py-2" id="product-name"></td>
            <td class="border border-gray-300 px-4 py-2" id="product-weight"></td>
            <td class="border border-gray-300 px-4 py-2" id="product-stage"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="no-product-message" class="text-red-500 hidden">Ce code produit n'existe pas</div>
  </div>
</div>

    <script src="./dist/main.js" defer></script>
    <script>

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');

            if (email === 'gningeli03@gmail.com' && password === 'admin') {
                emailField.classList.remove('border-red-500');
                emailField.classList.add('border-green-500');
                passwordField.classList.remove('border-red-500');
                passwordField.classList.add('border-green-500');
                errorMessage.classList.add('hidden');
                window.location.href = 'cargaison';
            } else {
                emailField.classList.remove('border-green-500');
                emailField.classList.add('border-red-500');
                passwordField.classList.remove('border-green-500');
                passwordField.classList.add('border-red-500');
                errorMessage.classList.remove('hidden');
            }
        });


    </script>
</body>

</html>
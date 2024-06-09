<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <title>gestion cargaisons</title>
    <link rel="stylesheet" href="./dist/css/style.css">
</head>

<body class="bg-neutral-100 h-screen flex justify-center items-center background-image">
    <div class="w-full max-w-md bg-white bg-opacity-80 rounded-lg p-6 shadow-lg">
        <div class="text-center mb-4">
            <a href="../../index2.html" class="text-3xl font-bold"><b>GP-</b>monde</a>
        </div>
        <div class="card-body">
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
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="form-checkbox h-4 w-4 text-blue-600">
                        <label for="remember" class="ml-2 text-sm">Remember Me</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-block px-4 py-2 bg-blue-600 text-white rounded-lg">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function (e) {
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

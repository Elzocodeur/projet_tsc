<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="./dist/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <title>Document</title>
    <link rel="stylesheet" href="./dist/css/style.css">
    <style>
        .submenu {
            display: none;
        }

        .menu-item:hover .submenu {
            display: block;
        }
    </style>
</head>

<body>
    <div class="text-blue-800">IL n'est pas sérieux</div>
   
<div class="navbar bg-base-100 shadow-xl py-3">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Logo</a>
        </div>
        <div class="flex-none gap-2">
            <!-- <div class="form-control">
                </div> -->
                <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
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
    <div class="h-screen w-64 bg-black text-white fixed ">
        <ul class="list-none p-0 m-0">
            <li class="menu-item relative">
                <a href="#" class="flex justify-between items-center p-4 hover:bg-gray-700">
                    <span><i class="fas fa-sign-in-alt mr-2"></i> Login</span>
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
                    <span><i class="fas fa-plus mr-2"></i> Ajouter</span>
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
                    <span><i class="fas fa-list mr-2"></i> Lister Gestion</span>
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
    <div class="login-box mx-32">
        <div class="login-logo">
            <a href="../../index2.html"><b>GP-</b>monde</a>
        </div>
        <div class="card w-96">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="../../index3.html" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" data-listener-added_65d04d32="true" data-sider-select-id="29268ffe-4ec0-4307-be25-503220112cdf">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" data-sider-insert-id="c97a9a73-2b48-4054-badc-0e99b63c89b5" data-listener-added_65d04d32="true" data-sider-select-id="f048249f-2091-4ca8-853f-502d0b4f4dfe">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>





    <script src="./dist/main.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script> -->
</body>

</html>
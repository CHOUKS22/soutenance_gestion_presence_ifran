<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard Coordinateur</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <!-- Logo et nom -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-800">IFRAN</h1>
                        <p class="text-sm text-gray-600">Coordinateur</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4">
                <!-- Dashboard -->
                <a href="{{ route('coordinateur.dashboard') }}"
                   class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('coordinateur.dashboard') ? 'bg-green-50 text-green-700 border-r-2 border-green-600' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <!-- Gestion des Classes -->
                <div class="mb-4">
                    <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Gestion des Classes</h3>

                    <!-- Mes Classes -->
                    <a href="{{route('gestion-classes.index')}}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3 font-medium">Mes Classes</span>
                    </a>

                    <!-- Emploi du Temps -->
                    <a href="#"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span class="ml-3 font-medium">Emploi du Temps</span>
                    </a>
                </div>

                <!-- Gestion des Séances -->
                <div class="mb-4">
                    <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Séances</h3>

                    <!-- Planifier Séance -->
                    <a href="{{ route('gestion-seances.create') }}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-plus-circle"></i>
                        <span class="ml-3 font-medium">Planifier Séance</span>
                    </a>

                    <!-- Toutes les Séances -->
                    <a href="{{ route('gestion-seances.index') }}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-list"></i>
                        <span class="ml-3 font-medium">Toutes les Séances</span>
                    </a>

                    <!-- Séances Aujourd'hui -->
                    <a href="{{ route('seances.aujourdhui') }}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-calendar-day"></i>
                        <span class="ml-3 font-medium">Aujourd'hui</span>
                    </a>

                    <!-- Séances Cette Semaine -->
                    <a href="{{ route('seances.cette-semaine') }}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-calendar-week"></i>
                        <span class="ml-3 font-medium">Cette Semaine</span>
                    </a>

                    <!-- Séances Prochaines -->
                    <a href="{{ route('seances.prochaines') }}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-clock"></i>
                        <span class="ml-3 font-medium">Prochaines Séances</span>
                    </a>

                    <!-- Historique Séances -->
                    <a href="{{ route('seances.historique') }}"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-history"></i>
                        <span class="ml-3 font-medium">Historique</span>
                    </a>
                </div>

                <!-- Gestion des Présences -->
                <div class="mb-4">
                    <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Présences</h3>

                    <!-- Prendre Présence -->
                    <a href="#"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-check-circle w-5"></i>
                        <span class="ml-3 font-medium">Prendre Présence</span>
                    </a>

                    <!-- Rapports Présences -->

                </div>

                <!-- Étudiants -->
                <div class="mb-4">
                    <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Étudiants</h3>

                    <!-- Liste Étudiants -->
                    <a href="#"
                       class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-user-graduate w-5"></i>
                        <span class="ml-3 font-medium">Mes Étudiants</span>
                    </a>

                    <!-- Performance -->

                </div>
            </nav>

            {{-- <!-- Profil utilisateur -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->prenom ?? 'Coordinateur' }} {{ Auth::user()->nom ?? '' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                </div>
            </div> --}}
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-600 mt-1">@yield('subtitle', 'Bienvenue dans votre espace coordinateur')</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- Date actuelle -->
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-calendar-day mr-2"></i>
                                {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                            </div>

                            <!-- Menu utilisateur -->
                            <div class="relative">
                                <button id="userMenuButton" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                        @if(auth()->user()->photo)
                                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Photo de profil" class="w-full h-full object-cover rounded-full">
                                        @else
                                            <i class="fas fa-user text-white text-sm"></i>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 hidden md:block">{{ Auth::user()->prenom ?? 'Coordinateur' }}</span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </button>

                                <!-- Menu déroulant -->
                                <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                                    <div class="py-2">
                                        <div class="px-4 py-3 border-b border-gray-200">
                                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->nom ?? 'Coordinateur' }} {{ auth()->user()->prenom ?? '' }}</p>
                                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                                        </div>
                                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-3"></i>Mon profil
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cog mr-3"></i>Paramètres
                                        </a>
                                        <div class="border-t border-gray-200 my-1"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-6 overflow-y-auto" style="height: calc(100vh - 80px);">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Gestion du menu utilisateur
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });

            // Fermer le menu en cliquant ailleurs
            document.addEventListener('click', function(e) {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });

            // Empêcher la fermeture du menu en cliquant à l'intérieur
            userMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    </script>
</body>
</html>

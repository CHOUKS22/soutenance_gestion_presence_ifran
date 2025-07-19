<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Dashboard Étudiant</h1>
                <div class="flex items-center space-x-4">
                    <span>Bienvenue, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Mes Cours -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Mes Cours</h3>
                    </div>
                    <p class="text-gray-600">Voir mon emploi du temps et mes cours</p>
                </div>

                <!-- Mes Notes -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Mes Notes</h3>
                    </div>
                    <p class="text-gray-600">Consulter mes évaluations et résultats</p>
                </div>

                <!-- Mes Séances -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Mes Séances</h3>
                    </div>
                    <p class="text-gray-600">Voir mes séances à venir</p>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Informations</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Nom:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Rôle:</strong> {{ auth()->user()->role->nom }}</p>
                    </div>
                    <div>
                        <p class="text-green-600 font-semibold">✅ Redirection étudiant fonctionnelle</p>
                        <p class="text-sm text-gray-600">Vous êtes bien connecté en tant qu'étudiant</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

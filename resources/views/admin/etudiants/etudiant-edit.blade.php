@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Modifier les informations de l'Étudiant</h1>
            <a href="{{ route('gestion-etudiants.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>

        <!-- Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Formulaire de modification -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Informations de l'utilisateur (lecture seule) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Informations de l'utilisateur (lecture seule)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nom</label>
                        <p class="text-sm text-gray-900">{{ $etudiant->user->nom }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Prénom</label>
                        <p class="text-sm text-gray-900">{{ $etudiant->user->prenom }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="text-sm text-gray-900">{{ $etudiant->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Photo</label>
                        <div class="flex items-center space-x-2">
                            @if($etudiant->user->photo)
                                <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200"
                                     src="{{ asset('storage/' . $etudiant->user->photo) }}"
                                     alt="{{ $etudiant->user->nom }}">
                                <span class="text-sm text-gray-900">Photo disponible</span>
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <span class="text-sm text-gray-900">Aucune photo</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('gestion-etudiants.update', $etudiant) }}">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier les informations spécifiques
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date de naissance -->
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance"
                               value="{{ old('date_naissance', $etudiant->date_naissance ? $etudiant->date_naissance->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('date_naissance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lieu de naissance -->
                    <div>
                        <label for="lieu_naissance" class="block text-sm font-medium text-gray-700 mb-1">Lieu de naissance</label>
                        <input type="text" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $etudiant->lieu_naissance) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('lieu_naissance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="md:col-span-2">
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('telephone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('gestion-etudiants.show', $etudiant) }}"
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Sauvegarder</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

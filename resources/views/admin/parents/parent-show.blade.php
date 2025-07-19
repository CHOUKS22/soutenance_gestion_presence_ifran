@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Détails du Parent</h1>
            <div class="flex space-x-2">
                <a href="{{ route('gestion-parents.edit', $parent) }}"
                   class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>
                <a href="{{ route('gestion-parents.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
            </div>
        </div>

        <!-- Profil du parent -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center space-x-6 mb-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0">
                        @if($parent->user->photo)
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-200"
                                 src="{{ asset('storage/' . $parent->user->photo) }}"
                                 alt="{{ $parent->user->nom }}">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200">
                                <i class="fas fa-user text-gray-500 text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Informations principales -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $parent->user->nom }} {{ $parent->user->prenom }}
                        </h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                {{ $parent->user->email }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                Parent
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informations détaillées -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations personnelles -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            Informations personnelles
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Nom</label>
                                <p class="text-sm text-gray-900">{{ $parent->user->nom }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Prénom</label>
                                <p class="text-sm text-gray-900">{{ $parent->user->prenom }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Type de relation</label>
                                <p class="text-sm text-gray-900">{{ $parent->type_relation }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de contact -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-address-book mr-2"></i>
                            Informations de contact
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email</label>
                                <p class="text-sm text-gray-900">{{ $parent->user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Téléphone</label>
                                <p class="text-sm text-gray-900">{{ $parent->telephone ?: 'Non défini' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations système -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-cog mr-2"></i>
                            Informations système
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Rôle</label>
                                <p class="text-sm text-gray-900">{{ $parent->user->role->nom ?? 'Non défini' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Date de création</label>
                                <p class="text-sm text-gray-900">{{ $parent->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Dernière modification</label>
                                <p class="text-sm text-gray-900">{{ $parent->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Statistiques
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-medium text-gray-600">Compte créé depuis</label>
                                <p class="text-sm text-gray-900">{{ $parent->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-medium text-gray-600">Étudiants assignés</label>
                                <p class="text-sm text-gray-900">{{ $parent->etudiants->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étudiants assignés -->
                @if($parent->etudiants->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            Étudiants assignés
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($parent->etudiants as $etudiant)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($etudiant->user->photo)
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                     src="{{ asset('storage/' . $etudiant->user->photo) }}"
                                                     alt="{{ $etudiant->user->nom }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $etudiant->user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <p class="text-sm text-yellow-800">Aucun étudiant n'est assigné à ce parent.</p>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('gestion-parents.edit', $parent) }}"
                       class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Modifier</span>
                    </a>
                    <form method="POST" action="{{ route('gestion-parents.destroy', $parent) }}"
                          class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors flex items-center space-x-2">
                            <i class="fas fa-trash"></i>
                            <span>Supprimer</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

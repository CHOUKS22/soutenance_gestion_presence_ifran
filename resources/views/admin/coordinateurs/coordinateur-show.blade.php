@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Détails du Coordinateur</h1>
            <div class="flex space-x-2">
                <a href="{{ route('gestion-coordinateurs.edit', $coordinateur) }}"
                   class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>
                <a href="{{ route('gestion-coordinateurs.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
            </div>
        </div>

        <!-- Profil du coordinateur -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center space-x-6 mb-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0">
                        @if($coordinateur->user->photo)
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-200"
                                 src="{{ asset('storage/' . $coordinateur->user->photo) }}"
                                 alt="{{ $coordinateur->user->nom }}">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200">
                                <i class="fas fa-user text-gray-500 text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Informations principales -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $coordinateur->user->nom }} {{ $coordinateur->user->prenom }}
                        </h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                {{ $coordinateur->user->email }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                @if($coordinateur->role === 'coordinateur_pedagogique')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        Coordinateur Pédagogique
                                    </span>
                                @elseif($coordinateur->role === 'coordinateur_filliere')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                        Coordinateur de Filière
                                    </span>
                                @endif
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
                                <p class="text-sm text-gray-900">{{ $coordinateur->user->nom }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Prénom</label>
                                <p class="text-sm text-gray-900">{{ $coordinateur->user->prenom }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Type de coordinateur</label>
                                <p class="text-sm text-gray-900">
                                    @if($coordinateur->role === 'coordinateur_pedagogique')
                                        Coordinateur Pédagogique
                                    @elseif($coordinateur->role === 'coordinateur_filliere')
                                        Coordinateur de Filière
                                    @endif
                                </p>
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
                                <p class="text-sm text-gray-900">{{ $coordinateur->user->email }}</p>
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
                                <label class="block text-sm font-medium text-gray-600">Rôle système</label>
                                <p class="text-sm text-gray-900">{{ $coordinateur->user->role->nom ?? 'Non défini' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Date de création</label>
                                <p class="text-sm text-gray-900">{{ $coordinateur->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Dernière modification</label>
                                <p class="text-sm text-gray-900">{{ $coordinateur->updated_at->format('d/m/Y à H:i') }}</p>
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
                                <p class="text-sm text-gray-900">{{ $coordinateur->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('gestion-coordinateurs.edit', $coordinateur) }}"
                       class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Modifier</span>
                    </a>
                    <form method="POST" action="{{ route('gestion-coordinateurs.destroy', $coordinateur) }}"
                          class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coordinateur ?')">
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

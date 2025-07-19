@extends('layouts.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Détails de l'utilisateur</h1>
            <p class="text-gray-600">Informations détaillées de l'utilisateur</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('users.edit', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6">
            <!-- Informations de base -->
            <div class="flex items-start space-x-6 mb-6">
                <!-- Photo -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center overflow-hidden">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de {{ $user->nom }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-blue-600 font-semibold text-2xl">
                                {{ substr($user->nom, 0, 1) }}{{ substr($user->prenom, 0, 1) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $user->nom }} {{ $user->prenom }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900 flex items-center">
                                <i class="fas fa-envelope mr-2 text-gray-500"></i>
                                {{ $user->email }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                            <span class="px-3 py-1 rounded-full text-sm font-medium inline-flex items-center
                                {{ ($user->role->nom ?? '') === 'admin' ? 'bg-red-100 text-red-600' : '' }}
                                {{ ($user->role->nom ?? '') === 'etudiant' ? 'bg-blue-100 text-blue-600' : '' }}
                                {{ ($user->role->nom ?? '') === 'professeur' ? 'bg-green-100 text-green-600' : '' }}
                                {{ ($user->role->nom ?? '') === 'coordinateur' ? 'bg-purple-100 text-purple-600' : '' }}
                                {{ ($user->role->nom ?? '') === 'parent' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                {{ !$user->role ? 'bg-gray-100 text-gray-600' : '' }}
                            ">
                                <i class="fas fa-user-tag mr-2"></i>
                                {{ ucfirst($user->role->nom ?? 'Aucun rôle') }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de création</label>
                            <p class="text-gray-900 flex items-center">
                                <i class="fas fa-calendar-plus mr-2 text-gray-500"></i>
                                {{ $user->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dernière modification</label>
                            <p class="text-gray-900 flex items-center">
                                <i class="fas fa-calendar-edit mr-2 text-gray-500"></i>
                                {{ $user->updated_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 text-lg mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Compte créé depuis</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-user-check text-green-600 text-lg mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Statut</p>
                                <p class="text-lg font-semibold text-green-800">Actif</p>
                            </div>
                        </div>
                    </div> --}}
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-id-badge text-purple-600 text-lg mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">ID utilisateur</p>
                                <p class="text-lg font-semibold text-gray-800">#{{ $user->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t pt-6">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-3">
                        <a href="{{ route('users.edit', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>Modifier
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <i class="fas fa-trash mr-2"></i>Supprimer
                            </button>
                        </form>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Dernière modification il y a {{ $user->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

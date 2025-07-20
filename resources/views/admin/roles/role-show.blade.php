@extends('layouts.admin')

@section('title', 'Détails du Rôle')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Détails du Rôle</h1>
            <p class="text-gray-600 mt-1">{{ $role->nom }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('gestion-roles.edit', $role) }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('gestion-roles.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Informations du Rôle</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du Rôle</label>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-lg font-semibold text-blue-600">{{ $role->nom }}</div>
                        </div>
                    </div>
                    @if($role->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-gray-700">{{ $role->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Métadonnées</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Créé le :</span>
                            <span class="font-medium">{{ $role->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Modifié le :</span>
                            <span class="font-medium">{{ $role->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Statistiques</h2>
                <div class="space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $role->users_count ?? 0 }}</div>
                        <div class="text-sm text-blue-800">Utilisateurs assignés</div>
                    </div>
                </div>
            </div>

            <!-- Liste des utilisateurs si disponible -->
            @if($role->users && $role->users->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Utilisateurs Assignés</h2>
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @foreach($role->users as $user)
                    <div class="flex items-center p-2 bg-gray-50 rounded">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                            {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">
                                {{ $user->nom }} {{ $user->prenom }}
                            </div>
                            <div class="text-sm text-gray-600">{{ $user->email }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

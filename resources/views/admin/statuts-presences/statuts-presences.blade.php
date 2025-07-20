@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Statuts de Présences</h1>
            <a href="{{ route('gestion-statuts-presences.create') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Nouveau Statut</span>
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Statuts</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $statutsPresences->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-user-check text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Présences</p>
                        <p class="text-3xl font-bold text-green-600">
                            {{ $statutsPresences->sum(function($statut) { return $statut->presences ? $statut->presences->count() : 0; }) }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Statut Principal</p>
                        <p class="text-sm font-bold text-purple-600">
                            {{ $statutsPresences->sortByDesc(function($statut) { return $statut->presences ? $statut->presences->count() : 0; })->first()?->libelle ?? 'Aucun' }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-star text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Dernière Création</p>
                        <p class="text-sm font-bold text-orange-600">
                            {{ $statutsPresences->sortByDesc('created_at')->first()?->created_at->format('d/m/Y') ?? 'Aucune' }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des statuts -->
        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Liste des Statuts de Présences</h2>
            </div>

            @if($statutsPresences->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Présences</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Créé le</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($statutsPresences as $statut)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="p-2
                                                @if(str_contains(strtolower($statut->libelle), 'présent')) bg-green-100
                                                @elseif(str_contains(strtolower($statut->libelle), 'absent')) bg-red-100
                                                @elseif(str_contains(strtolower($statut->libelle), 'retard')) bg-yellow-100
                                                @else bg-blue-100 @endif
                                                rounded-lg mr-3">
                                                <i class="fas
                                                    @if(str_contains(strtolower($statut->libelle), 'présent')) fa-check text-green-600
                                                    @elseif(str_contains(strtolower($statut->libelle), 'absent')) fa-times text-red-600
                                                    @elseif(str_contains(strtolower($statut->libelle), 'retard')) fa-clock text-yellow-600
                                                    @else fa-user-check text-blue-600 @endif
                                                "></i>
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-900">{{ $statut->libelle }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-700 text-sm">
                                            {{ $statut->description ? Str::limit($statut->description, 80) : 'Aucune description' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-sm font-medium
                                            @if(str_contains(strtolower($statut->libelle), 'présent')) bg-green-100 text-green-800
                                            @elseif(str_contains(strtolower($statut->libelle), 'absent')) bg-red-100 text-red-800
                                            @elseif(str_contains(strtolower($statut->libelle), 'retard')) bg-yellow-100 text-yellow-800
                                            @else bg-purple-100 text-purple-800 @endif
                                            rounded-full">
                                            {{ $statut->presences ? $statut->presences->count() : 0 }} présences
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $statut->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('gestion-statuts-presences.show', $statut->id) }}"
                                               class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors"
                                               title="Voir les détails">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            <a href="{{ route('gestion-statuts-presences.edit', $statut->id) }}"
                                               class="bg-yellow-600 text-white p-2 rounded-lg hover:bg-yellow-700 transition-colors"
                                               title="Modifier">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form method="POST" action="{{ route('gestion-statuts-presences.destroy', $statut->id) }}"
                                                  class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition-colors"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="p-4 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-check text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun statut de présence</h3>
                    <p class="text-gray-500 mb-6">Commencez par créer votre premier statut de présence.</p>
                    <a href="{{ route('gestion-statuts-presences.create') }}"
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Créer un Statut</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Types de Séances</h1>
            <a href="{{ route('gestion-types-seances.create') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Nouveau Type</span>
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Types</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $type_seance->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-tags text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Types Actifs</p>
                        <p class="text-3xl font-bold text-green-600">{{ $type_seance->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Séances Totales</p>
                        <p class="text-3xl font-bold text-purple-600">
                            {{ $type_seance->sum(function($type) { return $type->seances ? $type->seances->count() : 0; }) }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Dernière Création</p>
                        <p class="text-sm font-bold text-orange-600">
                            {{ $type_seance->sortByDesc('created_at')->first()?->created_at->format('d/m/Y') ?? 'Aucune' }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des types de séances -->
        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Liste des Types de Séances</h2>
            </div>

            @if($type_seance->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Séances</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Créé le</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($type_seance as $typeSeance)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                                <i class="fas fa-tag text-blue-600"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-900">{{ $typeSeance->nom }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-700 text-sm">
                                            {{ Str::limit($typeSeance->description, 100) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-800 rounded-full">
                                            {{ $typeSeance->seances ? $typeSeance->seances->count() : 0 }} séances
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $typeSeance->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('gestion-types-seances.show', $typeSeance->id) }}"
                                               class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors"
                                               title="Voir les détails">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            <a href="{{ route('gestion-types-seances.edit', $typeSeance->id) }}"
                                               class="bg-yellow-600 text-white p-2 rounded-lg hover:bg-yellow-700 transition-colors"
                                               title="Modifier">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form method="POST" action="{{ route('gestion-types-seances.destroy', $typeSeance->id) }}"
                                                  class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de séance ?')">
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
                        <i class="fas fa-tags text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun type de séance</h3>
                    <p class="text-gray-500 mb-6">Commencez par créer votre premier type de séance.</p>
                    <a href="{{ route('gestion-types-seances.create') }}"
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Créer un Type de Séance</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

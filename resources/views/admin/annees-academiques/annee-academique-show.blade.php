@extends('layouts.admin')

@section('title', 'Détails de l\'Année Académique')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Détails de l'Année Académique</h1>
            <p class="text-gray-600 mt-1">{{ $annee_academique->libelle }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('gestion-annees-academiques.edit', ['gestion_annees_academique' => $annee_academique->id]) }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('gestion-annees-academiques.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Informations de l'Année Académique</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Libellé</label>
                        <p class="text-lg text-gray-900">{{ $annee_academique->libelle }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Statut</label>
                        @if($annee_academique->date_debut && $annee_academique->date_fin)
                            @php
                                $now = \Carbon\Carbon::now();
                                $debut = \Carbon\Carbon::parse($annee_academique->date_debut);
                                $fin = \Carbon\Carbon::parse($annee_academique->date_fin);
                            @endphp

                            @if($now->lt($debut))
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>À venir
                                </span>
                            @elseif($now->between($debut, $fin))
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-play mr-1"></i>En cours
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-check mr-1"></i>Terminée
                                </span>
                            @endif
                        @else
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Dates non définies
                            </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date de début</label>
                        <p class="text-lg text-gray-900">
                            {{ $annee_academique->date_debut ? \Carbon\Carbon::parse($annee_academique->date_debut)->format('d/m/Y') : 'Non définie' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date de fin</label>
                        <p class="text-lg text-gray-900">
                            {{ $annee_academique->date_fin ? \Carbon\Carbon::parse($annee_academique->date_fin)->format('d/m/Y') : 'Non définie' }}
                        </p>
                    </div>
                </div>

                <!-- Durée de l'année académique -->
                @if($annee_academique->date_debut && $annee_academique->date_fin)
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Durée de l'année académique</h3>
                    <p class="text-blue-700">
                        {{ \Carbon\Carbon::parse($annee_academique->date_debut)->diffInDays(\Carbon\Carbon::parse($annee_academique->date_fin)) }} jours
                        ({{ \Carbon\Carbon::parse($annee_academique->date_debut)->diffInMonths(\Carbon\Carbon::parse($annee_academique->date_fin)) }} mois)
                    </p>
                </div>
                @endif
            </div>

            <!-- Semestres associés -->
            <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Semestres associés</h2>

                @if($annee_academique->semestres && $annee_academique->semestres->count() > 0)
                    <div class="space-y-3">
                        @foreach($annee_academique->semestres as $semestre)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $semestre->libelle }}</h4>
                                        <p class="text-sm text-gray-500">
                                            Du {{ $semestre->date_debut ? \Carbon\Carbon::parse($semestre->date_debut)->format('d/m/Y') : 'N/A' }}
                                            au {{ $semestre->date_fin ? \Carbon\Carbon::parse($semestre->date_fin)->format('d/m/Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('gestion-semestres.show', $semestre->id) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun semestre</h3>
                        <p class="mt-1 text-sm text-gray-500">Aucun semestre n'est encore associé à cette année académique.</p>
                        <div class="mt-4">
                            <a href="{{ route('gestion-semestres.create') }}"
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                                <i class="fas fa-plus -ml-1 mr-2"></i>
                                Ajouter un semestre
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions et statistiques -->
        <div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Actions rapides</h2>

                <div class="space-y-3">
                    <a href="{{ route('gestion-annees-academiques.edit', ['gestion_annees_academique' => $annee_academique->id]) }}"
                       class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>

                    <button onclick="confirmDelete()"
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Statistiques</h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Nombre de semestres</span>
                        <span class="text-lg font-semibold text-gray-900">
                            {{ $annee_academique->semestres ? $annee_academique->semestres->count() : 0 }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Années-classes associées</span>
                        <span class="text-lg font-semibold text-gray-900">
                            {{ $annee_academique->anneesClasses ? $annee_academique->anneesClasses->count() : 0 }}
                        </span>
                    </div>
                </div>

                <!-- Informations système -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Informations système</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">ID:</span> {{ $annee_academique->id }}
                        </div>
                        <div>
                            <span class="font-medium">Créée le:</span>
                            {{ $annee_academique->created_at ? $annee_academique->created_at->format('d/m/Y à H:i') : 'Non disponible' }}
                        </div>
                        <div>
                            <span class="font-medium">Modifiée le:</span>
                            {{ $annee_academique->updated_at ? $annee_academique->updated_at->format('d/m/Y à H:i') : 'Non disponible' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Confirmer la suppression</h3>
                </div>
            </div>

            <p class="text-gray-500 mb-6">
                Êtes-vous sûr de vouloir supprimer cette année académique ? Cette action supprimera également tous les semestres et années-classes associés. Cette action est irréversible.
            </p>

            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                    Annuler
                </button>
                <form action="{{ route('gestion-annees-academiques.destroy', ['gestion_annees_academique' => $annee_academique->id]) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Modifier l\'Année Académique')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier l'Année Académique</h1>
            <p class="text-gray-600 mt-1">{{ $annee_academique->libelle }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('gestion-annees-academiques.show', $annee_academique->id) }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-eye mr-2"></i>Voir
            </a>
            <a href="{{ route('gestion-annees-academiques.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('gestion-annees-academiques.update', $annee_academique->id) }}" method="POST" id="anneeForm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Libellé -->
                <div class="md:col-span-2">
                    <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                        Libellé de l'année académique <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="libelle"
                           id="libelle"
                           value="{{ old('libelle', $annee_academique->libelle) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required
                           placeholder="Ex: 2024-2025, Année 2024/2025">
                    @error('libelle')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de début -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date_debut"
                           id="date_debut"
                           value="{{ old('date_debut', $annee_academique->date_debut ? \Carbon\Carbon::parse($annee_academique->date_debut)->format('Y-m-d') : '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('date_debut')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date_fin"
                           id="date_fin"
                           value="{{ old('date_fin', $annee_academique->date_fin ? \Carbon\Carbon::parse($annee_academique->date_fin)->format('Y-m-d') : '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('date_fin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Aperçu des impacts -->
            @if($annee_academique->semestres && $annee_academique->semestres->count() > 0)
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Impact des modifications</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Cette année académique contient <strong>{{ $annee_academique->semestres->count() }} semestre(s)</strong>.</p>
                            <p>Les modifications des dates peuvent affecter les semestres associés :</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($annee_academique->semestres as $semestre)
                                    <li>{{ $semestre->libelle }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Informations de modification -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-800 mb-2">Informations de modification</h3>
                <div class="text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium">Créée le:</span> {{ $annee_academique->created_at ? $annee_academique->created_at->format('d/m/Y à H:i') : 'Non disponible' }}</p>
                    <p><span class="font-medium">Dernière modification:</span> {{ $annee_academique->updated_at ? $annee_academique->updated_at->format('d/m/Y à H:i') : 'Non disponible' }}</p>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('gestion-annees-academiques.show', $annee_academique->id) }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>

    <!-- Zone de suppression -->
    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-red-800">Zone de danger</h3>
                <p class="text-red-600 text-sm mt-1">
                    La suppression de cette année académique est irréversible.
                    @if($annee_academique->semestres && $annee_academique->semestres->count() > 0)
                        Elle supprimera également {{ $annee_academique->semestres->count() }} semestre(s) associé(s).
                    @endif
                    @if($annee_academique->anneesClasses && $annee_academique->anneesClasses->count() > 0)
                        Ainsi que {{ $annee_academique->anneesClasses->count() }} année(s)-classe(s) associée(s).
                    @endif
                </p>
            </div>
            <button onclick="confirmDelete()"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>Supprimer
            </button>
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
                Êtes-vous sûr de vouloir supprimer cette année académique ? Cette action supprimera également :
                <ul class="mt-2 list-disc list-inside text-sm">
                    @if($annee_academique->semestres && $annee_academique->semestres->count() > 0)
                        <li>{{ $annee_academique->semestres->count() }} semestre(s)</li>
                    @endif
                    @if($annee_academique->anneesClasses && $annee_academique->anneesClasses->count() > 0)
                        <li>{{ $annee_academique->anneesClasses->count() }} année(s)-classe(s)</li>
                    @endif
                </ul>
                Cette action est irréversible.
            </p>

            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                    Annuler
                </button>
                <form action="{{ route('gestion-annees-academiques.destroy', $annee_academique->id) }}" method="POST" class="inline">
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
document.addEventListener('DOMContentLoaded', function() {
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');

    // Validation des dates
    dateDebutInput.addEventListener('change', function() {
        if (dateFinInput.value && new Date(this.value) >= new Date(dateFinInput.value)) {
            alert('La date de début doit être antérieure à la date de fin.');
            this.focus();
        }
    });

    dateFinInput.addEventListener('change', function() {
        if (dateDebutInput.value && new Date(this.value) <= new Date(dateDebutInput.value)) {
            alert('La date de fin doit être postérieure à la date de début.');
            this.focus();
        }
    });
});

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

@extends('layouts.admin')

@section('title', 'Créer une Année Académique')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Créer une Nouvelle Année Académique</h1>
            <p class="text-gray-600 mt-1">Définir une nouvelle période académique</p>
        </div>
        <a href="{{ route('gestion-annees-academiques.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('gestion-annees-academiques.store') }}" method="POST" id="anneeForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Libellé -->
                <div class="md:col-span-2">
                    <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                        Libellé de l'année académique <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="libelle"
                           id="libelle"
                           value="{{ old('libelle') }}"
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
                           value="{{ old('date_debut') }}"
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
                           value="{{ old('date_fin') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('date_fin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Aide contextuelle -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800 mb-2">Information</h3>
                <ul class="text-blue-700 text-sm space-y-1">
                    <li>• Le libellé doit être unique pour chaque année académique</li>
                    <li>• La date de fin doit être postérieure à la date de début</li>
                    <li>• Une année académique peut contenir plusieurs semestres</li>
                </ul>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('gestion-annees-academiques.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i>Créer l'Année Académique
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');
    const libelleInput = document.getElementById('libelle');

    // Validation des dates
    dateDebutInput.addEventListener('change', function() {
        if (dateFinInput.value && new Date(this.value) >= new Date(dateFinInput.value)) {
            alert('La date de début doit être antérieure à la date de fin.');
            this.value = '';
        }
        updateLibelleFromDates();
    });

    dateFinInput.addEventListener('change', function() {
        if (dateDebutInput.value && new Date(this.value) <= new Date(dateDebutInput.value)) {
            alert('La date de fin doit être postérieure à la date de début.');
            this.value = '';
        }
        updateLibelleFromDates();
    });

    // Suggestion automatique du libellé basé sur les dates
    function updateLibelleFromDates() {
        if (dateDebutInput.value && dateFinInput.value && !libelleInput.value) {
            const debut = new Date(dateDebutInput.value);
            const fin = new Date(dateFinInput.value);
            const anneeDebut = debut.getFullYear();
            const anneeFin = fin.getFullYear();

            if (anneeDebut !== anneeFin) {
                libelleInput.value = `${anneeDebut}-${anneeFin}`;
            } else {
                libelleInput.value = `Année ${anneeDebut}`;
            }
        }
    }
});
</script>
@endsection

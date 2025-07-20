@extends('layouts.admin')

@section('title', 'Créer un Semestre')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Créer un Nouveau Semestre</h1>
            <p class="text-gray-600 mt-1">Ajoutez un nouveau semestre à une année académique</p>
        </div>
        <a href="{{ route('gestion-semestres.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('gestion-semestres.store') }}" method="POST" id="semestreForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Année Académique -->
                <div class="md:col-span-2">
                    <label for="annee_academique_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Année Académique <span class="text-red-500">*</span>
                    </label>
                    <select name="annee_academique_id" id="annee_academique_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Sélectionner une année académique</option>
                        @foreach($annees_academiques as $annee)
                            <option value="{{ $annee->id }}" {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                                {{ $annee->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('annee_academique_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Libellé -->
                <div class="md:col-span-2">
                    <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                        Libellé du semestre <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="libelle"
                           id="libelle"
                           value="{{ old('libelle') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required
                           placeholder="Ex: Semestre 1, Semestre 2">
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

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('gestion-semestres.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i>Créer le Semestre
                </button>
            </div>
        </form>
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
            this.value = '';
        }
    });

    dateFinInput.addEventListener('change', function() {
        if (dateDebutInput.value && new Date(this.value) <= new Date(dateDebutInput.value)) {
            alert('La date de fin doit être postérieure à la date de début.');
            this.value = '';
        }
    });
});
</script>
@endsection

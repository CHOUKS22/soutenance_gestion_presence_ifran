@extends('layouts.admin')

@section('title', 'Modifier le Rôle')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Rôle</h1>
            <p class="text-gray-600 mt-1">{{ $role->nom }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('gestion-roles.show', $role) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-eye mr-2"></i>Voir Détails
            </a>
            <a href="{{ route('gestion-roles.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('gestion-roles.update', $role) }}" method="POST" id="roleForm">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du Rôle <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" id="nom"
                           value="{{ old('nom') ?? $role->nom }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: Admin, Professeur, Étudiant..."
                           required>
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="suggestions" class="mt-2"></div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Description détaillée du rôle et de ses permissions (optionnel)">{{ old('description') ?? $role->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <p><strong>Rôle créé le :</strong> {{ $role->created_at->format('d/m/Y à H:i') }}</p>
                    <p><strong>Dernière modification :</strong> {{ $role->updated_at->format('d/m/Y à H:i') }}</p>
                    @if($role->users_count ?? 0 > 0)
                        <p class="mt-2"><strong>Utilisateurs assignés :</strong> {{ $role->users_count }}</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('gestion-roles.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i>Mettre à Jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nomInput = document.getElementById('nom');
    const suggestionsDiv = document.getElementById('suggestions');

    const commonRoles = [
        'Admin',
        'Administrateur',
        'Professeur',
        'Enseignant',
        'Étudiant',
        'Coordinateur',
        'Directeur',
        'Secrétaire',
        'Parent',
        'Surveillant'
    ];

    nomInput.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        const suggestions = commonRoles.filter(role =>
            role.toLowerCase().includes(value) && value.length > 0
        );

        if (suggestions.length > 0) {
            suggestionsDiv.innerHTML = '<div class="text-sm text-gray-600 mb-2">Suggestions :</div>' +
                suggestions.map(suggestion =>
                    `<span class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded mr-2 mb-2 cursor-pointer suggestion-item">
                        ${suggestion}
                    </span>`
                ).join('');

            // Ajouter les événements click sur les suggestions
            document.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    nomInput.value = this.textContent.trim();
                    suggestionsDiv.innerHTML = '';
                });
            });
        } else {
            suggestionsDiv.innerHTML = '';
        }
    });

    const form = document.getElementById('roleForm');
    form.addEventListener('submit', function(e) {
        const nom = nomInput.value.trim();
        if (!nom) {
            e.preventDefault();
            alert('Le nom du rôle est obligatoire.');
            return false;
        }
    });
});
</script>
@endsection

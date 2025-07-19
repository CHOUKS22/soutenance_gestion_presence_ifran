@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Parents</h1>
                <div class="flex space-x-3">
                    <button id="addParentBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Ajouter Infos Parent</span>
                    </button>
                    <button id="assignEtudiantBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-link"></i>
                        <span>Assigner Étudiant</span>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Formulaire d'ajout -->
            <div id="addParentForm" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Ajouter les informations d'un Parent</h2>

                @if($usersParents->count() > 0)
                    <form method="POST" action="{{ route('gestion-parents.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Sélection de l'utilisateur parent -->
                            <div class="md:col-span-2">
                                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner le parent</label>
                                <select id="user_id" name="user_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">-- Choisir un parent --</option>
                                    @foreach($usersParents as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->nom }} {{ $user->prenom }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('telephone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type de relation -->
                            <div>
                                <label for="type_relation" class="block text-sm font-medium text-gray-700 mb-1">Type de relation</label>
                                <select id="type_relation" name="type_relation"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">-- Choisir le type de relation --</option>
                                    <option value="Pére" {{ old('type_relation') == 'Pére' ? 'selected' : '' }}>Père</option>
                                    <option value="Mére" {{ old('type_relation') == 'Mére' ? 'selected' : '' }}>Mère</option>
                                    <option value="garant" {{ old('type_relation') == 'garant' ? 'selected' : '' }}>Garant</option>
                                    <option value="Tuteur" {{ old('type_relation') == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                                    <option value="Autre" {{ old('type_relation') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('type_relation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" id="cancelAddBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                Ajouter les informations
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                        <p class="text-gray-600 mb-2">Aucun utilisateur avec le rôle "Parent" disponible</p>
                        <p class="text-sm text-gray-500">Vous devez d'abord créer des utilisateurs avec le rôle "Parent" dans la section Utilisateurs</p>
                        <a href="{{ route('gestion-parents.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Gérer les utilisateurs
                        </a>
                    </div>
                @endif
            </div>

            <!-- Formulaire d'assignation d'étudiants -->
            <div id="assignEtudiantForm" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Assigner un Étudiant à un Parent</h2>

                @if($parents->count() > 0 && $etudiants->count() > 0)
                    <form method="POST" action="{{ route('gestion-parents.assign-etudiant') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Sélection du parent -->
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner le parent</label>
                                <select id="parent_id" name="parent_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                    <option value="">-- Choisir un parent --</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->user->nom }} {{ $parent->user->prenom }} ({{ $parent->type_relation }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sélection de l'étudiant -->
                            <div>
                                <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner l'étudiant</label>
                                <select id="etudiant_id" name="etudiant_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                    <option value="">-- Choisir un étudiant --</option>
                                    @foreach($etudiants as $etudiant)
                                        <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                                            {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} ({{ $etudiant->user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('etudiant_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <button type="button" id="cancelAssignBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                                Assigner l'étudiant
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                        <p class="text-gray-600 mb-2">Aucun parent ou étudiant disponible pour l'assignation</p>
                        <p class="text-sm text-gray-500">Vous devez d'abord avoir des parents et des étudiants enregistrés</p>
                    </div>
                @endif
            </div>

            <!-- Liste des parents -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">Liste des Parents</h2>

                    @if($parents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom Complet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de relation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiants assignés</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($parents as $parent)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($parent->user->photo)
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                             src="{{ asset('storage/' . $parent->user->photo) }}"
                                                             alt="{{ $parent->user->nom }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <i class="fas fa-user text-gray-500"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $parent->user->nom }} {{ $parent->user->prenom }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $parent->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $parent->telephone ?: 'Non défini' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $parent->type_relation }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-1">
                                                    @forelse($parent->etudiants as $etudiant)
                                                        <div class="flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                                            <span>{{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}</span>
                                                            <form method="POST" action="{{ route('gestion-parents.unassign-etudiant') }}" class="inline ml-1">
                                                                @csrf
                                                                <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                                                                <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
                                                                <button type="submit" class="text-red-600 hover:text-red-800 ml-1"
                                                                        onclick="return confirm('Êtes-vous sûr de vouloir désassigner cet étudiant ?')"
                                                                        title="Désassigner">
                                                                    <i class="fas fa-times text-xs"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @empty
                                                        <span class="text-gray-500 text-sm">Aucun étudiant assigné</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('gestion-parents.show', $parent) }}"
                                                       class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-md transition-colors">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('gestion-parents.edit', $parent) }}"
                                                       class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded-md transition-colors">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('gestion-parents.destroy', $parent) }}"
                                                          class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les informations de ce parent ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-colors">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $parents->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Aucun parent trouvé</p>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('addParentBtn');
    const addForm = document.getElementById('addParentForm');
    const cancelBtn = document.getElementById('cancelAddBtn');

    const assignBtn = document.getElementById('assignEtudiantBtn');
    const assignForm = document.getElementById('assignEtudiantForm');
    const cancelAssignBtn = document.getElementById('cancelAssignBtn');

    // Gestion du formulaire d'ajout de parent
    addBtn.addEventListener('click', function() {
        // Fermer le formulaire d'assignation s'il est ouvert
        assignForm.classList.add('hidden');
        assignBtn.classList.remove('hidden');

        // Ouvrir le formulaire d'ajout
        addForm.classList.remove('hidden');
        addBtn.classList.add('hidden');
    });

    cancelBtn.addEventListener('click', function() {
        addForm.classList.add('hidden');
        addBtn.classList.remove('hidden');
        // Réinitialiser le formulaire
        const form = addForm.querySelector('form');
        if (form) {
            form.reset();
        }
    });

    // Gestion du formulaire d'assignation
    assignBtn.addEventListener('click', function() {
        // Fermer le formulaire d'ajout s'il est ouvert
        addForm.classList.add('hidden');
        addBtn.classList.remove('hidden');

        // Ouvrir le formulaire d'assignation
        assignForm.classList.remove('hidden');
        assignBtn.classList.add('hidden');
    });

    cancelAssignBtn.addEventListener('click', function() {
        assignForm.classList.add('hidden');
        assignBtn.classList.remove('hidden');
        // Réinitialiser le formulaire
        const form = assignForm.querySelector('form');
        if (form) {
            form.reset();
        }
    });

    // Fermer les messages d'alerte
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('svg');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                alert.remove();
            });
        }
    });
});
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="space-y-6">
    <!-- En-tête de la page -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
            <p class="text-gray-600">Créer et gérer les utilisateurs du système</p>
        </div>
        <div class="flex items-center space-x-3">
            <button id="toggleFormBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Ajouter un utilisateur
            </button>
        </div>
    </div>

    <!-- Formulaire de création (masqué par défaut) -->
    <div id="createUserForm" class="bg-white rounded-lg shadow-sm border hidden">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Créer un nouvel utilisateur</h2>
        </div>
        <form method="POST" action="{{ route('users.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('prenom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rôle -->
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">Rôle *</label>
                    <select id="role_id" name="role_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="">Sélectionner un rôle</option>
                        @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->nom) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-gray-500 text-xs mt-1">Formats acceptés : JPG, PNG, GIF. Taille max : 2MB</p>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" id="cancelBtn" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>

    <!-- Filtres et liste des utilisateurs -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Liste des utilisateurs</h2>
                <div class="flex items-center space-x-4">
                    <select id="roleFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les rôles</option>
                        @foreach($roles ?? [] as $role)
                            <option value="{{ strtolower($role->nom) }}">{{ ucfirst($role->nom) }}</option>
                        @endforeach
                    </select>
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Rechercher un utilisateur..."
                               class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="space-y-4" id="usersList">
                @if(isset($users) && $users->count() > 0)
                    @foreach($users as $user)
                        <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition-colors user-item"
                             data-role="{{ strtolower($user->role->nom ?? '') }}"
                             data-name="{{ strtolower($user->nom . ' ' . $user->prenom) }}"
                             data-email="{{ strtolower($user->email) }}">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4 overflow-hidden">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de {{ $user->nom }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-blue-600 font-semibold">
                                            {{ substr($user->nom, 0, 1) }}{{ substr($user->prenom, 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $user->nom }} {{ $user->prenom }}</p>
                                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                                    <p class="text-gray-500 text-xs">Créé le {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ ($user->role->nom ?? '') === 'admin' ? 'bg-red-100 text-red-600' : '' }}
                                    {{ ($user->role->nom ?? '') === 'etudiant' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ ($user->role->nom ?? '') === 'professeur' ? 'bg-green-100 text-green-600' : '' }}
                                    {{ ($user->role->nom ?? '') === 'coordinateur' ? 'bg-purple-100 text-purple-600' : '' }}
                                    {{ ($user->role->nom ?? '') === 'parent' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ !$user->role ? 'bg-gray-100 text-gray-600' : '' }}
                                ">
                                    {{ ucfirst($user->role->nom ?? 'Aucun rôle') }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('users.show', $user) }}" class="p-2 text-gray-500 hover:text-blue-600 transition-colors" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 text-gray-500 hover:text-green-600 transition-colors" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $user->nom }} {{ $user->prenom }} ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 transition-colors" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Aucun utilisateur trouvé</p>
                        <p class="text-gray-400 text-sm mt-2">Commencez par créer votre premier utilisateur</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if(isset($users) && $users->hasPages())
                <div class="flex justify-center mt-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Gestion du formulaire
const toggleFormBtn = document.getElementById('toggleFormBtn');
const createUserForm = document.getElementById('createUserForm');
const cancelBtn = document.getElementById('cancelBtn');

if (toggleFormBtn && createUserForm && cancelBtn) {
    // Afficher/masquer le formulaire
    toggleFormBtn.addEventListener('click', function() {
        createUserForm.classList.toggle('hidden');
        if (!createUserForm.classList.contains('hidden')) {
            toggleFormBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Annuler';
            document.getElementById('nom').focus();
        } else {
            toggleFormBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Ajouter un utilisateur';
        }
    });

    cancelBtn.addEventListener('click', function() {
        createUserForm.classList.add('hidden');
        toggleFormBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Ajouter un utilisateur';
        document.querySelector('form').reset();
    });
}

// Filtrage par rôle
const roleFilter = document.getElementById('roleFilter');
if (roleFilter) {
    roleFilter.addEventListener('change', function() {
        const selectedRole = this.value.toLowerCase();
        const userItems = document.querySelectorAll('.user-item');

        userItems.forEach(item => {
            const itemRole = item.getAttribute('data-role');
            if (selectedRole === '' || itemRole === selectedRole) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// Recherche en temps réel
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const userItems = document.querySelectorAll('.user-item');

        userItems.forEach(item => {
            const name = item.getAttribute('data-name');
            const email = item.getAttribute('data-email');

            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// Prévisualisation de l'image
const photoInput = document.getElementById('photo');
if (photoInput) {
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Créer ou mettre à jour l'élément d'aperçu
                let preview = document.getElementById('photoPreview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'photoPreview';
                    preview.className = 'mt-3';
                    photoInput.parentNode.appendChild(preview);
                }

                preview.innerHTML = `
                    <div class="relative inline-block">
                        <img src="${e.target.result}" alt="Aperçu" class="w-20 h-20 object-cover rounded-full border-2 border-gray-300">
                        <button type="button" onclick="removePhotoPreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });
}

// Fonction pour supprimer l'aperçu
function removePhotoPreview() {
    document.getElementById('photo').value = '';
    const preview = document.getElementById('photoPreview');
    if (preview) {
        preview.remove();
    }
}

// Afficher le formulaire si il y a des erreurs de validation
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        if (createUserForm) {
            createUserForm.classList.remove('hidden');
            toggleFormBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Annuler';
        }
    });
@endif
</script>
@endsection

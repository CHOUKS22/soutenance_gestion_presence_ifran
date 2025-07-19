@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Modifier l'utilisateur</h1>
            <p class="text-gray-600">Modifier les informations de {{ $user->nom }} {{ $user->prenom }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('users.show', $user) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-eye mr-2"></i>Voir détails
            </a>
            <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6">
            <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Photo actuelle -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Photo actuelle</label>
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center overflow-hidden">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo actuelle" class="w-full h-full object-cover">
                            @else
                                <span class="text-blue-600 font-semibold">
                                    {{ substr($user->nom, 0, 1) }}{{ substr($user->prenom, 0, 1) }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">
                                @if($user->photo)
                                    <i class="fas fa-check-circle text-green-600 mr-1"></i>
                                    Photo actuelle disponible
                                @else
                                    <i class="fas fa-times-circle text-red-600 mr-1"></i>
                                    Aucune photo actuellement
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>Nom *
                        </label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('nom')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>Prénom *
                        </label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('prenom')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i>Email *
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Rôle -->
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-1"></i>Rôle *
                        </label>
                        <select id="role_id" name="role_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->nom) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nouvelle photo -->
                    <div class="md:col-span-2">
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-camera mr-1"></i>Nouvelle photo de profil
                        </label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-gray-500 text-xs mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Formats acceptés : JPG, PNG, GIF. Taille max : 2MB. Laissez vide pour conserver la photo actuelle.
                        </p>
                        @error('photo')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nouveau mot de passe (optionnel) -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1"></i>Nouveau mot de passe
                        </label>
                        <input type="password" id="password" name="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-gray-500 text-xs mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Laissez vide pour conserver le mot de passe actuel
                        </p>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1"></i>Confirmer le mot de passe
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-gray-500 text-xs mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Requis seulement si vous changez le mot de passe
                        </p>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-1"></i>Informations de compte
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong>ID utilisateur:</strong> #{{ $user->id }}
                        </div>
                        <div>
                            <strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div>
                            <strong>Dernière modification:</strong> {{ $user->updated_at->format('d/m/Y à H:i') }}
                        </div>

                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-between items-center mt-6 pt-6 border-t">
                    <div class="flex space-x-3">
                        <a href="{{ route('users.show', $user) }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </a>
                        <a href="{{ route('users.index') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-list mr-2"></i>Retour à la liste
                        </a>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
                    preview.className = 'mt-3 p-3 bg-green-50 rounded-lg border border-green-200';
                    photoInput.parentNode.appendChild(preview);
                }

                preview.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <img src="${e.target.result}" alt="Aperçu" class="w-16 h-16 object-cover rounded-full border-2 border-green-300">
                            <button type="button" onclick="removePhotoPreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Nouvelle photo sélectionnée
                            </p>
                            <p class="text-xs text-green-600">Cette photo remplacera l'ancienne</p>
                        </div>
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

// Validation du mot de passe
const passwordInput = document.getElementById('password');
const passwordConfirmInput = document.getElementById('password_confirmation');

if (passwordInput && passwordConfirmInput) {
    passwordInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            passwordConfirmInput.setAttribute('required', 'required');
        } else {
            passwordConfirmInput.removeAttribute('required');
        }
    });
}
</script>
@endsection

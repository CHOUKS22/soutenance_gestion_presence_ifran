@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Modifier l'Administrateur</h1>
            <a href="{{ route('gestion-admins.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>

        <!-- Formulaire de modification -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('gestion-admins.update', $admin) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Informations personnelles -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            Informations personnelles
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                <input type="text"
                                       id="nom"
                                       name="nom"
                                       value="{{ old('nom', $admin->user->nom) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nom') border-red-500 @enderror">
                                @error('nom')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                <input type="text"
                                       id="prenom"
                                       name="prenom"
                                       value="{{ old('prenom', $admin->user->prenom) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('prenom') border-red-500 @enderror">
                                @error('prenom')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $admin->user->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type d'administrateur -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Type d'administrateur</label>
                                <select id="role"
                                        name="role"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror">
                                    <option value="">Sélectionner un type</option>
                                    <option value="super_admin"
                                            {{ old('role', $admin->role) === 'super_admin' ? 'selected' : '' }}>
                                        Super Administrateur
                                    </option>
                                    <option value="admin"
                                            {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>
                                        Administrateur
                                    </option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Photo -->
                            {{-- <div class="md:col-span-2">
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo (optionnel)</label>
                                <div class="flex items-center space-x-4">
                                    @if($admin->user->photo)
                                        <img src="{{ asset('storage/' . $admin->user->photo) }}"
                                             alt="Photo actuelle"
                                             class="w-16 h-16 rounded-full object-cover">
                                        <div class="text-sm text-gray-500">Photo actuelle</div>
                                    @endif
                                    <input type="file"
                                           id="photo"
                                           name="photo"
                                           accept="image/*"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('photo') border-red-500 @enderror">
                                </div>
                                @error('photo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-lock mr-2"></i>
                            Mot de passe (laisser vide pour ne pas changer)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nouveau mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmer le mot de passe -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('gestion-admins.index') }}"
                           class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition-colors flex items-center space-x-2">
                            <i class="fas fa-times"></i>
                            <span>Annuler</span>
                        </a>
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Mettre à jour</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

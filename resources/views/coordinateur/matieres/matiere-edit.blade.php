@exten        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('gestion-matieres.show', $matiere->id) }}"
                   class="text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Modifier la Matière</h1>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('gestion-matieres.update', $matiere->id) }}" class="space-y-6">dmin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('gestion-matieres.show', $matiere) }}"
                   class="text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Modifier la Matière</h1>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('gestion-matieres.update', $matiere) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Section: Informations principales -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                        Informations Principales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom de la matière -->
                        <div class="md:col-span-2">
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom de la Matière <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" required
                                   value="{{ old('nom', $matiere->nom) }}"
                                   placeholder="Ex: Mathématiques, Français, Histoire..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror">
                            @error('nom')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code matière (si disponible) -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                Code Matière
                            </label>
                            <input type="text" name="code" id="code"
                                   value="{{ old('code', $matiere->code ?? '') }}"
                                   placeholder="Ex: MATH101, FR201..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror">
                            @error('code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Code unique pour identifier la matière</p>
                        </div>

                        <!-- Coefficient (si disponible) -->
                        <div>
                            <label for="coefficient" class="block text-sm font-medium text-gray-700 mb-2">
                                Coefficient
                            </label>
                            <input type="number" name="coefficient" id="coefficient" min="1" max="10" step="0.5"
                                   value="{{ old('coefficient', $matiere->coefficient ?? '') }}"
                                   placeholder="Ex: 1, 2, 3..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('coefficient') border-red-500 @enderror">
                            @error('coefficient')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Coefficient pour le calcul des moyennes</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Description -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-green-600"></i>
                        Description
                    </h2>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description de la Matière <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" required
                                  placeholder="Décrivez les objectifs, le contenu et les compétences développées dans cette matière..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $matiere->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">
                            Une description détaillée aide les étudiants et professeurs à comprendre les enjeux de la matière
                        </p>
                    </div>
                </div>

                <!-- Section: Paramètres avancés -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-cogs mr-3 text-purple-600"></i>
                        Paramètres Avancés
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Durée moyenne des séances -->
                        <div>
                            <label for="duree_moyenne" class="block text-sm font-medium text-gray-700 mb-2">
                                Durée Moyenne des Séances (en minutes)
                            </label>
                            <input type="number" name="duree_moyenne" id="duree_moyenne" min="30" max="480" step="15"
                                   value="{{ old('duree_moyenne', $matiere->duree_moyenne ?? 90) }}"
                                   placeholder="90"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duree_moyenne') border-red-500 @enderror">
                            @error('duree_moyenne')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Durée standard pour planifier les séances</p>
                        </div>

                        <!-- Couleur de la matière -->
                        <div>
                            <label for="couleur" class="block text-sm font-medium text-gray-700 mb-2">
                                Couleur de la Matière
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="color" name="couleur" id="couleur"
                                       value="{{ old('couleur', $matiere->couleur ?? '#3B82F6') }}"
                                       class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer @error('couleur') border-red-500 @enderror">
                                <div class="flex-1">
                                    <input type="text"
                                           value="{{ old('couleur', $matiere->couleur ?? '#3B82F6') }}"
                                           readonly
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                                </div>
                            </div>
                            @error('couleur')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Couleur utilisée dans les calendriers et graphiques</p>
                        </div>

                        <!-- Statut de la matière -->
                        <div>
                            <label for="active" class="block text-sm font-medium text-gray-700 mb-2">
                                Statut de la Matière
                            </label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="active" value="1"
                                           {{ (old('active', $matiere->active ?? 1) == 1) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Active</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="active" value="0"
                                           {{ (old('active', $matiere->active ?? 1) == 0) ? 'checked' : '' }}
                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                </label>
                            </div>
                            @error('active')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Les matières inactives ne peuvent pas être utilisées pour de nouvelles séances</p>
                        </div>

                        <!-- Matière obligatoire -->
                        <div>
                            <label for="obligatoire" class="block text-sm font-medium text-gray-700 mb-2">
                                Type de Matière
                            </label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="obligatoire" value="1"
                                           {{ (old('obligatoire', $matiere->obligatoire ?? 1) == 1) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Obligatoire</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="obligatoire" value="0"
                                           {{ (old('obligatoire', $matiere->obligatoire ?? 1) == 0) ? 'checked' : '' }}
                                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Optionnelle</span>
                                </label>
                            </div>
                            @error('obligatoire')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('gestion-matieres.show', $matiere->id) }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Mettre à Jour</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Synchroniser la couleur avec l'input text
    document.getElementById('couleur').addEventListener('input', function() {
        document.querySelector('input[readonly]').value = this.value;
    });

    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        const nom = document.getElementById('nom').value.trim();
        const description = document.getElementById('description').value.trim();

        if (!nom || !description) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }

        if (nom.length < 2) {
            e.preventDefault();
            alert('Le nom de la matière doit contenir au moins 2 caractères.');
            return false;
        }

        if (description.length < 10) {
            e.preventDefault();
            alert('La description doit contenir au moins 10 caractères.');
            return false;
        }
    });

    // Formatage automatique du code matière en majuscules
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Détails de la Classe')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Détails de la Classe</h1>
            <p class="text-gray-600 mt-1">{{ $classe->nom }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('gestion-classes.edit', $classe) }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('gestion-classes.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Informations Générales</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom de la classe</label>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-lg font-semibold text-blue-600">{{ $classe->nom }}</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'étudiants</label>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-lg font-semibold text-green-600">0 étudiants</div>
                            <div class="text-sm text-gray-500">Aucun étudiant inscrit pour le moment</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Métadonnées</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de création</label>
                            <div class="text-sm text-gray-900">{{ $classe->created_at->format('d/m/Y à H:i') }}</div>
                            <div class="text-sm text-gray-500">{{ $classe->created_at->diffForHumans() }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dernière modification</label>
                            <div class="text-sm text-gray-900">{{ $classe->updated_at->format('d/m/Y à H:i') }}</div>
                            <div class="text-sm text-gray-500">{{ $classe->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec actions et statistiques -->
        <div class="space-y-6">
            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Actions rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('gestion-classes.edit', $classe) }}"
                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Modifier la classe
                    </a>
                    <button onclick="openDeleteModal()"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i>Supprimer la classe
                    </button>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Statistiques</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Étudiants inscrits</span>
                        <span class="font-semibold text-gray-900">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Années académiques</span>
                        <span class="font-semibold text-gray-900">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Séances programmées</span>
                        <span class="font-semibold text-gray-900">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des étudiants (vide pour le moment) -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Étudiants de la classe</h2>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i>Ajouter un étudiant
                </button>
            </div>

            <div class="text-center py-12">
                <div class="p-4 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user-graduate text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun étudiant inscrit</h3>
                <p class="text-gray-500 mb-6">Cette classe n'a pas encore d'étudiants inscrits.</p>
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Inscrire des étudiants</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Confirmer la suppression</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Êtes-vous sûr de vouloir supprimer la classe "{{ $classe->nom }}" ? Cette action est irréversible.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form method="POST" action="{{ route('gestion-classes.destroy', $classe) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 mr-2">
                        Supprimer
                    </button>
                </form>
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }a
});
</script>
@endsection

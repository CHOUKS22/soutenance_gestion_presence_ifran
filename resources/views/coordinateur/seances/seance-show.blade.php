@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('gestion-seances.index') }}"
                   class="text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Détails de la Séance</h1>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('gestion-seances.edit', $seance) }}"
                   class="bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition-colors flex items-center space-x-2 shadow-lg">
                    <i class="fas fa-edit"></i>
                    <span>Modifier</span>
                </a>
                <form method="POST" action="{{ route('gestion-seances.destroy', $seance) }}"
                      class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors flex items-center space-x-2 shadow-lg">
                        <i class="fas fa-trash"></i>
                        <span>Supprimer</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Informations principales -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Informations générales -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                    Informations Générales
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-lg font-medium text-gray-900">{{ $seance->classe->nom ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Matière</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-lg font-medium text-gray-900">{{ $seance->matiere->nom ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type de Séance</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                                {{ $seance->type_seance->nom ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                {{ $seance->statut_seance->nom ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de Début</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-lg font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($seance->date_debut)->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de Fin</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-lg font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($seance->date_fin)->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Semestre</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-lg font-medium text-gray-900">{{ $seance->semestre->libelle ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durée</label>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="text-lg font-medium text-gray-900">
                                @php
                                    $debut = \Carbon\Carbon::parse($seance->date_debut);
                                    $fin = \Carbon\Carbon::parse($seance->date_fin);
                                    $duree = $debut->diffInMinutes($fin);
                                    $heures = floor($duree / 60);
                                    $minutes = $duree % 60;
                                @endphp
                                {{ $heures }}h {{ $minutes }}min
                            </span>
                        </div>
                    </div>
                </div>

                @if($seance->description)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-900">{{ $seance->description }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Informations du professeur -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-chalkboard-teacher mr-3 text-green-600"></i>
                    Professeur
                </h2>

                @if($seance->professeur)
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden shadow-lg">
                            @if($seance->professeur->user->photo ?? null)
                                <img src="{{ asset('storage/' . $seance->professeur->user->photo) }}"
                                     alt="{{ $seance->professeur->user->nom }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500 text-2xl"></i>
                                </div>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            {{ $seance->professeur->user->nom ?? 'N/A' }} {{ $seance->professeur->user->prenom ?? '' }}
                        </h3>

                        <p class="text-gray-600 mb-4">{{ $seance->professeur->user->email ?? 'N/A' }}</p>

                        @if($seance->professeur->user->telephone ?? null)
                            <div class="flex items-center justify-center text-gray-600 mb-2">
                                <i class="fas fa-phone mr-2"></i>
                                <span>{{ $seance->professeur->user->telephone }}</span>
                            </div>
                        @endif

                        @if($seance->professeur->filliere ?? null)
                            <div class="mt-4">
                                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                    {{ $seance->professeur->filliere->nom ?? 'N/A' }}
                                </span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        <i class="fas fa-user-slash text-4xl mb-4"></i>
                        <p>Aucun professeur assigné</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informations d'audit -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-history mr-3 text-purple-600"></i>
                Informations d'Audit
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de Création</label>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-900">{{ $seance->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dernière Modification</label>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-900">{{ $seance->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

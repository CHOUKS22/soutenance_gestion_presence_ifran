@extends('layouts.coordinateur')

@section('title', 'Dashboard Coordinateur')
@section('subtitle', 'Vue d\'ensemble de vos classes et activités')

@section('content')
<div class="space-y-6">
    <!-- Accès rapides -->
    {{-- <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Gestion des Cours</h2>
                <p class="text-blue-100">Créez et gérez vos séances et matières</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('gestion-seances.create') }}"
                   class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvelle Séance
                </a>
                <a href="{{ route('matieres.create') }}"
                   class="bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors duration-200 flex items-center">
                    <i class="fas fa-book mr-2"></i>
                    Nouvelle Matière
                </a>
            </div>
        </div>
    </div> --}}

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Mes Matières -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Matières</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalMatieres }}</p>
                </div>
            </div>
        </div>

        <!-- Séances Totales -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Séances</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalSeances }}</p>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Classes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalClasses }}</p>
                </div>
            </div>
        </div>

        <!-- Taux de Présence -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Taux de Présence</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $tauxPresence }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille principale -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Séances d'aujourd'hui -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Séances d'Aujourd'hui</h3>
                        <p class="text-sm text-gray-600">Planning de vos séances</p>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $seancesAujourdhui->count() }} séance(s)
                    </span>
                </div>
            </div>
            <div class="p-6">
                @if($seancesAujourdhui->count() > 0)
                    <div class="space-y-3">
                        @foreach($seancesAujourdhui->take(3) as $seance)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $seance->matiere->nom ?? 'Matière inconnue' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $seance->date_debut ? \Carbon\Carbon::parse($seance->date_debut)->format('H:i') : '00:00' }} -
                                    {{ $seance->date_fin ? \Carbon\Carbon::parse($seance->date_fin)->format('H:i') : '00:00' }} |
                                    {{ $seance->classe->nom ?? 'Classe inconnue' }}
                                </p>
                            </div>
                            <a href="{{ route('gestion-seances.show', $seance->id) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @if($seancesAujourdhui->count() > 3)
                    <div class="mt-4 text-center">
                        <a href="{{ route('seances.aujourdhui') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir toutes les séances d'aujourd'hui ({{ $seancesAujourdhui->count() }})
                        </a>
                    </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-alt text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Aucune séance programmée aujourd'hui</p>
                        <a href="{{ route('gestion-seances.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 text-sm">
                            Créer une séance
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Mes Matières -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Matières Récentes</h3>
                        <p class="text-sm text-gray-600">Matières récemment créées</p>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $totalMatieres }} total
                    </span>
                </div>
            </div>
            <div class="p-6">
                @if($matieresRecentes->count() > 0)
                    <div class="space-y-3">
                        @foreach($matieresRecentes->take(3) as $matiere)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $matiere->nom }}</p>
                                <p class="text-xs text-gray-500">
                                    Créée le {{ $matiere->created_at ? $matiere->created_at->format('d/m/Y') : 'Date inconnue' }}
                                </p>
                            </div>
                            <a href="{{ route('matieres.show', $matiere->id) }}" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('matieres.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            Voir toutes les matières
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Aucune matière créée</p>
                        <a href="{{ route('matieres.create') }}" class="mt-2 inline-block text-green-600 hover:text-green-800 text-sm">
                            Créer une matière
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Deuxième ligne -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Présences Récentes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Présences Récentes</h3>
                <p class="text-sm text-gray-600">Dernières prises de présence</p>
            </div>
            <div class="p-6">
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Aucune présence enregistrée</p>
                </div>
            </div>
        </div>

        <!-- Prochaines Séances -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Prochaines Séances</h3>
                        <p class="text-sm text-gray-600">Séances à venir (7 prochains jours)</p>
                    </div>
                    <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $prochainesSeances->count() }} séance(s)
                    </span>
                </div>
            </div>
            <div class="p-6">
                @if($prochainesSeances->count() > 0)
                    <div class="space-y-3">
                        @foreach($prochainesSeances as $seance)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar text-orange-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $seance->matiere->nom ?? 'Matière inconnue' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $seance->date_debut ? \Carbon\Carbon::parse($seance->date_debut)->format('d/m/Y') : 'Date inconnue' }} |
                                    {{ $seance->classe->nom ?? 'Classe inconnue' }}
                                </p>
                            </div>
                            <a href="{{ route('gestion-seances.show', $seance->id) }}" class="text-orange-600 hover:text-orange-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clock text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Aucune séance programmée</p>
                        <a href="{{ route('gestion-seances.create') }}" class="mt-2 inline-block text-orange-600 hover:text-orange-800 text-sm">
                            Planifier une séance
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions Rapides -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Actions Rapides</h3>
                <p class="text-sm text-gray-600">Raccourcis fréquents</p>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('gestion-seances.create') }}" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Créer une Séance
                </a>
                <a href="{{ route('matieres.create') }}" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-book mr-2"></i>
                    Ajouter une Matière
                </a>
                <a href="{{ route('gestion-seances.index') }}" class="w-full flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors duration-200">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Gérer les Séances
                </a>
                <a href="{{ route('matieres.index') }}" class="w-full flex items-center justify-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                    <i class="fas fa-list mr-2"></i>
                    Gérer les Matières
                </a>
            </div>
        </div>
    </div>

    <!-- Section de gestion rapide -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Gestion Rapide</h3>
            <p class="text-sm text-gray-600">Accès rapide aux fonctionnalités principales</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Créer une séance -->
                <a href="{{ route('gestion-seances.create') }}"
                   class="p-4 border-2 border-dashed border-blue-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors group">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200">
                            <i class="fas fa-plus text-blue-600 text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">Créer une Séance</h4>
                        <p class="text-xs text-gray-500 mt-1">Planifier une nouvelle séance de cours</p>
                    </div>
                </a>

                <!-- Ajouter une matière -->
                <a href="{{ route('matieres.create') }}"
                   class="p-4 border-2 border-dashed border-green-300 rounded-lg hover:border-green-400 hover:bg-green-50 transition-colors group">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200">
                            <i class="fas fa-book text-green-600 text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">Ajouter Matière</h4>
                        <p class="text-xs text-gray-500 mt-1">Créer une nouvelle matière</p>
                    </div>
                </a>

                <!-- Voir les séances -->
                <a href="{{ route('gestion-seances.index') }}"
                   class="p-4 border-2 border-dashed border-purple-300 rounded-lg hover:border-purple-400 hover:bg-purple-50 transition-colors group">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-200">
                            <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">Gérer Séances</h4>
                        <p class="text-xs text-gray-500 mt-1">Voir et modifier les séances</p>
                    </div>
                </a>

                <!-- Voir les matières -->
                <a href="{{ route('matieres.index') }}"
                   class="p-4 border-2 border-dashed border-yellow-300 rounded-lg hover:border-yellow-400 hover:bg-yellow-50 transition-colors group">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-yellow-200">
                            <i class="fas fa-list text-yellow-600 text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">Gérer Matières</h4>
                        <p class="text-xs text-gray-500 mt-1">Voir et modifier les matières</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

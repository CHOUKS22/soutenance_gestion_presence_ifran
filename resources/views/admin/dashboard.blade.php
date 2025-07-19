@extends('layouts.admin')

@section('title', 'Dashboard Administrateur')

@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
        <p class="text-gray-600">Bienvenue sur votre tableau de bord administrateur</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Étudiants -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Étudiants</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalEtudiants ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Professeurs -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Professeurs</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProfesseurs ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Coordinateurs -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-user-tie text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Coordinateurs</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalCoordinateurs ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Parents -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-user-friends text-yellow-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Parents</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalParents ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Gestion des utilisateurs -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Utilisateurs</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Gérer tous les utilisateurs du système</p>
            <a href="{{ route('users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Gérer les utilisateurs
            </a>
        </div>

        <!-- Gestion des séances -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Séances</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Planifier et gérer les séances</p>
            <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Gérer les séances
            </a>
        </div>

        <!-- Rapports -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Rapports</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Consulter les rapports et statistiques</p>
            <a href="#" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Voir les rapports
            </a>
        </div>
    </div>

</div>
@endsection

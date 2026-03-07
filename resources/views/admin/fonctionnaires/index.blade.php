<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Fonctionnaires') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Add Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.fonctionnaires.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold">
                            + Ajouter un Fonctionnaire
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-600 uppercase">CIN</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-600 uppercase">Nom Complet</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-600 uppercase">Poste</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-600 uppercase">Contact</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-600 uppercase">Statut</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fonctionnaires as $fonctionnaire)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b border-gray-200">{{ $fonctionnaire->cin }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200">{{ $fonctionnaire->nom_complet }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200">{{ $fonctionnaire->poste }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200">{{ $fonctionnaire->contact }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $fonctionnaire->actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $fonctionnaire->actif ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.fonctionnaires.edit', $fonctionnaire) }}" class="text-blue-600 hover:text-blue-900">
                                                Modifier
                                            </a>
                                            <a href="{{ route('fonctionnaires.historique', $fonctionnaire) }}" class="text-green-600 hover:text-green-900">
                                                Historique
                                            </a>
                                            <form action="{{ route('admin.fonctionnaires.destroy', $fonctionnaire) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fonctionnaire?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Aucun fonctionnaire enregistré
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
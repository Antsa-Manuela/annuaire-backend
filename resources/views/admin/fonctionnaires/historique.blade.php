<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique - Annuaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="font-semibold text-xl text-gray-800">Annuaire Administratif</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    <a href="{{ route('admin.fonctionnaires.index') }}" class="text-gray-700 hover:text-blue-600">Fonctionnaires</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Historique de {{ $fonctionnaire->nom_complet }}</h1>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold mb-2">Informations du Fonctionnaire</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-sm text-gray-600">CIN:</span>
                            <p class="font-medium">{{ $fonctionnaire->cin }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Poste:</span>
                            <p class="font-medium">{{ $fonctionnaire->poste }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Contact:</span>
                            <p class="font-medium">{{ $fonctionnaire->contact }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Établissement:</span>
                            <p class="font-medium">{{ $fonctionnaire->etablissement }}</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Événement</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($historique as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->date_evenement->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $item->evenement }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $item->details }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    Aucun historique disponible
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.fonctionnaires.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
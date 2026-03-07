@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-green-50 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-green-700">{{ $etablissement->nom }}</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Déconnexion
            </button>
        </form>
    </div>

    <!-- Infos générales -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <p><strong class="text-green-700">Type :</strong> {{ $etablissement->type }}</p>
        <p><strong class="text-green-700">Ville :</strong> {{ $etablissement->ville }}</p>
        <p><strong class="text-green-700">Classes :</strong> {{ implode(', ', array_keys($etablissement->classes)) }}</p>
    </div>

    <!-- Tableau détaillé par classe et section -->
    <div class="overflow-x-auto mb-8">
        <table class="w-full bg-white border border-green-300 shadow-md rounded-lg text-left">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-4 py-2">Classe</th>
                    <th class="px-4 py-2">Section</th>
                    <th class="px-4 py-2">Nombre d'étudiants</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_etudiants = 0;
                @endphp
                @foreach($etablissement->classes as $classe => $sections)
                    @php
                        $total_classe = 0;
                    @endphp
                    @foreach($sections as $index => $section)
                        <tr class="@if($index % 2 == 0) bg-green-50 @endif">
                            @if($loop->first)
                                <td class="px-4 py-2 font-semibold" rowspan="{{ count($sections) }}">{{ $classe }}</td>
                            @endif
                            <td class="px-4 py-2">{{ $section['section'] }}</td>
                            <td class="px-4 py-2">{{ $section['etudiants'] }}</td>
                        </tr>
                        @php
                            $total_classe += $section['etudiants'];
                        @endphp
                    @endforeach
                    <tr class="bg-green-100 font-bold">
                        <td class="px-4 py-2" colspan="2">Total {{ $classe }}</td>
                        <td class="px-4 py-2">{{ $total_classe }}</td>
                    </tr>
                    @php
                        $total_etudiants += $total_classe;
                    @endphp
                @endforeach
            </tbody>
            <tfoot class="bg-green-200 font-bold">
                <tr>
                    <td class="px-4 py-2" colspan="2">Nombre total d'étudiants</td>
                    <td class="px-4 py-2">{{ $total_etudiants }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2" colspan="2">Nombre de salles</td>
                    <td class="px-4 py-2">{{ $etablissement->salles }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2" colspan="2">Nombre de tableaux</td>
                    <td class="px-4 py-2">{{ $etablissement->tableaux }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2" colspan="2">Nombre de tables/bancs</td>
                    <td class="px-4 py-2">{{ $etablissement->tables_bancs }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2" colspan="2">Taux de réussite (%)</td>
                    <td class="px-4 py-2">{{ $etablissement->taux_reussite }}%</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Graphique Chart.js -->
    <canvas id="reussiteChart" class="bg-white p-4 rounded-lg shadow-md"></canvas>

    <div class="mt-8 text-center">
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg font-semibold transition">
            Retour au tableau de bord
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('reussiteChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Taux de réussite'],
        datasets: [{
            label: 'Taux (%)',
            data: [{{ $etablissement->taux_reussite }}],
            backgroundColor: ['#8DB600'],
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
</script>
@endsection

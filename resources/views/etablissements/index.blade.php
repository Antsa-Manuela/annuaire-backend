<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold text-green-700 mb-4">Annuaire des Établissements</h1>

        <table class="w-full border rounded-md shadow-md bg-white">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="p-2">Nom</th>
                    <th class="p-2">Région</th>
                    <th class="p-2">Ville</th>
                    <th class="p-2">Type</th>
                    <th class="p-2">Contact</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etablissements as $et)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $et['nom'] }}</td>
                        <td class="p-2">{{ $et['region'] }}</td>
                        <td class="p-2">{{ $et['ville'] }}</td>
                        <td class="p-2">{{ $et['type'] }}</td>
                        <td class="p-2">{{ $et['contact'] }}</td>
                        <td class="p-2">
                            <a href="{{ route('etablissements.show', $et['id']) }}" class="text-green-700 font-semibold hover:underline">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Liste des Établissements</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                @foreach(array_keys($etablissements[0]) as $header)
                    <th>{{ $header }}</th>
                @endforeach
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etablissements as $index => $etablissement)
                <tr>
                    @foreach($etablissement as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                    <td>
                        <a href="{{ route('etablissements.show', $index + 1) }}" class="btn btn-sm btn-info">Détails</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

</x-app-layout>

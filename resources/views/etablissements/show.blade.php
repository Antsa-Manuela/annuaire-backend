<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold text-green-700 mb-4">{{ $etablissement['nom'] }}</h1>

        <div class="bg-white shadow-md p-4 rounded-md">
            <p><strong>Région :</strong> {{ $etablissement['region'] }}</p>
            <p><strong>Ville :</strong> {{ $etablissement['ville'] }}</p>
            <p><strong>Type :</strong> {{ $etablissement['type'] }}</p>
            <p><strong>Contact :</strong> {{ $etablissement['contact'] }}</p>
        </div>

        <a href="{{ route('index') }}" class="inline-block mt-4 text-green-700 hover:underline font-semibold">← Retour à la liste</a>
    </div>

    @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Détails de l’établissement</h2>
    <table class="table table-striped mt-3">
        <tbody>
            @foreach($etablissement as $key => $value)
                <tr>
                    <th>{{ $key }}</th>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('etablissements.index') }}" class="btn btn-secondary">⬅ Retour</a>
</div>
@endsection

</x-app-layout>

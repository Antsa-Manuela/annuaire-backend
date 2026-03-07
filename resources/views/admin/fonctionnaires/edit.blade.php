<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le Fonctionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.fonctionnaires.update', $fonctionnaire) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="cin" class="block text-sm font-medium text-gray-700">CIN</label>
                                <input type="text" name="cin" id="cin" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100"
                                    value="{{ $fonctionnaire->cin }}">
                                <p class="text-sm text-gray-500 mt-1">Le CIN ne peut pas être modifié</p>
                            </div>

                            <div>
                                <label for="nom_complet" class="block text-sm font-medium text-gray-700">Nom Complet *</label>
                                <input type="text" name="nom_complet" id="nom_complet" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('nom_complet', $fonctionnaire->nom_complet) }}">
                                @error('nom_complet') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="poste" class="block text-sm font-medium text-gray-700">Poste *</label>
                                <select name="poste" id="poste" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Sélectionnez un poste</option>
                                    <option value="Enseignant" {{ old('poste', $fonctionnaire->poste) == 'Enseignant' ? 'selected' : '' }}>Enseignant</option>
                                    <option value="RH" {{ old('poste', $fonctionnaire->poste) == 'RH' ? 'selected' : '' }}>RH</option>
                                    <option value="Surveillant" {{ old('poste', $fonctionnaire->poste) == 'Surveillant' ? 'selected' : '' }}>Surveillant</option>
                                    <option value="Administratif" {{ old('poste', $fonctionnaire->poste) == 'Administratif' ? 'selected' : '' }}>Administratif</option>
                                </select>
                                @error('poste') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700">Contact *</label>
                                <input type="text" name="contact" id="contact" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('contact', $fonctionnaire->contact) }}">
                                @error('contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" name="email" id="email" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('email', $fonctionnaire->email) }}">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="etablissement" class="block text-sm font-medium text-gray-700">Établissement *</label>
                                <input type="text" name="etablissement" id="etablissement" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('etablissement', $fonctionnaire->etablissement) }}">
                                @error('etablissement') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="actif" value="1"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                    {{ $fonctionnaire->actif ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Fonctionnaire actif</span>
                            </label>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.fonctionnaires.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                Modifier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
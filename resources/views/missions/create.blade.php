<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une mission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Affichage des erreurs de validation (optionnel, selon tes besoins) -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('missions.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Agent</label>
                        <input type="text" value="{{ auth()->user()->name }}"
                            class="border rounded w-full py-2 px-3 text-gray-700" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="type_mission" class="block text-gray-700 text-sm font-bold mb-2">Type de
                            Mission</label>
                        <input type="text" name="type_mission" id="type_mission"
                            class="border rounded w-full py-2 px-3 text-gray-700 @error('type_mission') border-red-500 @enderror"
                            required>
                        @error('type_mission')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="destination" class="block text-gray-700 text-sm font-bold mb-2">Destination</label>
                        <input type="text" name="destination" id="destination"
                            class="border rounded w-full py-2 px-3 text-gray-700 @error('destination') border-red-500 @enderror"
                            required>
                        @error('destination')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date_aller" class="block text-gray-700 text-sm font-bold mb-2">Date Aller</label>
                        <input type="date" name="date_aller" id="date_aller"
                            class="border rounded w-full py-2 px-3 text-gray-700 @error('date_aller') border-red-500 @enderror"
                            required>
                        @error('date_aller')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date_retour" class="block text-gray-700 text-sm font-bold mb-2">Date Retour</label>
                        <input type="date" name="date_retour" id="date_retour"
                            class="border rounded w-full py-2 px-3 text-gray-700 @error('date_retour') border-red-500 @enderror"
                            required>
                        @error('date_retour')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" id="description"
                            class="border rounded w-full py-2 px-3 text-gray-700 @error('description') border-red-500 @enderror"></textarea>
                        @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="agents" class="block text-gray-700 text-sm font-bold mb-2">Accompagnateurs</label>
                        <select name="agents[]" id="agents" class="border rounded w-full py-2 px-3 text-gray-700"
                            multiple>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
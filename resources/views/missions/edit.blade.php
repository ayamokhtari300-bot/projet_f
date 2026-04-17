<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editer Mission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form action="{{ route('missions.update', $mission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Type de Mission -->
                        <div class="mb-4">
                            <label for="type_mission" class="block text-sm font-medium text-gray-700">Type de Mission</label>
                            <input type="text" name="type_mission" id="type_mission" value="{{ $mission->type_mission }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Destination -->
                        <div class="mb-4">
                            <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
                            <input type="text" name="destination" id="destination" value="{{ $mission->destination }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Date Aller -->
                        <div class="mb-4">
                            <label for="date_aller" class="block text-sm font-medium text-gray-700">Date Aller</label>
                            <input type="date" name="date_aller" id="date_aller" value="{{ \Carbon\Carbon::parse($mission->date_aller)->format('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Date Retour -->
                        <div class="mb-4">
                            <label for="date_retour" class="block text-sm font-medium text-gray-700">Date Retour</label>
                            <input type="date" name="date_retour" id="date_retour" value="{{ \Carbon\Carbon::parse($mission->date_retour)->format('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Agents (Multi-sélection) -->
                        <div class="mb-4">
                            <label for="agents" class="block text-sm font-medium text-gray-700">Accompagnateurs</label>
                            <select name="agents[]" id="agents" multiple
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-32">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $mission->agents->contains($user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1 italic">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs agents.</p>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $mission->description }}</textarea>
                        </div>

                        <!-- Bouton Enregistrer -->
                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enregistrer les modifications
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
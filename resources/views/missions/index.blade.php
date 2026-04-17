<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Missions Registry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Notifications Success/Error -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Toutes les Missions</h3>
                    @hasanyrole('agent|operateur|validateur')
                        <a href="{{ route('missions.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                            ➕ Créer Mission
                        </a>
                    @endhasanyrole
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100 uppercase text-xs">
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Agent</th>
                                <th class="border px-4 py-2">Type</th>
                                <th class="border px-4 py-2">Destination</th>
                                <th class="border px-4 py-2">Dates</th>
                                <th class="border px-4 py-2">Véhicule</th>
                                <th class="border px-4 py-2">Statut</th>
                                <th class="border px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($missions as $mission)
                                <tr>
                                    <td class="border px-4 py-2 font-mono text-xs">#{{ str_pad($mission->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="border px-4 py-2 font-bold">{{ optional($mission->user)->name }}</td>
                                    <td class="border px-4 py-2">{{ $mission->type_mission }}</td>
                                    <td class="border px-4 py-2 font-semibold">{{ $mission->destination }}</td>
                                    <td class="border px-4 py-2 whitespace-nowrap">
                                        <div class="text-[10px] text-gray-500 italic">Du {{ \Carbon\Carbon::parse($mission->date_aller)->format('d/m/y') }}</div>
                                        <div class="text-[10px] text-gray-500 italic">Au {{ \Carbon\Carbon::parse($mission->date_retour)->format('d/m/y') }}</div>
                                    </td>
                                    <td class="border px-4 py-2 text-xs">
                                        {{ optional($mission->vehicule)->matricule ?? 'Affectation requise' }}
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                                    @if($mission->status == 'validee') bg-green-100 text-green-700
                                                    @elseif($mission->status == 'refusee') bg-red-100 text-red-700
                                                    @elseif($mission->status == 'en_cours') bg-yellow-100 text-yellow-700
                                                    @else bg-gray-100 text-gray-700 @endif">
                                            {{ str_replace('_', ' ', $mission->status) }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-right whitespace-nowrap">
                                        <a href="{{ route('missions.show', $mission->id) }}" class="text-blue-500 hover:text-blue-800 mx-2" title="Voir détails">🔍</a>

                                        @role('agent')
                                            @if($mission->status === 'en_attente')
                                                <a href="{{ route('missions.edit', $mission->id) }}" class="text-green-500 hover:text-green-800 mx-2" title="Modifier">✏️</a>
                                                <form action="{{ route('missions.destroy', $mission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Supprimer cette mission ?')" class="text-red-500 hover:text-red-800 mx-2" title="Supprimer">🗑️</button>
                                                </form>
                                            @endif
                                        @endrole

                                        @role('operateur')
                                            <div class="mt-2 text-left bg-gray-50 p-2 rounded border">
                                                <form action="{{ route('missions.affecter', $mission->id) }}" method="POST" class="mb-2">
                                                    @csrf
                                                    <select name="vehicule_id" class="text-[10px] border p-1 rounded w-full mb-1">
                                                        <option value="">Sélectionner Véhicule</option>
                                                        @foreach($vehicules as $vehicule)
                                                            <option value="{{ $vehicule->id }}" {{ $mission->vehicule_id == $vehicule->id ? 'selected' : '' }}>
                                                                {{ $vehicule->matricule }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="bg-blue-600 text-white text-[10px] px-2 py-1 rounded w-full">Affecter</button>
                                                </form>
                                                <form action="{{ route('missions.send', $mission->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-yellow-500 text-white text-[10px] px-2 py-1 rounded w-full">Envoyer au Validateur</button>
                                                </form>
                                            </div>
                                        @endrole

                                        @role('validateur')
                                            <div class="mt-2 text-left space-y-1">
                                                <form action="{{ route('missions.decision', $mission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="validee">
                                                    <button type="submit" class="bg-green-500 text-white text-[10px] px-2 py-1 rounded">Valider</button>
                                                </form>
                                                <form action="{{ route('missions.decision', $mission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="refusee">
                                                    <button type="submit" class="bg-red-500 text-white text-[10px] px-2 py-1 rounded">Refuser</button>
                                                </form>
                                            </div>
                                        @endrole
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

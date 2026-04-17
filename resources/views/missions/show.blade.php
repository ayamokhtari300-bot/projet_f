<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail Mission') }}
        </h2>
    </x-slot>

    <div class="py-12 text-gray-900 border-b border-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Mission à {{ $mission->destination }}</h3>
                        <a href="{{ route('missions.index') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">
                            &larr; Retour
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Infos de Base -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold border-b pb-2 text-indigo-700 uppercase text-xs tracking-wider">Informations de Base</h4>
                            <p><strong>Agent Demandeur:</strong> {{ optional($mission->user)->name ?? 'Agent inconnu' }}</p>
                            <p><strong>Type de Mission:</strong> {{ $mission->type_mission }}</p>
                            <p><strong>Destination:</strong> {{ $mission->destination }}</p>
                            <p><strong>Date Aller:</strong> {{ \Carbon\Carbon::parse($mission->date_aller)->format('d/m/Y') }}</p>
                            <p><strong>Date Retour:</strong> {{ \Carbon\Carbon::parse($mission->date_retour)->format('d/m/Y') }}</p>
                        </div>

                        <!-- Statut et Véhicule -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold border-b pb-2 text-indigo-700 uppercase text-xs tracking-wider">Logistique et Statut</h4>
                            <p><strong>Statut Actuel:</strong> 
                                <span class="px-2 py-1 rounded font-bold uppercase text-xs
                                    @if($mission->status == 'validee') bg-green-100 text-green-800
                                    @elseif($mission->status == 'refusee') bg-red-100 text-red-800
                                    @elseif($mission->status == 'en_cours') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $mission->status }}
                                </span>
                            </p>
                            <p><strong>Véhicule Affecté:</strong> 
                                {{ optional($mission->vehicule)->matricule ?? 'Aucun véhicule affecté pour le moment.' }}
                            </p>
                            @if($mission->vehicule)
                                <p class="text-sm text-gray-600 italic">({{ $mission->vehicule->marque }} - {{ $mission->vehicule->model }})</p>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold border-b pb-2 text-indigo-700 uppercase text-xs tracking-wider">Description / Instructions</h4>
                        <div class="bg-gray-50 border p-4 rounded mt-2">
                            {{ $mission->description ?: 'Aucune description fournie.' }}
                        </div>
                    </div>

                    <!-- Liste des Accompagnateurs -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold border-b pb-2 text-indigo-700 uppercase text-xs tracking-wider">Équipage / Accompagnateurs</h4>
                        <ul class="list-disc list-inside mt-2">
                            @forelse($mission->agents as $agent)
                                <li>{{ $agent->name }} ({{ $agent->email }})</li>
                            @empty
                                <li class="text-gray-500 italic">Aucun accompagnateur pour cette mission.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Actions (Uniquement pour certains rôles) -->
                    <div class="mt-10 pt-6 border-t flex gap-4">
                        @role('agent')
                            @if($mission->status === 'en_attente')
                                <a href="{{ route('missions.edit', $mission->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Modifier la Mission ✏️
                                </a>
                            @endif
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
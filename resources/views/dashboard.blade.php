<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @push('styles')
        <style>
            :root {
                --surface-container-lowest: #ffffff;
                --primary: #6366f1;
            }

            .bg-surface-container-lowest {
                background-color: var(--surface-container-lowest);
            }

            .border-primary {
                border-color: var(--primary);
            }

            .premium-card-v2 {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .premium-card-v2:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .stat-label {
                font-size: 0.65rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #64748b;
                position: relative;
                z-index: 2;
            }

            .stat-value {
                font-size: 2.25rem;
                font-weight: 800;
                color: #1e293b;
                line-height: normal;
                position: relative;
                z-index: 2;
                margin-top: 0.25rem;
            }

            .stat-footer {
                margin-top: 1rem;
                font-size: 0.75rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                position: relative;
                z-index: 2;
            }

            .card-accent {
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 4px;
                opacity: 0.8;
            }
        </style>
    @endpush

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques Premium -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <!-- Carte In Progress -->
                <div class="premium-card-v2 bg-surface-container-lowest p-6 rounded-xl shadow-sm border-l-4 border-primary">
                    <div class="card-accent bg-indigo-500"></div>
                    <div>
                        <div class="stat-label">En Cours</div>
                        <div class="stat-value">{{ sprintf('%02d', $totalEnCours) }}</div>
                    </div>
                    <div class="stat-footer text-indigo-600">
                        <i class="bi bi-graph-up-arrow"></i> + Activité récente
                    </div>
                </div>

                <!-- Carte Validées -->
                <div class="premium-card-v2 bg-surface-container-lowest p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <div class="card-accent bg-green-500"></div>
                    <div>
                        <div class="stat-label">Validées</div>
                        <div class="stat-value">{{ sprintf('%02d', $totalValidee) }}</div>
                    </div>
                    <div class="stat-footer text-green-600">
                        <i class="bi bi-check-circle-fill"></i> 98% taux de validation
                    </div>
                </div>

                <!-- Carte Refusées -->
                <div class="premium-card-v2 bg-surface-container-lowest p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                    <div class="card-accent bg-red-500"></div>
                    <div>
                        <div class="stat-label">Refusées</div>
                        <div class="stat-value">{{ sprintf('%02d', $totalRefusee) }}</div>
                    </div>
                    <div class="stat-footer text-red-500">
                        <i class="bi bi-exclamation-triangle-fill"></i> Nécessite révision
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <!-- Notifications de succès/erreur -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Bouton création (Agent, Opérateur, Validateur) -->
                    @hasanyrole('agent|operateur|validateur')
                    <a href="{{ route('missions.create') }}"
                        class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                        ➕ Créer Mission
                    </a>
                    @endhasanyrole
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold">Missions Récentes</h3>
                    <a href="{{ route('missions.index') }}" class="text-blue-600 hover:underline">
                        Voir toutes les missions &rarr;
                    </a>
                </div>

                <!-- Nombre des missions affichées -->
                <p class="mb-4 text-sm text-gray-600">Affichage des 5 dernières missions.</p>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">Agent</th>
                                <th class="border px-4 py-2">Type</th>
                                <th class="border px-4 py-2">Destination</th>
                                <th class="border px-4 py-2">Date Aller</th>
                                <th class="border px-4 py-2">Date Retour</th>

                                <th class="border px-4 py-2">Accompagnateurs</th>
                                <th class="border px-4 py-2">Véhicule</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($missions as $mission)
                                <tr>
                                    <!-- Agent -->
                                    <td class="border px-4 py-2">{{ optional($mission->user)->name ?? '---' }}</td>
                                    <!-- Type -->
                                    <td class="border px-4 py-2">{{ $mission->type_mission }}</td>
                                    <!-- Destination -->
                                    <td class="border px-4 py-2">{{ $mission->destination }}</td>

                                    <!-- Dates -->
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($mission->date_aller)->format('d/m/Y') }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($mission->date_retour)->format('d/m/Y') }}
                                    </td>

                                    <!-- Accompagnateurs -->
                                    <td class="border px-4 py-2">
                                        @php $hasAccompagnateur = false; @endphp
                                        @foreach($mission->agents as $agent)
                                            @if($agent->pivot->agent_type == 'ac')
                                                • {{ $agent->name }} <br>
                                                @php $hasAccompagnateur = true; @endphp
                                            @endif
                                        @endforeach
                                        @if(!$hasAccompagnateur) --- @endif
                                    </td>

                                    <!-- Véhicule -->
                                    <td class="border px-4 py-2">
                                        {{ optional($mission->vehicule)->matricule ?? 'Pas encore affecté' }}
                                    </td>

                                    <!-- Status -->
                                    <td class="border px-4 py-2 uppercase font-semibold text-xs text-center">
                                        <span class="px-2 py-1 rounded
                                                    @if($mission->status == 'validee') bg-green-100 text-green-800
                                                    @elseif($mission->status == 'refusee') bg-red-100 text-red-800
                                                    @elseif($mission->status == 'en_cours') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                            {{ $mission->status }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="border px-4 py-2 whitespace-nowrap">
                                        <!-- Detail (Pour tout le monde) -->
                                        <a href="{{ route('missions.show', $mission->id) }}"
                                            class="text-blue-600 underline mr-2">Detail🔍</a>

                                        @role('agent')
                                        <!-- Edit -->
                                        <a href="{{ route('missions.edit', $mission->id) }}"
                                            class="text-green-600 underline mr-2">Edit✏️</a>

                                        <!-- Delete -->
                                        <form action="{{ route('missions.destroy', $mission->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Supprimer cette mission ?')"
                                                class="text-red-600 underline">Supprimer❌</button>
                                        </form>
                                        @endrole

                                        @role('operateur')
                                        <div class="mt-2 flex flex-wrap gap-2 items-center">
                                            <form action="{{ route('missions.affecter', $mission->id) }}" method="POST"
                                                class="flex flex-col gap-2">
                                                @csrf
                                                <select name="vehicule_id" class="border rounded px-2 py-1 form-select">
                                                    <option value="">-- Choisir Véhicule --</option>
                                                    @foreach($vehicules as $vehicule)
                                                        <option value="{{ $vehicule->id }}" {{ $mission->vehicule_id == $vehicule->id ? 'selected' : '' }}>
                                                            {{ $vehicule->matricule }} - {{ $vehicule->marque }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit"
                                                    class="bg-blue-500 text-white rounded px-2 py-1 text-sm hover:bg-blue-700">Affecter
                                                    Véhicule</button>
                                            </form>

                                            <!-- Bouton Envoyer au Validateur -->
                                            <form action="{{ route('missions.send', $mission->id) }}" method="POST"
                                                class="w-full">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-yellow-500 text-black rounded px-2 py-1 text-sm hover:bg-yellow-700"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir envoyer cette mission au validateur ?');">
                                                    Envoyer au Validateur ➡️
                                                </button>
                                            </form>

                                            <!-- Bouton Notifier Agent (si validée/refusée) -->
                                            @if(in_array($mission->status, ['validee', 'refusee']))
                                                <form action="{{ route('missions.notifyAgent', $mission->id) }}" method="POST"
                                                    class="w-full">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full bg-indigo-500 text-black rounded px-2 py-1 text-sm hover:bg-indigo-700"
                                                        onclick="return confirm('Notifier l\'agent du statut final ?');">
                                                        Notifier l'Agent 📧
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        @endrole

                                        @role('validateur')
                                        <div class="mt-2 flex gap-2 flex-wrap">
                                            <!-- Bouton Éditer -->
                                            <a href="{{ route('missions.edit', $mission->id) }}"
                                                class="bg-blue-600 text-white rounded px-2 py-1 text-sm hover:bg-blue-800 flex items-center">
                                                Modifier ✏️
                                            </a>

                                            <form action="{{ route('missions.decision', $mission->id) }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir valider cette mission ?');">
                                                @csrf
                                                <input type="hidden" name="status" value="validee">
                                                <button type="submit"
                                                    class="bg-green-500 text-black rounded px-2 py-1 text-sm hover:bg-green-700">Valider
                                                    ✅</button>
                                            </form>
                                            <form action="{{ route('missions.decision', $mission->id) }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette mission ?');">
                                                @csrf
                                                <input type="hidden" name="status" value="refusee">
                                                <button type="submit"
                                                    class="bg-red-500 text-black rounded px-2 py-1 text-sm hover:bg-red-700">refuser
                                                    ❌</button>
                                            </form>

                                            <!-- Bouton Supprimer pour Validateur -->
                                            <form action="{{ route('missions.destroy', $mission->id) }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-gray-800 text-white rounded px-2 py-1 text-sm hover:bg-black">Supprimer
                                                    🗑️</button>
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
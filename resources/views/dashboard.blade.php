<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <style>
            /* Annuler le soulignement par défaut de Bootstrap */
            a {
                text-decoration: none;
            }
            
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

            .mission-card-hover {
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
            }

            .mission-card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
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
            {{-- Statistiques Premium --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

                {{-- Carte Total Missions --}}
                <div class="premium-card-v2 bg-surface-container-lowest p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <div class="card-accent bg-blue-500"></div>
                    <div>
                        <div class="stat-label">Total Missions</div>
                        <div class="stat-value">{{ sprintf('%02d', $totalMissions) }}</div>
                    </div>
                    <div class="stat-footer text-blue-600">
                        <i class="bi bi-collection-fill"></i> Toutes les missions
                    </div>
                </div>

                {{-- Carte En Cours --}}
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

                {{-- Carte Validées --}}
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

                {{-- Carte Refusées --}}
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

                <div class="row g-4 mt-2">
                    @foreach($missions as $mission)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm mission-card-hover" style="border-radius: 16px; border: none; overflow: hidden; background: #fff;">
                            <div class="card-header bg-white pt-4 pb-2 border-0 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0 text-primary" style="font-size: 1.1rem;">
                                    <i class="bi bi-geo-alt-fill me-1"></i>{{ $mission->destination }}
                                </h5>
                                <span class="badge rounded-pill
                                    @if($mission->status == 'validee') bg-success
                                    @elseif($mission->status == 'refusee') bg-danger
                                    @elseif($mission->status == 'en_cours') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ strtoupper($mission->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem; letter-spacing: 0.5px;">Agent Demandeur</small>
                                    <div class="mt-1 fw-medium text-dark">{{ optional($mission->user)->name ?? '---' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem; letter-spacing: 0.5px;">Type</small>
                                        <div class="mt-1 text-dark">{{ $mission->type_mission }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem; letter-spacing: 0.5px;">Véhicule</small>
                                        <div class="mt-1 text-dark">{{ optional($mission->vehicule)->matricule ?? 'Non affecté' }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem; letter-spacing: 0.5px;">Date Aller</small>
                                        <div class="mt-1 text-dark">{{ \Carbon\Carbon::parse($mission->date_aller)->format('d/m/Y à H:i') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem; letter-spacing: 0.5px;">Date Retour</small>
                                        <div class="mt-1 text-dark">{{ \Carbon\Carbon::parse($mission->date_retour)->format('d/m/Y à H:i')}}</div>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem; letter-spacing: 0.5px;">Accompagnateurs</small>
                                    <div class="mt-1 text-dark" style="font-size: 0.85rem;">
                                        @php $hasAccompagnateur = false; @endphp
                                        @foreach($mission->agents as $agent)
                                            @if($agent->pivot->agent_type == 'ac')
                                                <span class="badge bg-light text-dark border me-1 mb-1">{{ $agent->name }}</span>
                                                @php $hasAccompagnateur = true; @endphp
                                            @endif
                                        @endforeach
                                        @if(!$hasAccompagnateur)
                                            <span class="text-muted fst-italic">Aucun</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0 py-3">
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <a href="{{ route('missions.show', $mission->id) }}" class="btn btn-sm btn-outline-primary">Détail 🔍</a>
                                        
                                        <div class="d-flex flex-wrap gap-1">
                                            @role('agent')
                                                <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-sm btn-primary" title="Modifier">✏️</a>
                                                <form action="{{ route('missions.destroy', $mission->id) }}" method="POST" class="m-0" onsubmit="return confirm('Supprimer cette mission ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">Supprimer❌</button>
                                                </form>
                                            @endrole

                                            @role('validateur')
                                                <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-sm btn-primary" title="Modifier">✏️</a>
                                                <form action="{{ route('missions.decision', $mission->id) }}" method="POST" class="m-0" onsubmit="return confirm('Vous allez valider cette mission.');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="validee">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Valider">Valider✅</button>
                                                </form>
                                                <form action="{{ route('missions.decision', $mission->id) }}" method="POST" class="m-0" onsubmit="return confirm('Vous allez refuser cette mission.');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="refusee">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Refuser">Refuser❌</button>
                                                </form>
                                                <form action="{{ route('missions.destroy', $mission->id) }}" method="POST" class="m-0" onsubmit="return confirm('Supprimer définitivement la mission ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-dark" title="Supprimer">Supprimer🗑️</button>
                                                </form>
                                            @endrole
                                        </div>
                                    </div>
                                    
                                    @role('operateur')
                                        <div class="border-top pt-2 mt-1">
                                            <form action="{{ route('missions.affecter', $mission->id) }}" method="POST" class="d-flex gap-2 mb-2">
                                                @csrf
                                                <select name="vehicule_id" class="form-select form-select-sm" style="flex: 1;">
                                                    <option value="">-- Choisir Véhicule --</option>
                                                    @foreach($vehicules as $vehicule)
                                                        <option value="{{ $vehicule->id }}" {{ $mission->vehicule_id == $vehicule->id ? 'selected' : '' }}>
                                                            {{ $vehicule->matricule }} - {{ $vehicule->marque }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Affecter</button>
                                            </form>
                                            
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('missions.send', $mission->id) }}" method="POST" class="m-0" style="flex: 1;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning w-100 fw-bold" onclick="return confirm('Êtes-vous sûr de vouloir envoyer cette mission au validateur ?');">
                                                        Envoyer au Validateur ➡️
                                                    </button>
                                                </form>

                                                @if(in_array($mission->status, ['validee', 'refusee']))
                                                    <form action="{{ route('missions.notifyAgent', $mission->id) }}" method="POST" class="m-0" style="flex: 1;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info w-100 text-white fw-bold" onclick="return confirm('Notifier l\'agent du statut final ?');">
                                                            Notifier l'Agent 📧
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</x-app-layout>
<x-app-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <style>
            a { text-decoration: none; }

            .missions-index-wrapper {
                font-family: 'Inter', system-ui, sans-serif;
            }

            .page-hero {
                background: linear-gradient(135deg, #004680 0%, #4484BA 100%);
                border-radius: 16px;
                padding: 2rem 2.5rem;
                margin-bottom: 2rem;
                color: white;
            }

            .mission-card-hover {
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
                border-radius: 16px !important;
                border: none !important;
                overflow: hidden;
            }

            .mission-card-hover:hover {
                transform: translateY(-7px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
            }

            .status-badge {
                padding: 0.35rem 0.85rem;
                border-radius: 50rem;
                font-size: 0.7rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .card-meta-label {
                font-size: 0.65rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #94a3b8;
                margin-bottom: 0.2rem;
            }

            .card-meta-value {
                font-size: 0.9rem;
                color: #1e293b;
                font-weight: 500;
            }

            .empty-state-icon {
                font-size: 4rem;
                color: #cbd5e1;
            }

            .btn-action {
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.8rem;
                transition: all 0.2s ease;
            }

            .btn-action:hover {
                transform: translateY(-1px);
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registre des Missions') }}
        </h2>
    </x-slot>

    <div class="py-8 missions-index-wrapper">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Hero Header --}}
            <div class="page-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="fw-bold fs-4 mb-1">
                        <i class="bi bi-collection me-2"></i>Toutes les Missions
                    </h3>
                    <p class="mb-0 opacity-75">Consultez et gérez l'ensemble des déplacements de la flotte.</p>
                </div>
                @hasanyrole('agent|operateur|validateur')
                    <a href="{{ route('missions.create') }}" class="btn btn-light fw-bold px-4 py-2 rounded-3 shadow-sm text-primary">
                        <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Mission
                    </a>
                @endhasanyrole
            </div>

            {{-- Notifications --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Missions Grid --}}
            <div class="row g-4">
                @forelse($missions as $mission)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm mission-card-hover bg-white">

                            {{-- Card Header --}}
                            <div class="card-header bg-white pt-4 pb-2 border-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold text-primary mb-1" style="font-size: 1.05rem;">
                                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $mission->destination }}
                                    </h5>
                                    <small class="text-muted fw-bold">#{{ str_pad($mission->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                                <span class="status-badge 
                                    @if($mission->status == 'validee') bg-success text-white
                                    @elseif($mission->status == 'refusee') bg-danger text-white
                                    @elseif($mission->status == 'en_cours') bg-warning text-dark
                                    @else bg-secondary text-white @endif">
                                    {{ str_replace('_', ' ', $mission->status) }}
                                </span>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body pt-2">
                                <div class="mb-3">
                                    <div class="card-meta-label">Agent Demandeur</div>
                                    <div class="card-meta-value fw-bold">
                                        <i class="bi bi-person-circle text-primary me-1"></i>
                                        {{ optional($mission->user)->name ?? '---' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="card-meta-label">Type de Mission</div>
                                        <div class="card-meta-value">{{ $mission->type_mission }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card-meta-label">Véhicule</div>
                                        <div class="card-meta-value">
                                            @if($mission->vehicule)
                                                <i class="bi bi-car-front-fill text-success me-1"></i>{{ $mission->vehicule->matricule }}
                                            @else
                                                <span class="text-muted fst-italic">Non affecté</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="card-meta-label"><i class="bi bi-calendar-event me-1"></i>Date Aller</div>
                                        <div class="card-meta-value">{{ \Carbon\Carbon::parse($mission->date_aller)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card-meta-label"><i class="bi bi-calendar-check me-1"></i>Date Retour</div>
                                        <div class="card-meta-value">{{ \Carbon\Carbon::parse($mission->date_retour)->format('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <div>
                                    <div class="card-meta-label"><i class="bi bi-people me-1"></i>Accompagnateurs</div>
                                    <div class="mt-1">
                                        @php $hasAc = false; @endphp
                                        @foreach($mission->agents as $agent)
                                            @if($agent->pivot->agent_type == 'ac')
                                                <span class="badge bg-light text-dark border me-1 mb-1" style="font-size: 0.75rem;">{{ $agent->name }}</span>
                                                @php $hasAc = true; @endphp
                                            @endif
                                        @endforeach
                                        @if(!$hasAc)
                                            <span class="text-muted fst-italic" style="font-size: 0.8rem;">Aucun</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Card Footer --}}
                            <div class="card-footer bg-light border-0 p-3">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('missions.show', $mission->id) }}" class="btn btn-outline-primary btn-action w-100">
                                        <i class="bi bi-eye me-1"></i>Voir les Détails
                                    </a>

                                    {{-- Agent Actions --}}
                                    @role('agent')
                                        @if($mission->status === 'en_attente')
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-sm btn-warning btn-action text-dark flex-fill">
                                                    <i class="bi bi-pencil-fill me-1"></i>Modifier
                                                </a>
                                                <form action="{{ route('missions.destroy', $mission->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Supprimer cette mission définitivement ?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-action w-100">
                                                        <i class="bi bi-trash-fill me-1"></i>Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endrole

                                    {{-- Validateur Actions --}}
                                    @role('validateur')
                                        @if(in_array($mission->status, ['en_attente', 'en_cours']))
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('missions.decision', $mission->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Valider cette mission ?');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="validee">
                                                    <button type="submit" class="btn btn-sm btn-success btn-action w-100">
                                                        <i class="bi bi-check2-circle me-1"></i>Valider
                                                    </button>
                                                </form>
                                                <form action="{{ route('missions.decision', $mission->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Refuser cette mission ?');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="refusee">
                                                    <button type="submit" class="btn btn-sm btn-danger btn-action w-100">
                                                        <i class="bi bi-x-circle me-1"></i>Refuser
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endrole

                                    {{-- Opérateur Actions --}}
                                    @role('operateur')
                                        <div class="border-top pt-2">
                                            <form action="{{ route('missions.affecter', $mission->id) }}" method="POST" class="d-flex gap-2 mb-2">
                                                @csrf
                                                <select name="vehicule_id" class="form-select form-select-sm" style="flex: 1;">
                                                    <option value="">-- Choisir un Véhicule --</option>
                                                    @foreach($vehicules as $vehicule)
                                                        <option value="{{ $vehicule->id }}" {{ $mission->vehicule_id == $vehicule->id ? 'selected' : '' }}>
                                                            {{ $vehicule->matricule }} - {{ $vehicule->marque }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary btn-action">Affecter</button>
                                            </form>
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('missions.send', $mission->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Envoyer au validateur ?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning btn-action w-100 fw-bold text-dark">
                                                        <i class="bi bi-send-fill me-1"></i>Envoyer au Validateur
                                                    </button>
                                                </form>
                                                @if(in_array($mission->status, ['validee', 'refusee']))
                                                    <form action="{{ route('missions.notifyAgent', $mission->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Notifier l\'agent ?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info btn-action w-100 text-white fw-bold">
                                                            <i class="bi bi-bell-fill me-1"></i>Notifier
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
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-clipboard-x empty-state-icon d-block mb-3"></i>
                        <h5 class="text-muted">Aucune mission trouvée</h5>
                        <p class="text-muted">Créez votre première mission pour commencer.</p>
                        @hasanyrole('agent|operateur|validateur')
                            <a href="{{ route('missions.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i>Créer une Mission
                            </a>
                        @endhasanyrole
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($missions->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $missions->links() }}
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</x-app-layout>

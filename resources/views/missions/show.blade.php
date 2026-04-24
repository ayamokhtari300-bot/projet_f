<x-app-layout>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Annuler le soulignement par défaut de Bootstrap */
        a {
            text-decoration: none;
        }
        
        .mission-detail-wrapper {
            font-family: 'Inter', system-ui, sans-serif;
            margin-top: 2rem;
        }
        .premium-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            overflow: hidden;
        }
        .card-header-gradient {
            background: linear-gradient(135deg, #004680 0%, #4484BA 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }
        .info-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-size: 1.1rem;
            color: #212529;
            font-weight: 500;
        }
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 50rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .bg-validee { background-color: #d1e7dd; color: #0f5132; }
        .bg-refusee { background-color: #f8d7da; color: #842029; }
        .bg-en_cours { background-color: #fff3cd; color: #664d03; }
        .bg-en_attente { background-color: #e2e3e5; color: #41464b; }
        .section-title {
            position: relative;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            color: #004680;
            font-weight: 700;
        }
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #004680;
            border-radius: 3px;
        }
        .btn-custom {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="font-family: inherit;">
            {{ __('Détail Mission') }}
        </h2>
    </x-slot>

    <div class="mission-detail-wrapper container mb-5">
        <div class="premium-card">
            <div class="card-header-gradient d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h3 class="mb-0 fw-bold fs-4">
                    <i class="bi bi-rocket-takeoff me-2"></i>Mission vers {{ $mission->destination }}
                </h3>
                <a href="{{ route('missions.index') }}" class="btn btn-light btn-custom text-primary shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="row g-4 mb-5">
                    <!-- Informations de Base -->
                    <div class="col-md-6">
                        <h4 class="section-title h5"><i class="bi bi-info-circle me-2"></i>Informations de Base</h4>
                        <div class="bg-light p-4 rounded-4 h-100">
                            <div class="mb-3">
                                <div class="info-label">Agent Demandeur</div>
                                <div class="info-value">
                                    <i class="bi bi-person-badge text-primary me-2"></i>{{ optional($mission->user)->name ?? 'Agent inconnu' }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Type de Mission</div>
                                <div class="info-value">{{ $mission->type_mission }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-label">Date Aller</div>
                                    <div class="info-value"><i class="bi bi-calendar-event text-primary me-2"></i>{{ \Carbon\Carbon::parse($mission->date_aller)->format('d/m/Y') }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="info-label">Date Retour</div>
                                    <div class="info-value"><i class="bi bi-calendar-check text-primary me-2"></i>{{ \Carbon\Carbon::parse($mission->date_retour)->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logistique et Statut -->
                    <div class="col-md-6">
                        <h4 class="section-title h5"><i class="bi bi-truck me-2"></i>Logistique et Statut</h4>
                        <div class="bg-light p-4 rounded-4 h-100">
                            <div class="mb-4">
                                <div class="info-label mb-2">Statut Actuel</div>
                                <span class="badge badge-status 
                                    @if($mission->status == 'validee') bg-validee
                                    @elseif($mission->status == 'refusee') bg-refusee
                                    @elseif($mission->status == 'en_cours') bg-en_cours
                                    @else bg-en_attente @endif">
                                    {{ strtoupper($mission->status) }}
                                </span>
                            </div>
                            <div>
                                <div class="info-label">Véhicule Affecté</div>
                                @if($mission->vehicule)
                                    <div class="info-value d-flex align-items-center mt-1">
                                        <div class="bg-white p-2 rounded border border-2 shadow-sm d-inline-block">
                                            <i class="bi bi-car-front text-dark me-2"></i>
                                            <span class="fw-bold text-dark">{{ $mission->vehicule->matricule }}</span>
                                        </div>
                                    </div>
                                    <div class="text-muted small mt-2 ms-1">({{ $mission->vehicule->marque }} - {{ $mission->vehicule->model }})</div>
                                @else
                                    <div class="info-value text-muted fst-italic">Aucun véhicule affecté pour le moment.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-5">
                    <h4 class="section-title h5"><i class="bi bi-card-text me-2"></i>Description / Instructions</h4>
                    <div class="bg-light p-4 rounded-4 border-start border-4 border-primary">
                        <p class="mb-0 fs-6 text-dark" style="white-space: pre-line;">
                            {{ $mission->description ?: 'Aucune description fournie.' }}
                        </p>
                    </div>
                </div>

                <!-- Liste des Accompagnateurs -->
                <div class="mb-4">
                    <h4 class="section-title h5"><i class="bi bi-people me-2"></i>Équipage / Accompagnateurs</h4>
                    <div class="bg-light p-4 rounded-4">
                        @if($mission->agents->count() > 0)
                            <div class="row g-3">
                                @foreach($mission->agents as $agent)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm border border-light">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-person text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $agent->name }}</h6>
                                                <small class="text-muted">{{ $agent->email }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted fst-italic mb-0"><i class="bi bi-info-circle me-1"></i> Aucun accompagnateur pour cette mission.</p>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                @role('agent')
                    @if($mission->status === 'en_attente')
                        <div class="mt-5 pt-4 border-top text-end">
                            <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-warning btn-custom text-dark shadow-sm px-4">
                                <i class="bi bi-pencil-square me-2"></i>Modifier la Mission
                            </a>
                        </div>
                    @endif
                @endrole
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</x-app-layout>
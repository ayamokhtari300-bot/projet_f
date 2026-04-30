<x-app-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <style>
            a { text-decoration: none; }

            .vehicules-index-wrapper {
                font-family: 'Inter', system-ui, sans-serif;
            }

            .page-hero {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                border-radius: 16px;
                padding: 2rem 2.5rem;
                margin-bottom: 2rem;
                color: white;
            }

            .vehicule-card-hover {
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
                border-radius: 16px !important;
                border: none !important;
                overflow: hidden;
            }

            .vehicule-card-hover:hover {
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
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Véhicules') }}
        </h2>
    </x-slot>

    <div class="py-8 vehicules-index-wrapper">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Hero Header --}}
            <div class="page-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="fw-bold fs-4 mb-1">
                        <i class="bi bi-car-front-fill me-2"></i>Tous les Véhicules
                    </h3>
                    <p class="mb-0 text-gray-300">Consultez la liste des véhicules disponibles et indisponibles de la flotte.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Vehicules Grid --}}
            <div class="row g-4">
                @forelse($vehicules as $vehicule)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm vehicule-card-hover bg-white border-0">
                            
                            {{-- Card Header --}}
                            <div class="card-header bg-white pt-4 pb-3 border-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">
                                        {{ $vehicule->matricule }}
                                    </h5>
                                    <small class="text-muted fw-bold">ID: #{{ str_pad($vehicule->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="status-badge 
                                        @if($vehicule->disponibilite) bg-success text-white
                                        @else bg-danger text-white @endif">
                                        @if($vehicule->disponibilite)
                                            <i class="bi bi-check-circle-fill me-1"></i> Disponible
                                        @else
                                            <i class="bi bi-x-circle-fill me-1"></i> Indisponible
                                        @endif
                                    </span>
                                    
                                    @role('operateur')
                                    <form action="{{ route('vehicules.toggle-status', $vehicule) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; padding: 0;" title="Changer le statut">
                                            <i class="bi bi-arrow-repeat text-secondary"></i>
                                        </button>
                                    </form>
                                    @endrole
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body pt-2 pb-4">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="card-meta-label">Type de Véhicule</div>
                                        <div class="card-meta-value d-flex align-items-center">
                                            @if(in_array(strtolower($vehicule->type_voiture), ['suv', 'berline', 'citadine']))
                                                <i class="bi bi-car-front text-primary fs-5 me-2"></i>
                                            @elseif(in_array(strtolower($vehicule->type_voiture), ['camionnette', 'utilitaire']))
                                                <i class="bi bi-truck text-primary fs-5 me-2"></i>
                                            @else
                                                <i class="bi bi-car-front text-primary fs-5 me-2"></i>
                                            @endif
                                            <span class="fw-bold">{{ $vehicule->type_voiture }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="card-meta-label">Date d'ajout</div>
                                        <div class="card-meta-value text-muted">
                                            {{ $vehicule->created_at ? $vehicule->created_at->format('d/m/Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-car-front empty-state-icon d-block mb-3"></i>
                        <h5 class="text-muted">Aucun véhicule trouvé</h5>
                        <p class="text-muted">Il n'y a actuellement aucun véhicule enregistré dans la base de données.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($vehicules->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $vehicules->links() }}
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</x-app-layout>

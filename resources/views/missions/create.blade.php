<x-app-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <style>
            /* Annuler le soulignement par défaut de Bootstrap */
            a {
                text-decoration: none;
            }

            .mission-create-wrapper {
                font-family: 'Inter', system-ui, sans-serif;
                margin-top: 2rem;
            }

            .premium-form-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                background: #ffffff;
                overflow: hidden;
            }

            .form-header-gradient {
                background: linear-gradient(135deg, #59CDE9 0%, #0A2A88 100%);
                color: white;
                padding: 1.5rem 2rem;
                border-bottom: none;
            }

            .form-label {
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.5rem;
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                border: 1px solid #d1d5db;
                padding: 0.6rem 1rem;
                transition: all 0.2s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #0A2A88;
                box-shadow: 0 0 0 0.25rem rgba(10, 42, 136, 0.25);
            }

            .premium-input-group {
                background-color: #f9fafb;
                padding: 1.5rem;
                border-radius: 12px;
                margin-bottom: 1.5rem;
                border: 1px solid #f3f4f6;
            }

            .btn-custom-save {
                background: linear-gradient(135deg, #59CDE9 0%, #0A2A88 100%);
                color: white;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                padding: 0.75rem 2rem;
                transition: all 0.3s ease;
            }

            .btn-custom-save:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 70, 128, 0.4);
                color: white;
            }

            .btn-custom-cancel {
                border-radius: 8px;
                font-weight: 600;
                padding: 0.75rem 2rem;
                transition: all 0.3s ease;
            }

            .btn-custom-cancel:hover {
                background-color: #f3f4f6;
                color: #1f2937;
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="font-family: inherit;">
            {{ __('Créer une mission') }}
        </h2>
    </x-slot>

    <div class="mission-create-wrapper container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="premium-form-card">
                    <div class="form-header-gradient d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold fs-4">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Mission
                        </h3>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <!-- Affichage des erreurs -->
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 mb-4 border-0 shadow-sm">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('missions.store') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- Agent Demandeur (Read-only) -->
                                <div class="col-12">
                                    <div class="premium-input-group">
                                        <label class="form-label"><i
                                                class="bi bi-person-badge-fill text-primary me-2"></i>Agent
                                            Demandeur</label>
                                        <!-- <input type="text" value="{{ auth()->user()->name }}"
                                            class="form-control bg-white" disabled> -->
                                    </div>
                                </div>

                                <!-- Type & Destination -->
                                <div class="col-md-6">
                                    <div class="premium-input-group h-100">
                                        <div class="mb-4">
                                            <label for="type_mission" class="form-label"><i
                                                    class="bi bi-tag-fill text-primary me-2"></i>Type de Mission</label>
                                            <input type="text" name="type_mission" id="type_mission"
                                                value="{{ old('type_mission') }}"
                                                class="form-control @error('type_mission') is-invalid @enderror"
                                                placeholder="Ex: Technique, Commerciale..." required>
                                        </div>
                                        <div>
                                            <label for="destination" class="form-label"><i
                                                    class="bi bi-geo-alt-fill text-primary me-2"></i>Destination</label>
                                            <input type="text" name="destination" id="destination"
                                                value="{{ old('destination') }}"
                                                class="form-control @error('destination') is-invalid @enderror"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="col-md-6">
                                    <div class="premium-input-group h-100">
                                        <div class="mb-4">
                                            <label for="date_aller" class="form-label"><i
                                                    class="bi bi-calendar-event text-primary me-2"></i>Date
                                                Aller</label>
                                            <input type="datetime-local" name="date_aller" id="date_aller"
                                                value="{{ old('date_aller') }}"
                                                class="form-control @error('date_aller') is-invalid @enderror" required>
                                        </div>
                                        <div>
                                            <label for="date_retour" class="form-label"><i
                                                    class="bi bi-calendar-check text-primary me-2"></i>Date
                                                Retour</label>
                                            <input type="datetime-local" name="date_retour" id="date_retour"
                                                value="{{ old('date_retour') }}"
                                                class="form-control @error('date_retour') is-invalid @enderror"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accompagnateurs -->
                                <div class="col-12">
                                    <div class="premium-input-group">
                                        <label class="form-label"><i
                                                class="bi bi-people-fill text-primary me-2"></i>Accompagnateurs (<span
                                                id="agent_count">0</span>)</label>

                                        <div class="d-flex gap-2 mb-3">
                                            <select id="agent_select" class="form-select">
                                                <option value="">-- Sélectionner un accompagnateur --</option>
                                                <!-- Populated by JS -->
                                            </select>
                                            <button type="button" id="add_agent_btn" class="btn btn-primary px-4">
                                                <i class="bi bi-plus-lg me-1"></i> Ajouter
                                            </button>
                                        </div>

                                        <div id="selected_agents_list"
                                            class="d-flex flex-wrap gap-2 p-3 bg-white border rounded-3"
                                            style="min-height: 80px;">
                                            <span class="text-muted w-100 text-center py-2" id="empty_list_msg">Aucun
                                                accompagnateur sélectionné</span>
                                            <!-- Badges will appear here -->
                                        </div>

                                        <!-- Hidden inputs for form submission -->
                                        <div id="hidden_agents_inputs"></div>

                                        <small class="text-muted mt-2 d-block">Sélectionnez les agents qui vous
                                            accompagnent pour cette mission.</small>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="premium-input-group mb-0">
                                        <label for="description" class="form-label"><i
                                                class="bi bi-card-text text-primary me-2"></i>Description /
                                            Objet</label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Détails de la mission...">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                                <a href="{{ route('dashboard') }}"
                                    class="btn btn-light btn-custom-cancel text-muted border">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-custom-save">
                                    <i class="bi bi-send-fill me-2"></i>Créer la Mission
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const agentSelect = document.getElementById('agent_select');
                const addBtn = document.getElementById('add_agent_btn');
                const listContainer = document.getElementById('selected_agents_list');
                const hiddenInputs = document.getElementById('hidden_agents_inputs');
                const agentCount = document.getElementById('agent_count');
                const emptyMsg = document.getElementById('empty_list_msg');

                let selectedAgents = new Set();
                let allAgents = [];

                // Load agents via API
                fetch("{{ route('api.accompagnateurs') }}")
                    .then(response => response.json())
                    .then(agents => {
                        allAgents = agents;
                        agents.forEach(agent => {
                            const option = document.createElement('option');
                            option.value = agent.id;
                            option.textContent = agent.name;
                            agentSelect.appendChild(option);
                        });

                        // Handle old values from validation errors
                        const oldAgents = @json(old('agents', []));
                        if (oldAgents && oldAgents.length > 0) {
                            oldAgents.forEach(id => {
                                const agent = allAgents.find(a => a.id == id);
                                if (agent) {
                                    addAgent(agent.id, agent.name);
                                }
                            });
                        }
                    });

                function updateUI() {
                    if (selectedAgents.size > 0) {
                        emptyMsg.style.display = 'none';
                    } else {
                        emptyMsg.style.display = 'block';
                    }
                    agentCount.textContent = selectedAgents.size;
                }

                function addAgent(id, name) {
                    if (!id || selectedAgents.has(id.toString())) return;

                    selectedAgents.add(id.toString());

                    // Add badge to UI
                    const badge = document.createElement('div');
                    badge.className = 'badge bg-primary d-flex align-items-center gap-2 p-2 px-3 rounded-pill shadow-sm';
                    badge.style.fontSize = '0.9rem';
                    badge.style.fontWeight = '500';
                    badge.innerHTML = `
                        <span>${name}</span>
                        <button type="button" class="btn-close btn-close-white" style="font-size: 0.55rem;" data-id="${id}"></button>
                    `;
                    listContainer.appendChild(badge);

                    // Add hidden input
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'agents[]';
                    input.value = id;
                    input.id = `input_agent_${id}`;
                    hiddenInputs.appendChild(input);

                    // Remove listener
                    badge.querySelector('.btn-close').addEventListener('click', function () {
                        const agentId = this.getAttribute('data-id');
                        selectedAgents.delete(agentId);
                        badge.remove();
                        const hiddenInp = document.getElementById(`input_agent_${agentId}`);
                        if (hiddenInp) hiddenInp.remove();
                        updateUI();
                    });

                    updateUI();
                }

                addBtn.addEventListener('click', function () {
                    const id = agentSelect.value;
                    const name = agentSelect.options[agentSelect.selectedIndex].text;
                    if (!id) return;
                    addAgent(id, name);
                    agentSelect.value = '';
                });
            });
        </script>
    @endpush
</x-app-layout>
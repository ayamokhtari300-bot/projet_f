<x-app-layout>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Annuler le soulignement par défaut de Bootstrap */
        a {
            text-decoration: none;
        }
        
        .mission-edit-wrapper {
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
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        .premium-input-group {
            background-color: #f9fafb;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid #f3f4f6;
        }
        .btn-custom-save {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-custom-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.4);
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
            {{ __('Editer Mission') }}
        </h2>
    </x-slot>

    <div class="mission-edit-wrapper container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="premium-form-card">
                    <div class="form-header-gradient d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold fs-4">
                            <i class="bi bi-pencil-square me-2"></i>Modification de la Mission
                        </h3>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('missions.update', $mission->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Type & Destination -->
                                <div class="col-md-6">
                                    <div class="premium-input-group h-100">
                                        <div class="mb-4">
                                            <label for="type_mission" class="form-label"><i class="bi bi-tag-fill text-primary me-2"></i>Type de Mission</label>
                                            <input type="text" name="type_mission" id="type_mission" value="{{ $mission->type_mission }}"
                                                   class="form-control" required>
                                        </div>
                                        <div>
                                            <label for="destination" class="form-label"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Destination</label>
                                            <input type="text" name="destination" id="destination" value="{{ $mission->destination }}"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="col-md-6">
                                    <div class="premium-input-group h-100">
                                        <div class="mb-4">
                                            <label for="date_aller" class="form-label"><i class="bi bi-calendar-event text-primary me-2"></i>Date Aller</label>
                                            <input type="date" name="date_aller" id="date_aller" value="{{ \Carbon\Carbon::parse($mission->date_aller)->format('Y-m-d') }}"
                                                   class="form-control" required>
                                        </div>
                                        <div>
                                            <label for="date_retour" class="form-label"><i class="bi bi-calendar-check text-primary me-2"></i>Date Retour</label>
                                            <input type="date" name="date_retour" id="date_retour" value="{{ \Carbon\Carbon::parse($mission->date_retour)->format('Y-m-d') }}"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accompagnateurs -->
                                <div class="col-12">
                                    <div class="premium-input-group">
                                        <label for="agents" class="form-label"><i class="bi bi-people-fill text-primary me-2"></i>Accompagnateurs</label>
                                        <select name="agents[]" id="agents" multiple class="form-select" style="height: 120px;">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $mission->agents->contains($user->id) ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="premium-input-group mb-0">
                                        <label for="description" class="form-label"><i class="bi bi-card-text text-primary me-2"></i>Description</label>
                                        <textarea name="description" id="description" rows="4"
                                                  class="form-control">{{ $mission->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                                <a href="{{ route('dashboard') }}" class="btn btn-light btn-custom-cancel text-muted border">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-custom-save">
                                    <i class="bi bi-check2-circle me-2"></i>Enregistrer les modifications
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
    @endpush
</x-app-layout>
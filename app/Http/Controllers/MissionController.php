<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Mission::with(['user', 'vehicule', 'agents'])->latest();
        
        if ($user->hasRole('agent')) {
            $query->where('user_id', $user->id);
        }

        $missions = $query->paginate(10);
        
        // On récupère aussi les véhicules si c'est un opérateur
        $vehicules = [];
        if ($user && $user->hasRole('operateur')) {
            $vehicules = Vehicule::all();
        }

        return view('missions.index', compact('missions', 'vehicules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $vehicules = Vehicule::all();
        $agents = User::all();

        return view('missions.create', compact('users', 'vehicules', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'date_aller' => 'required|date',
            'date_retour' => 'required|date|after_or_equal:date_aller',
            'type_mission' => 'required',
        ]);

        $mission = Mission::create([
            'type_mission' => $request->type_mission,
            'destination' => $request->destination,
            'description' => $request->description,
            'date_aller' => $request->date_aller,
            'date_retour' => $request->date_retour,
            'user_id' => auth()->id(), // ✅ هنا الحل
            'status' => 'en_attente',
        ]);

        // accompagnateurs
        if ($request->has('agents')) {
            foreach ($request->agents as $agentId) {
                $mission->agents()->attach($agentId, ['agent_type' => 'ac']);
            }
        }

        // Notifier tous les opérateurs
        $operateurs = User::role('operateur')->get();
        \Illuminate\Support\Facades\Notification::send($operateurs, new \App\Notifications\MissionSentToOperator($mission));

        return redirect()->route('dashboard')->with('success', 'Mission créée et envoyée à l\'opérateur.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mission $mission)
    {
        Gate::authorize('view', $mission);
        $mission->load(['user', 'vehicule', 'agents']);
        return view('missions.show', compact('mission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        Gate::authorize('update', $mission);

        $users = User::all();
        $vehicules = Vehicule::all();

        return view('missions.edit', compact('mission', 'users', 'vehicules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mission $mission)
    {
        Gate::authorize('update', $mission);

        $request->validate([
            'destination' => 'required',
            'date_aller' => 'required|date',
            'date_retour' => 'required|date|after_or_equal:date_aller',
        ]);

        $mission->update([
            'destination' => $request->destination,
            'date_aller' => $request->date_aller,
            'date_retour' => $request->date_retour,
            'user_id' => $request->user_id,
            'vehicule_id' => $request->vehicule_id,
        ]);

        // sync accompagnateurs
        $syncData = [];
        if ($request->has('agents') && is_array($request->agents)) {
            foreach ($request->agents as $agentId) {
                $syncData[$agentId] = ['agent_type' => 'ac'];
            }
        }
        $mission->agents()->sync($syncData);

        return redirect()->route('missions.index')->with('success', 'Mission mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        Gate::authorize('delete', $mission);

        $mission->delete();
        return redirect()->route('dashboard')->with('success', 'Mission supprimée avec succès.');
    }
    /**
     * Store a vehicle assignment by operateur.
     */
    public function affecter(Request $request, $id)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
        ]);

        $mission = Mission::findOrFail($id);
        $mission->vehicule_id = $request->vehicule_id;
        $mission->save();

        return redirect()->route('dashboard')->with('success', 'Véhicule affecté avec succès.');
    }

    /**
     * Update mission status by validateur.
     */
    public function decision(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:validee,refusee,en_attente',
        ]);

        $mission = Mission::findOrFail($id);
        $mission->status = $request->status;
        $mission->save();

        if (in_array($request->status, ['validee', 'refusee'])) {
            // Notifier les opérateurs
            $operateurs = User::role('operateur')->get();
            \Illuminate\Support\Facades\Notification::send($operateurs, new \App\Notifications\MissionValidatedNotification($mission));

            // Notifier l'agent (Propriétaire de la mission)
            if ($mission->user) {
                $mission->user->notify(new \App\Notifications\AgentNotifiedNotification($mission));
            }
        }

        return redirect()->route('dashboard')->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Notify agent about the final decision (Operator action).
     */
    public function notifyAgent($id)
    {
        $mission = Mission::findOrFail($id);
        
        if ($mission->user) {
            $mission->user->notify(new \App\Notifications\AgentNotifiedNotification($mission));
            return redirect()->route('dashboard')->with('success', 'L\'agent a été notifié de la décision finale.');
        }

        return redirect()->route('dashboard')->with('error', 'Impossible de trouver l\'agent pour le notifier.');
    }

    /**
     * Send mission to validateur (Operator action).
     */
    public function sendToValidateur($id)
    {
        $mission = Mission::findOrFail($id);
        
        if (!$mission->vehicule_id) {
            return redirect()->route('dashboard')->with('error', 'Veuillez affecter un véhicule avant d\'envoyer la mission.');
        }

        $mission->status = 'en_cours';
        $mission->save();

        // Notifier tous les validateurs
        $validateurs = User::role('validateur')->get();
        \Illuminate\Support\Facades\Notification::send($validateurs, new \App\Notifications\MissionSentToValidator($mission));

        return redirect()->route('dashboard')->with('success', 'Mission envoyée au validateur avec succès.');
    }

    /**
     * Get list of accompanists (agents) for dynamic select via API.
     */
    public function getAccompanists()
    {
        // On récupère les utilisateurs sauf l'utilisateur connecté (car il ne peut pas être son propre accompagnateur)
        $agents = User::where('id', '!=', auth()->id())
                      ->select('id', 'name')
                      ->get();
                      
        return response()->json($agents);
    }
}
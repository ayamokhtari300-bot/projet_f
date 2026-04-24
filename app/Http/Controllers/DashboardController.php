<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\Vehicule;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke()
    {
        $user = auth()->user();

        $query = Mission::with(['vehicule', 'user', 'agents'])->latest();
        
        if ($user->hasRole('agent')) {
            $query->where('user_id', $user->id);
        }

        // Les validateurs voient tout, pas besoin de filtre status != en_attente ici
        // On garde uniquement le limit pour le dashboard
        $missions = $query->limit(5)->get();
        
        $vehicules = [];
        if ($user && $user->hasRole('operateur')) {
            $vehicules = Vehicule::all();
        }

        // Statistiques
        if ($user->hasRole('agent')) {
            $totalMissions = Mission::where('user_id', $user->id)->count();
            $totalValidee  = Mission::where('user_id', $user->id)->where('status', 'validee')->count();
            $totalRefusee  = Mission::where('user_id', $user->id)->where('status', 'refusee')->count();
            $totalEnCours  = Mission::where('user_id', $user->id)->where(function($q) {
                $q->where('status', 'en_attente')->orWhere('status', 'en_cours');
            })->count();
        } else {
            $totalMissions = Mission::count();
            $totalValidee  = Mission::where('status', 'validee')->count();
            $totalRefusee  = Mission::where('status', 'refusee')->count();
            $totalEnCours  = Mission::where(function($q) {
                $q->where('status', 'en_attente')->orWhere('status', 'en_cours');
            })->count();
        }

        return view('dashboard', compact('missions', 'user', 'vehicules', 'totalMissions', 'totalValidee', 'totalRefusee', 'totalEnCours'));
    }
}


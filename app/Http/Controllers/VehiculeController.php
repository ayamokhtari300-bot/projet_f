<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::orderBy('id', 'desc')->paginate(10);
        return view('vehicules.index', compact('vehicules'));
    }

    public function toggleStatus(Vehicule $vehicule)
    {
        $vehicule->update([
            'disponibilite' => !$vehicule->disponibilite
        ]);

        return back()->with('success', 'Le statut du véhicule a été mis à jour avec succès.');
    }
}

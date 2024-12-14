<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;


class MatiereController extends Controller
{
    public function getMatieresByFiliere($filiereId)
    {
        // Récupérer les matières associées à la filière depuis la base de données
        $matieres = Subject::where('sector_id', $filiereId)->get();

        // Retourner les matières au format JSON
        return response()->json($matieres);
    }

}

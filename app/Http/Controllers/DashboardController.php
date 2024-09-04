<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function showContests(Request $request)
{
    // Récupère le dernier segment de l'URL après le "/"
    $segment = $request->segment(count($request->segments()));

    // Passez le segment à la vue
    return view('dashboard', compact('segment'));
}

    public function index()
    {
        $contests = Contest::all(); // Récupère tous les concours
        return view('dashboard', compact('contests')); // Passe les concours à la vue
    }
    public function amazon()
    {
        // Récupère les concours qui contiennent le mot "amazon" dans la description
        $contests = Contest::where('description', 'like', '%amazon%')->get();
    
        return view('dashboard', compact('contests')); // Passe les concours filtrés à la vue
    }
    
    public function apple()
    {
        // Récupère les concours qui contiennent le mot "amazon" dans la description
        $contests = Contest::where('description', 'like', '%apple%')->get();
    
        return view('dashboard', compact('contests')); // Passe les concours filtrés à la vue
    }
    public function greengo()
    {
        // Récupère les concours qui contiennent le mot "amazon" dans la description
        $contests = Contest::where('description', 'like', '%greengo%')->get();
    
        return view('dashboard', compact('contests')); // Passe les concours filtrés à la vue
    }
    
    
}

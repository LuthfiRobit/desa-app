<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        // Ambil agenda yang akan datang atau terbaru
        $agendas = Agenda::orderBy('event_date', 'asc')
                        ->paginate(10);
                        
        return view('landing.agenda', compact('agendas'));
    }
}

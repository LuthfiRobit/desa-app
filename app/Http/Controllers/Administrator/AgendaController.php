<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->has('range') && $request->range != '') {
            if ($request->range == 'bulan-ini') {
                $query->whereMonth('event_date', Carbon::now()->month)
                      ->whereYear('event_date', Carbon::now()->year);
            } elseif ($request->range == 'akan-datang') {
                $query->where('event_date', '>=', Carbon::now());
            } elseif ($request->range == 'sudah-lewat') {
                $query->where('event_date', '<', Carbon::now());
            }
        }

        $agendas = $query->orderBy('event_date', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('administrator.agenda.table', compact('agendas'))->render();
        }

        return view('administrator.agenda.index', compact('agendas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'event_date' => 'required',
            'location' => 'required|string|max:255',
        ], [
            'title.required' => 'Judul agenda wajib diisi.',
            'event_date.required' => 'Tanggal & waktu wajib diisi.',
            'location.required' => 'Lokasi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        Agenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => Carbon::parse($request->event_date),
            'location' => $request->location,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'event_date' => 'required',
            'location' => 'required|string|max:255',
        ], [
            'title.required' => 'Judul agenda wajib diisi.',
            'event_date.required' => 'Tanggal & waktu wajib diisi.',
            'location.required' => 'Lokasi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $agenda->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => Carbon::parse($request->event_date),
            'location' => $request->location,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil dihapus'
        ]);
    }
}

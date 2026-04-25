<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finance;
use Illuminate\Support\Facades\Validator;

class ApbdesController extends Controller
{
    public function index(Request $request)
    {
        // Get available years for filter
        $years = Finance::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        $currentYear = $request->year ?? ($years->first() ?? date('Y'));

        $query = Finance::where('year', $currentYear);

        // Summaries for cards
        $summary = [
            'pendapatan' => [
                'budget' => Finance::where('year', $currentYear)->where('type', 'income')->sum('budget_amount'),
                'realization' => Finance::where('year', $currentYear)->where('type', 'income')->sum('realized_amount'),
            ],
            'belanja' => [
                'budget' => Finance::where('year', $currentYear)->where('type', 'expense')->sum('budget_amount'),
                'realization' => Finance::where('year', $currentYear)->where('type', 'expense')->sum('realized_amount'),
            ],
            'pembiayaan' => [
                'budget' => Finance::where('year', $currentYear)->where('type', 'financing')->sum('budget_amount'),
                'realization' => Finance::where('year', $currentYear)->where('type', 'financing')->sum('realized_amount'),
            ]
        ];

        // Process filtering for the table
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $finances = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('administrator.apbdes.table', compact('finances'))->render(),
                'summary' => $summary,
                'chart_data' => [
                    'budget' => [$summary['pendapatan']['budget'], $summary['belanja']['budget'], $summary['pembiayaan']['budget']],
                    'realization' => [$summary['pendapatan']['realization'], $summary['belanja']['realization'], $summary['pembiayaan']['realization']]
                ]
            ]);
        }

        return view('administrator.apbdes.index', compact('finances', 'years', 'currentYear', 'summary'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer',
            'type' => 'required|string|in:income,expense,financing',
            'title' => 'required|string|max:255',
            'budget_amount' => 'required|numeric',
            'realized_amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        Finance::create([
            'year' => $request->year,
            'type' => $request->type,
            'title' => $request->title,
            'budget_amount' => $request->budget_amount,
            'realized_amount' => $request->realized_amount ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data APBDes berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $finance = Finance::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'year' => 'required|integer',
            'type' => 'required|string|in:income,expense,financing',
            'title' => 'required|string|max:255',
            'budget_amount' => 'required|numeric',
            'realized_amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $finance->update([
            'year' => $request->year,
            'type' => $request->type,
            'title' => $request->title,
            'budget_amount' => $request->budget_amount,
            'realized_amount' => $request->realized_amount ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data APBDes berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $finance = Finance::findOrFail($id);
        $finance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data APBDes berhasil dihapus'
        ]);
    }
}

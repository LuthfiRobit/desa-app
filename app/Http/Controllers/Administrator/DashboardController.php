<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Agenda;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Finance;
use App\Models\Profile;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil statistik sederhana untuk dashboard
        $stats = [
            'total_articles' => Article::where('is_published', true)->count(),
            'total_agendas'  => Agenda::count(),
            'total_documents' => Document::count(),
            'total_galleries' => Gallery::count(),
        ];

        // 2. Data APBDes untuk Chart (Tahun Terakhir)
        $latestYear = Finance::max('year') ?? date('Y');
        $financeData = Finance::where('year', $latestYear)->get();
        
        $chartData = [
            'year' => $latestYear,
            'income_budget' => $financeData->where('type', 'income')->sum('budget_amount'),
            'income_realized' => $financeData->where('type', 'income')->sum('realized_amount'),
            'expense_budget' => $financeData->where('type', 'expense')->sum('budget_amount'),
            'expense_realized' => $financeData->where('type', 'expense')->sum('realized_amount'),
            'financing_budget' => $financeData->where('type', 'financing')->sum('budget_amount'),
            'financing_realized' => $financeData->where('type', 'financing')->sum('realized_amount'),
        ];

        // 3. Info Desa
        $profile = Profile::first();

        // 4. Aktivitas Terbaru (Gabungan Berita, Agenda, Dokumen, Galeri)
        // Kita ambil 5 data terbaru dari masing-masing model dan gabungkan
        $recentArticles = Article::latest()->take(5)->get()->map(function($item) {
            return [
                'title' => $item->title,
                'type' => 'Berita',
                'badge' => 'bg-light-primary text-primary',
                'status' => $item->is_published ? 'Publik' : 'Draft',
                'status_class' => $item->is_published ? 'badge-published' : 'badge-draft',
                'date' => $item->created_at->format('d M Y'),
                'icon' => 'ti ti-news text-primary'
            ];
        });

        $recentAgendas = Agenda::latest()->take(5)->get()->map(function($item) {
            return [
                'title' => $item->title,
                'type' => 'Agenda',
                'badge' => 'bg-light-success text-success',
                'status' => 'Aktif',
                'status_class' => 'badge-active',
                'date' => $item->event_date->format('d M Y'),
                'icon' => 'ti ti-calendar-event text-success'
            ];
        });

        $recentDocs = Document::latest()->take(5)->get()->map(function($item) {
            return [
                'title' => $item->title,
                'type' => 'Dokumen',
                'badge' => 'bg-light-warning text-warning',
                'status' => 'Publik',
                'status_class' => 'badge-published',
                'date' => $item->created_at->format('d M Y'),
                'icon' => 'ti ti-file-description text-warning'
            ];
        });

        // Gabungkan dan urutkan berdasarkan tanggal (kita simulasikan urutan dengan merge sederhana dulu)
        $activities = $recentArticles->concat($recentAgendas)->concat($recentDocs)->sortByDesc(function($item) {
            return strtotime($item['date']);
        })->take(5);

        return view('administrator.dashboard.index', compact('stats', 'chartData', 'profile', 'activities'));
    }
}

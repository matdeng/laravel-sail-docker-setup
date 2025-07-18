<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckList;
use Illuminate\Support\Facades\File;

class CheckListController extends Controller
{
    public function index() {
        $checklists = CheckList::all();
        return view('checklist.index', compact('checklists'));
    }

    public function store(Request $request) {
        $items = Checklist::whereIn('id', $request->input('checklist', []))->get();

        // Save a summary JSON with count and checklist details
        $summary = [
            'completed_count' => $items->count(),
            'total_items' => Checklist::count(),
            'checked_items' => $items->pluck('item'),
            'timestamp' => now()->toDateTimeString(),
        ];

        File::put(storage_path('app/checklist.json'), json_encode($summary, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Checklist disahkan. Sedia untuk commit.');
    }
}


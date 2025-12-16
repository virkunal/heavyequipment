<?php

namespace App\Http\Controllers;

use App\Models\BoomLift;
use Illuminate\View\View;

class BoomLiftController extends Controller
{
    public function index(): View
    {
        $query = BoomLift::query()->where('is_available', true);

        if (request()->has('search') && request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $boomLifts = $query->latest()->paginate(12);

        return view('boom-lifts.index', compact('boomLifts'));
    }

    public function show(BoomLift $boomLift): View
    {
        if (!$boomLift->is_available) {
            abort(404);
        }

        return view('boom-lifts.show', compact('boomLift'));
    }

    public function quotation(BoomLift $boomLift): View
    {
        if (!$boomLift->is_available) {
            abort(404);
        }

        return view('boom-lifts.quotation', compact('boomLift'));
    }
}

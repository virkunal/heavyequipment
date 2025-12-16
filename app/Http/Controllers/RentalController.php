<?php

namespace App\Http\Controllers;

use App\Models\BoomLift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function create(BoomLift $boomLift): View
    {
        if (!$boomLift->is_available) {
            abort(404);
        }

        return view('rentals.create', compact('boomLift'));
    }

    public function store(Request $request, BoomLift $boomLift): RedirectResponse
    {
        if (!$boomLift->is_available) {
            abort(404);
        }

        $validated = $request->validate([
            'rental_type' => ['required', 'in:hourly,daily,monthly'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $rateField = $validated['rental_type'] . '_rate';
        $rate = $boomLift->$rateField;

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);

        $duration = match ($validated['rental_type']) {
            'hourly' => $startDate->diffInHours($endDate),
            'daily' => $startDate->diffInDays($endDate),
            'monthly' => $startDate->diffInMonths($endDate),
        };

        $totalAmount = $rate * $duration * $validated['quantity'];

        return redirect()->route('boom-lifts.index')
            ->with('success', "Rental request submitted. Total amount: ₹" . number_format($totalAmount, 2));
    }
}

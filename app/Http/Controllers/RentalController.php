<?php

namespace App\Http\Controllers;

use App\Models\BoomLift;
use App\Models\Rental;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function create(BoomLift $boomLift): View
    {
        if (! $boomLift->is_available) {
            abort(404);
        }

        return view('rentals.create', compact('boomLift'));
    }

    public function store(Request $request, BoomLift $boomLift): RedirectResponse
    {
        if (! $boomLift->is_available) {
            abort(404);
        }

        $validated = $request->validate([
            'rental_type' => ['required', 'in:hourly,daily,monthly'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $rateField = $validated['rental_type'].'_rate';
        $rate = $boomLift->$rateField;

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);

        $duration = match ($validated['rental_type']) {
            'hourly' => $startDate->diffInHours($endDate),
            'daily' => $startDate->diffInDays($endDate),
            'monthly' => $startDate->diffInMonths($endDate),
        };

        $totalAmount = $rate * $duration * $validated['quantity'];

        // Store rental request in database
        Rental::create([
            'boom_lift_id' => $boomLift->id,
            'user_id' => $request->user()->id,
            'rental_type' => $validated['rental_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'quantity' => $validated['quantity'],
            'rate' => $rate,
            'duration' => $duration,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('boom-lifts.index')
            ->with('success', 'Rental request submitted successfully. Total amount: ₹'.number_format($totalAmount, 2));
    }
}

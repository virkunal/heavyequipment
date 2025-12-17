<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function index(): View
    {
        $rentals = Rental::with(['boomLift', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.rentals.index', compact('rentals'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBoomLiftRequest;
use App\Http\Requests\Admin\UpdateBoomLiftRequest;
use App\Models\BoomLift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BoomLiftController extends Controller
{
    public function index(): View
    {
        $query = BoomLift::query();

        if (request()->has('search') && request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $boomLifts = $query->latest()->paginate(15)->withQueryString();

        return view('admin.boom-lifts.index', compact('boomLifts'));
    }

    public function create(): View
    {
        return view('admin.boom-lifts.create');
    }

    public function store(StoreBoomLiftRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('boom-lifts', 'public');
        }

        if (isset($validated['specifications'])) {
            $validated['specifications'] = array_filter($validated['specifications'], fn ($value) => ! empty($value));
            if (empty($validated['specifications'])) {
                $validated['specifications'] = null;
            }
        }

        $isAvailable = $request->has('is_available') && $request->input('is_available') == '1';
        $validated['is_available'] = $isAvailable;

        BoomLift::create($validated);

        return redirect()->route('admin.boom-lifts.index')
            ->with('success', 'Boom lift created successfully.');
    }

    public function show(BoomLift $boomLift): View
    {
        return view('admin.boom-lifts.show', compact('boomLift'));
    }

    public function edit(BoomLift $boomLift): View
    {
        return view('admin.boom-lifts.edit', compact('boomLift'));
    }

    public function update(UpdateBoomLiftRequest $request, BoomLift $boomLift): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($boomLift->image) {
                Storage::disk('public')->delete($boomLift->image);
            }
            $validated['image'] = $request->file('image')->store('boom-lifts', 'public');
        }

        if (isset($validated['specifications'])) {
            $validated['specifications'] = array_filter($validated['specifications'], fn ($value) => ! empty($value));
            if (empty($validated['specifications'])) {
                $validated['specifications'] = null;
            }
        }

        $isAvailable = $request->has('is_available') && $request->input('is_available') == '1';
        $validated['is_available'] = $isAvailable;

        $boomLift->update($validated);

        return redirect()->route('admin.boom-lifts.index')
            ->with('success', 'Boom lift updated successfully.');
    }

    public function destroy(BoomLift $boomLift): RedirectResponse
    {
        if ($boomLift->image) {
            Storage::disk('public')->delete($boomLift->image);
        }

        $boomLift->delete();

        return redirect()->route('admin.boom-lifts.index')
            ->with('success', 'Boom lift deleted successfully.');
    }
}

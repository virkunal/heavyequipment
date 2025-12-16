@extends('layouts.app')

@section('title', 'Rent Boom Lift')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('boom-lifts.show', $boomLift) }}" class="text-blue-600 hover:underline">← Back to Details</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Rent: {{ $boomLift->name }}</h1>

        <form method="POST" action="{{ route('rentals.store', $boomLift) }}">
            @csrf

            <div class="mb-4">
                <label for="rental_type" class="block text-gray-700 font-medium mb-2">Rental Type *</label>
                <select id="rental_type" name="rental_type" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rental_type') border-red-500 @enderror">
                    <option value="">Select rental type</option>
                    <option value="hourly" {{ old('rental_type') === 'hourly' ? 'selected' : '' }}>Hourly - ₹{{ number_format($boomLift->hourly_rate, 2) }}/hour</option>
                    <option value="daily" {{ old('rental_type') === 'daily' ? 'selected' : '' }}>Daily - ₹{{ number_format($boomLift->daily_rate, 2) }}/day</option>
                    <option value="monthly" {{ old('rental_type') === 'monthly' ? 'selected' : '' }}>Monthly - ₹{{ number_format($boomLift->monthly_rate, 2) }}/month</option>
                </select>
                @error('rental_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date *</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                    min="{{ date('Y-m-d') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-gray-700 font-medium mb-2">End Date *</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity *</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quantity') border-red-500 @enderror">
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Submit Rental Request
                </button>
                <a href="{{ route('boom-lifts.show', $boomLift) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


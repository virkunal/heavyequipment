@extends('layouts.app')

@section('title', 'Create Boom Lift')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.boom-lifts.index') }}" class="text-blue-600 hover:underline">← Back to List</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Create New Boom Lift</h1>

        <form method="POST" action="{{ route('admin.boom-lifts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="model" class="block text-gray-700 font-medium mb-2">Model</label>
                <input type="text" id="model" name="model" value="{{ old('model') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Specifications</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="max_height" class="block text-sm text-gray-600 mb-1">Max Height (ft)</label>
                        <input type="number" id="max_height" name="specifications[max_height]" value="{{ old('specifications.max_height') }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="platform_capacity" class="block text-sm text-gray-600 mb-1">Platform Capacity (Kg)</label>
                        <input type="number" id="platform_capacity" name="specifications[platform_capacity]" value="{{ old('specifications.platform_capacity') }}" step="1" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="outreach" class="block text-sm text-gray-600 mb-1">Outreach (ft)</label>
                        <input type="number" id="outreach" name="specifications[outreach]" value="{{ old('specifications.outreach') }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm text-gray-600 mb-1">Weight (Kg)</label>
                        <input type="text" id="weight" name="specifications[weight]" value="{{ old('specifications.weight') }}"
                            placeholder="e.g., 5,000 Kg"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Additional specifications can be added as needed.</p>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Image</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="hourly_rate" class="block text-gray-700 font-medium mb-2">Hourly Rate *</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" step="0.01" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hourly_rate') border-red-500 @enderror">
                    @error('hourly_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="daily_rate" class="block text-gray-700 font-medium mb-2">Daily Rate *</label>
                    <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" step="0.01" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('daily_rate') border-red-500 @enderror">
                    @error('daily_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="monthly_rate" class="block text-gray-700 font-medium mb-2">Monthly Rate *</label>
                    <input type="number" id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate') }}" step="0.01" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('monthly_rate') border-red-500 @enderror">
                    @error('monthly_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-700">Available for rent</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Create Boom Lift
                </button>
                <a href="{{ route('admin.boom-lifts.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


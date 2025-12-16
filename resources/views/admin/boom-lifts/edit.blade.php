@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Edit Boom Lift')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.boom-lifts.index') }}" class="text-blue-600 hover:underline">← Back to List</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Boom Lift</h1>

        <form method="POST" action="{{ route('admin.boom-lifts.update', $boomLift) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $boomLift->name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="model" class="block text-gray-700 font-medium mb-2">Model</label>
                <input type="text" id="model" name="model" value="{{ old('model', $boomLift->model) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $boomLift->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                <textarea id="address" name="address" rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror" placeholder="Address will be auto-filled when you select a location on the map">{{ old('address', $boomLift->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Select Location on Map <small class="text-gray-500">(Click on the map to set location)</small></label>
                <div id="editPageMap" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="latitude" class="block text-gray-700 font-medium mb-2">Latitude</label>
                    <input type="number" id="latitude" name="latitude" value="{{ old('latitude', $boomLift->latitude) }}" step="0.00000001" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('latitude') border-red-500 @enderror" placeholder="Click on map to set">
                    @error('latitude')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <small class="text-gray-500 text-xs">Range: -90 to 90 (Set by clicking on map)</small>
                </div>
                <div>
                    <label for="longitude" class="block text-gray-700 font-medium mb-2">Longitude</label>
                    <input type="number" id="longitude" name="longitude" value="{{ old('longitude', $boomLift->longitude) }}" step="0.00000001" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('longitude') border-red-500 @enderror" placeholder="Click on map to set">
                    @error('longitude')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <small class="text-gray-500 text-xs">Range: -180 to 180 (Set by clicking on map)</small>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Specifications</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="max_height" class="block text-sm text-gray-600 mb-1">Max Height (ft)</label>
                        <input type="number" id="max_height" name="specifications[max_height]" value="{{ old('specifications.max_height', $boomLift->specifications['max_height'] ?? '') }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="platform_capacity" class="block text-sm text-gray-600 mb-1">Platform Capacity (Kg)</label>
                        <input type="number" id="platform_capacity" name="specifications[platform_capacity]" value="{{ old('specifications.platform_capacity', $boomLift->specifications['platform_capacity'] ?? '') }}" step="1" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="outreach" class="block text-sm text-gray-600 mb-1">Outreach (ft)</label>
                        <input type="number" id="outreach" name="specifications[outreach]" value="{{ old('specifications.outreach', $boomLift->specifications['outreach'] ?? '') }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm text-gray-600 mb-1">Weight (Kg)</label>
                        <input type="text" id="weight" name="specifications[weight]" value="{{ old('specifications.weight', $boomLift->specifications['weight'] ?? '') }}"
                            placeholder="e.g., 5,000 Kg"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Additional specifications can be added as needed.</p>
            </div>

            @if($boomLift->image)
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Current Image</label>
                    <img src="{{ Storage::url($boomLift->image) }}" alt="{{ $boomLift->name }}" class="h-32 w-32 object-cover rounded">
                </div>
            @endif

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">New Image (leave empty to keep current)</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="hourly_rate" class="block text-gray-700 font-medium mb-2">Hourly Rate *</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $boomLift->hourly_rate) }}" step="0.01" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hourly_rate') border-red-500 @enderror">
                    @error('hourly_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="daily_rate" class="block text-gray-700 font-medium mb-2">Daily Rate *</label>
                    <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $boomLift->daily_rate) }}" step="0.01" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('daily_rate') border-red-500 @enderror">
                    @error('daily_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="monthly_rate" class="block text-gray-700 font-medium mb-2">Monthly Rate *</label>
                    <input type="number" id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate', $boomLift->monthly_rate) }}" step="0.01" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('monthly_rate') border-red-500 @enderror">
                    @error('monthly_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', $boomLift->is_available) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-700">Available for rent</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" style="background-color: #2563eb; color: white; border: none; padding: 8px 24px; border-radius: 6px;" class="hover:bg-blue-700 font-medium shadow-md text-white">
                    Update Boom Lift
                </button>
                <a href="{{ route('admin.boom-lifts.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key', 'YOUR_API_KEY') }}&libraries=places"></script>
<script>
let editPageMap;
let editPageMarker;
let editPageGeocoder;

function initEditPageMap() {
    const mapElement = document.getElementById('editPageMap');
    if (!mapElement) {
        console.error('Map element not found');
        return;
    }
    
    if (typeof google === 'undefined' || !google.maps) {
        console.error('Google Maps API is not loaded');
        return;
    }
    
    // Prevent re-initialization
    if (editPageMap) {
        return;
    }
    
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const defaultLat = parseFloat(latInput.value) || 40.7128;
    const defaultLng = parseFloat(lngInput.value) || -74.0060;
    
    editPageMap = new google.maps.Map(mapElement, {
        center: { lat: defaultLat, lng: defaultLng },
        zoom: 10
    });

    editPageGeocoder = new google.maps.Geocoder();

    // Set initial marker if coordinates exist
    if (latInput.value && lngInput.value) {
        editPageMarker = new google.maps.Marker({
            position: { lat: defaultLat, lng: defaultLng },
            map: editPageMap,
            draggable: true
        });
        google.maps.event.addListener(editPageMarker, 'dragend', (event) => {
            const dragLat = event.latLng.lat();
            const dragLng = event.latLng.lng();
            updateEditPageCoordinates({ lat: dragLat, lng: dragLng });
            reverseGeocodeEditPage({ lat: dragLat, lng: dragLng });
        });
    }

    // Click event to place marker
    editPageMap.addListener('click', (event) => {
        const clickLat = event.latLng.lat();
        const clickLng = event.latLng.lng();
        
        if (editPageMarker) {
            editPageMarker.setPosition({ lat: clickLat, lng: clickLng });
        } else {
            editPageMarker = new google.maps.Marker({
                position: { lat: clickLat, lng: clickLng },
                map: editPageMap,
                draggable: true
            });
            google.maps.event.addListener(editPageMarker, 'dragend', (event) => {
                const dragLat = event.latLng.lat();
                const dragLng = event.latLng.lng();
                updateEditPageCoordinates({ lat: dragLat, lng: dragLng });
                reverseGeocodeEditPage({ lat: dragLat, lng: dragLng });
            });
        }
        
        updateEditPageCoordinates({ lat: clickLat, lng: clickLng });
        reverseGeocodeEditPage({ lat: clickLat, lng: clickLng });
    });
}

function updateEditPageCoordinates(position) {
    const lat = typeof position.lat === 'function' ? position.lat() : position.lat;
    const lng = typeof position.lng === 'function' ? position.lng() : position.lng;
    
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
}

function reverseGeocodeEditPage(location) {
    if (!editPageGeocoder) {
        editPageGeocoder = new google.maps.Geocoder();
    }
    editPageGeocoder.geocode({ location: location }, (results, status) => {
        if (status === 'OK' && results[0]) {
            document.getElementById('address').value = results[0].formatted_address;
        }
    });
}

// Initialize map when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Google Maps API to be ready
    function initMapWhenReady() {
        if (typeof google !== 'undefined' && google.maps) {
            initEditPageMap();
        } else {
            // Retry after a short delay
            setTimeout(initMapWhenReady, 100);
        }
    }
    
    // Start initialization with a small delay to ensure API is loaded
    setTimeout(initMapWhenReady, 500);
});
</script>
@endpush
@endsection


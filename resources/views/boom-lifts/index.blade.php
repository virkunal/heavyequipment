@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

@section('title', 'Browse Boom Lifts')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h2 mb-4">Boom Lifts</h1>
        
        <form method="GET" action="{{ route('boom-lifts.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search boom lifts..." 
                    class="form-control">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    @if($boomLifts->count() > 0)
        <div class="row g-4">
            @foreach($boomLifts as $boomLift)
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="row g-0">
                            <!-- Image Column -->
                            <div class="col-md-4 bg-light">
                                @if($boomLift->image)
                                    <img src="{{ Storage::url($boomLift->image) }}" alt="{{ $boomLift->name }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 350px;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light" style="min-height: 350px;">
                                        <span class="text-muted">No Image Available</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Details Column -->
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h3 class="card-title h4 mb-3">{{ $boomLift->name }}</h3>
                                    
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            @if($boomLift->model)
                                                <p class="text-muted mb-2"><strong>Model:</strong> {{ $boomLift->model }}</p>
                                            @endif
                                            
                                            @if($boomLift->description)
                                                <div class="mb-3">
                                                    <p class="text-muted mb-1 small"><strong>Description:</strong></p>
                                                    <p class="text-muted mb-0 small">{{ Str::limit($boomLift->description, 150) }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($boomLift->specifications)
                                                <div class="mb-3">
                                                    <h5 class="h6 text-dark mb-2">Specifications:</h5>
                                                    <ul class="list-unstyled small text-muted mb-0">
                                                        @foreach($boomLift->specifications as $key => $value)
                                                            <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            
                                            <div class="mb-3">
                                                <span class="small fw-bold text-dark">Status: </span>
                                                @if($boomLift->is_available)
                                                    <span class="badge bg-success">Available</span>
                                                @else
                                                    <span class="badge bg-danger">Unavailable</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            @if($boomLift->address)
                                                <div class="mb-3">
                                                    <p class="text-muted mb-1 small"><strong><i class="fas fa-map-marker-alt"></i> Address:</strong></p>
                                                    <p class="text-muted mb-0 small">{{ $boomLift->address }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($boomLift->latitude && $boomLift->longitude)
                                                <div class="mb-3">
                                                    <p class="text-muted mb-2 small"><strong><i class="fas fa-map"></i> Location:</strong></p>
                                                    <div id="map-{{ $boomLift->id }}" style="height: 200px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>
                                                    <a href="https://www.google.com/maps?q={{ $boomLift->latitude }},{{ $boomLift->longitude }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                        <i class="fas fa-external-link-alt"></i> Open in Google Maps
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Rental Rates -->
                                    <div class="mb-4 mt-3">
                                        <h5 class="h6 mb-3">Rental Rates</h5>
                                        <div class="row g-2">
                                            <!-- Hourly Rate -->
                                            <div class="col-4">
                                                <div class="bg-info bg-opacity-10 rounded p-3 border border-info border-opacity-25">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="far fa-clock text-info me-2"></i>
                                                        <span class="small fw-medium text-info">Hourly</span>
                                                    </div>
                                                    <p class="h5 fw-bold text-info mb-0">₹{{ number_format($boomLift->hourly_rate, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Daily Rate -->
                                            <div class="col-4">
                                                <div class="bg-success bg-opacity-10 rounded p-3 border border-success border-opacity-25">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="far fa-calendar-day text-success me-2"></i>
                                                        <span class="small fw-medium text-success">Daily</span>
                                                    </div>
                                                    <p class="h5 fw-bold text-success mb-0">₹{{ number_format($boomLift->daily_rate, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Monthly Rate -->
                                            <div class="col-4">
                                                <div class="bg-warning bg-opacity-10 rounded p-3 border border-warning border-opacity-25">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="far fa-calendar text-warning me-2"></i>
                                                        <span class="small fw-medium text-warning">Monthly</span>
                                                    </div>
                                                    <p class="h5 fw-bold text-warning mb-0">₹{{ number_format($boomLift->monthly_rate, 2) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <div>
                                        <a href="{{ route('boom-lifts.quotation', $boomLift) }}" 
                                            class="btn btn-primary w-100">
                                            <i class="fas fa-calculator"></i> Get Quotation
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $boomLifts->links() }}
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">No boom lifts found.</p>
            </div>
        </div>
    @endif
</div>

@if($boomLifts->count() > 0)
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key', 'YOUR_API_KEY') }}&libraries=places"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function initMaps() {
        if (typeof google === 'undefined' || !google.maps) {
            setTimeout(initMaps, 100);
            return;
        }
        
        @foreach($boomLifts as $boomLift)
            @if($boomLift->latitude && $boomLift->longitude)
                (function() {
                    const mapElement{{ $boomLift->id }} = document.getElementById('map-{{ $boomLift->id }}');
                    if (mapElement{{ $boomLift->id }}) {
                        const map{{ $boomLift->id }} = new google.maps.Map(mapElement{{ $boomLift->id }}, {
                            center: { lat: {{ $boomLift->latitude }}, lng: {{ $boomLift->longitude }} },
                            zoom: 15,
                            mapTypeId: 'roadmap'
                        });
                        
                        const marker{{ $boomLift->id }} = new google.maps.Marker({
                            position: { lat: {{ $boomLift->latitude }}, lng: {{ $boomLift->longitude }} },
                            map: map{{ $boomLift->id }},
                            title: '{{ addslashes($boomLift->name) }}'
                        });
                    }
                })();
            @endif
        @endforeach
    }
    
    setTimeout(initMaps, 500);
});
</script>
@endpush
@endif
@endsection


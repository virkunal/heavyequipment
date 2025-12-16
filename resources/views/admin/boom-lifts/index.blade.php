@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Admin - Boom Lifts')
@section('page_title', 'Manage Boom Lifts')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.boom-lifts.index') }}">Boom Lifts</a></li>
<li class="breadcrumb-item active">List</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Boom Lifts List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus"></i> Add New Record
                    </button>
                </div>
            </div>
            <!-- Search Form -->
            <div class="card-body border-bottom">
                <form method="GET" action="{{ route('admin.boom-lifts.index') }}" class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by name, model, or description..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.boom-lifts.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        @if(request('search'))
                            <small class="text-muted d-block mt-2">
                                Found: {{ $boomLifts->total() }} result(s)
                            </small>
                        @endif
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                @if($boomLifts->count() > 0)
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Hourly Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boomLifts as $boomLift)
                                <tr>
                                    <td>
                                        @if($boomLift->image)
                                            <img src="{{ Storage::url($boomLift->image) }}" alt="{{ $boomLift->name }}" style="width: 50px; height: 50px;" class="img-circle">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $boomLift->name }}</td>
                                    <td>{{ $boomLift->model ?? 'N/A' }}</td>
                                    <td>₹{{ number_format($boomLift->hourly_rate, 2) }}</td>
                                    <td>
                                        @if($boomLift->is_available)
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Unavailable</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.boom-lifts.show', $boomLift) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <button type="button" 
                                            class="btn btn-primary btn-sm edit-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal"
                                            data-id="{{ $boomLift->id }}"
                                            data-name="{{ $boomLift->name }}"
                                            data-model="{{ $boomLift->model ?? '' }}"
                                            data-description="{{ $boomLift->description ?? '' }}"
                                            data-address="{{ $boomLift->address ?? '' }}"
                                            data-latitude="{{ $boomLift->latitude ?? '' }}"
                                            data-longitude="{{ $boomLift->longitude ?? '' }}"
                                            data-specifications="{{ json_encode($boomLift->specifications ?? []) }}"
                                            data-hourly-rate="{{ $boomLift->hourly_rate }}"
                                            data-daily-rate="{{ $boomLift->daily_rate }}"
                                            data-monthly-rate="{{ $boomLift->monthly_rate }}"
                                            data-is-available="{{ $boomLift->is_available ? '1' : '0' }}"
                                            data-image-url="{{ $boomLift->image ? Storage::url($boomLift->image) : '' }}"
                                            data-update-url="{{ route('admin.boom-lifts.update', $boomLift) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.boom-lifts.destroy', $boomLift) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this boom lift?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center">
                        <p class="text-muted">No boom lifts found.</p>
                    </div>
                @endif
            </div>
            <!-- /.card-body -->
            @if($boomLifts->hasPages())
                <div class="card-footer">
                    {{ $boomLifts->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
        <!-- /.card -->
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add New Boom Lift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <form method="POST" action="{{ route('admin.boom-lifts.store') }}" enctype="multipart/form-data" id="createForm">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="modal_name" class="form-label">Name *</label>
                        <input type="text" id="modal_name" name="name" value="{{ old('name') }}" required
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="modal_model" class="form-label">Model</label>
                        <input type="text" id="modal_model" name="model" value="{{ old('model') }}"
                            class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="modal_description" class="form-label">Description</label>
                        <textarea id="modal_description" name="description" rows="3"
                            class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="modal_address" class="form-label">Address</label>
                        <textarea id="modal_address" name="address" rows="2"
                            class="form-control @error('address') is-invalid @enderror" placeholder="Address will be auto-filled when you select a location on the map">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Select Location on Map <small class="text-muted">(Click on the map to set location)</small></label>
                        <div id="createMap" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="modal_latitude" class="form-label">Latitude</label>
                        <input type="number" id="modal_latitude" name="latitude" value="{{ old('latitude') }}" step="0.00000001" readonly
                            class="form-control @error('latitude') is-invalid @enderror" placeholder="Click on map to set">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Range: -90 to 90 (Set by clicking on map)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="modal_longitude" class="form-label">Longitude</label>
                        <input type="number" id="modal_longitude" name="longitude" value="{{ old('longitude') }}" step="0.00000001" readonly
                            class="form-control @error('longitude') is-invalid @enderror" placeholder="Click on map to set">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Range: -180 to 180 (Set by clicking on map)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Specifications</label>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="modal_max_height" class="form-label small">Max Height (ft)</label>
                                <input type="number" id="modal_max_height" name="specifications[max_height]" value="{{ old('specifications.max_height') }}" step="0.01" min="0"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="modal_platform_capacity" class="form-label small">Platform Capacity (Kg)</label>
                                <input type="number" id="modal_platform_capacity" name="specifications[platform_capacity]" value="{{ old('specifications.platform_capacity') }}" step="1" min="0"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="modal_outreach" class="form-label small">Outreach (ft)</label>
                                <input type="number" id="modal_outreach" name="specifications[outreach]" value="{{ old('specifications.outreach') }}" step="0.01" min="0"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="modal_weight" class="form-label small">Weight (Kg)</label>
                                <input type="text" id="modal_weight" name="specifications[weight]" value="{{ old('specifications.weight') }}"
                                    placeholder="e.g., 5,000 Kg"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="modal_image" class="form-label">Image</label>
                        <input type="file" id="modal_image" name="image" accept="image/*"
                            class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_available" value="1" class="form-check-input" id="modal_is_available" checked>
                            <label class="form-check-label" for="modal_is_available">
                                Available for rent
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="modal_hourly_rate" class="form-label">Hourly Rate *</label>
                        <input type="number" id="modal_hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" step="0.01" min="0" required
                            class="form-control @error('hourly_rate') is-invalid @enderror">
                        @error('hourly_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="modal_daily_rate" class="form-label">Daily Rate *</label>
                        <input type="number" id="modal_daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" step="0.01" min="0" required
                            class="form-control @error('daily_rate') is-invalid @enderror">
                        @error('daily_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="modal_monthly_rate" class="form-label">Monthly Rate *</label>
                        <input type="number" id="modal_monthly_rate" name="monthly_rate" value="{{ old('monthly_rate') }}" step="0.01" min="0" required
                            class="form-control @error('monthly_rate') is-invalid @enderror">
                        @error('monthly_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Boom Lift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <form method="POST" action="" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_boom_lift_id" name="boom_lift_id" value="{{ old('boom_lift_id', '') }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name *</label>
                                <input type="text" id="edit_name" name="name" value="{{ old('name') }}" required
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_model" class="form-label">Model</label>
                                <input type="text" id="edit_model" name="model" value="{{ old('model') }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description</label>
                                <textarea id="edit_description" name="description" rows="3"
                                    class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_address" class="form-label">Address</label>
                                <textarea id="edit_address" name="address" rows="2"
                                    class="form-control @error('address') is-invalid @enderror" placeholder="Address will be auto-filled when you select a location on the map">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Location on Map <small class="text-muted">(Click on the map to set location)</small></label>
                        <div id="editMap" style="height: 300px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_latitude" class="form-label">Latitude</label>
                                <input type="number" id="edit_latitude" name="latitude" value="{{ old('latitude') }}" step="0.00000001" readonly
                                    class="form-control @error('latitude') is-invalid @enderror" placeholder="Click on map to set">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Range: -90 to 90</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_longitude" class="form-label">Longitude</label>
                                <input type="number" id="edit_longitude" name="longitude" value="{{ old('longitude') }}" step="0.00000001" readonly
                                    class="form-control @error('longitude') is-invalid @enderror" placeholder="Click on map to set">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Range: -180 to 180</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Specifications</label>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label for="edit_max_height" class="form-label small">Max Height (ft)</label>
                                        <input type="number" id="edit_max_height" name="specifications[max_height]" value="{{ old('specifications.max_height') }}" step="0.01" min="0"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="edit_platform_capacity" class="form-label small">Platform Capacity (Kg)</label>
                                        <input type="number" id="edit_platform_capacity" name="specifications[platform_capacity]" value="{{ old('specifications.platform_capacity') }}" step="1" min="0"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="edit_outreach" class="form-label small">Outreach (ft)</label>
                                        <input type="number" id="edit_outreach" name="specifications[outreach]" value="{{ old('specifications.outreach') }}" step="0.01" min="0"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="edit_weight" class="form-label small">Weight (Kg)</label>
                                        <input type="text" id="edit_weight" name="specifications[weight]" value="{{ old('specifications.weight') }}"
                                            placeholder="e.g., 5,000 Kg"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div id="edit_current_image_container" class="mb-3" style="display: none;">
                                    <label class="form-label">Current Image</label>
                                    <img id="edit_current_image" src="" alt="Current image" class="img-thumbnail" style="max-height: 128px;">
                                </div>
                                <label for="edit_image" class="form-label">New Image (leave empty to keep current)</label>
                                <input type="file" id="edit_image" name="image" accept="image/*"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" id="edit_is_available" name="is_available" value="1" class="form-check-input" {{ old('is_available', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_is_available">
                                        Available for rent
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_hourly_rate" class="form-label">Hourly Rate *</label>
                                <input type="number" id="edit_hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" step="0.01" min="0" required
                                    class="form-control @error('hourly_rate') is-invalid @enderror">
                                @error('hourly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_daily_rate" class="form-label">Daily Rate *</label>
                                <input type="number" id="edit_daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" step="0.01" min="0" required
                                    class="form-control @error('daily_rate') is-invalid @enderror">
                                @error('daily_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_monthly_rate" class="form-label">Monthly Rate *</label>
                                <input type="number" id="edit_monthly_rate" name="monthly_rate" value="{{ old('monthly_rate') }}" step="0.01" min="0" required
                                    class="form-control @error('monthly_rate') is-invalid @enderror">
                                @error('monthly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editForm" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key', 'YOUR_API_KEY') }}&libraries=places"></script>
<script>
let createMap, editMap;
let createMarker, editMarker;
let createGeocoder;
let editGeocoder;

// Initialize Create Map
function initCreateMap() {
    const latInput = document.getElementById('modal_latitude');
    const lngInput = document.getElementById('modal_longitude');
    const defaultLat = parseFloat(latInput.value) || 40.7128;
    const defaultLng = parseFloat(lngInput.value) || -74.0060;
    
    createMap = new google.maps.Map(document.getElementById('createMap'), {
        center: { lat: defaultLat, lng: defaultLng },
        zoom: 10
    });

    createGeocoder = new google.maps.Geocoder();

    // Set initial marker if coordinates exist
    if (latInput.value && lngInput.value) {
        createMarker = new google.maps.Marker({
            position: { lat: defaultLat, lng: defaultLng },
            map: createMap,
            draggable: true
        });
        google.maps.event.addListener(createMarker, 'dragend', (event) => {
            const dragLat = event.latLng.lat();
            const dragLng = event.latLng.lng();
            updateCreateCoordinates({ lat: dragLat, lng: dragLng });
            reverseGeocodeCreate({ lat: dragLat, lng: dragLng });
        });
    }

    // Click event to place marker
    createMap.addListener('click', (event) => {
        const clickLat = event.latLng.lat();
        const clickLng = event.latLng.lng();
        
        if (createMarker) {
            createMarker.setPosition({ lat: clickLat, lng: clickLng });
        } else {
            createMarker = new google.maps.Marker({
                position: { lat: clickLat, lng: clickLng },
                map: createMap,
                draggable: true
            });
            google.maps.event.addListener(createMarker, 'dragend', (event) => {
                const dragLat = event.latLng.lat();
                const dragLng = event.latLng.lng();
                updateCreateCoordinates({ lat: dragLat, lng: dragLng });
                reverseGeocodeCreate({ lat: dragLat, lng: dragLng });
            });
        }
        
        updateCreateCoordinates({ lat: clickLat, lng: clickLng });
        reverseGeocodeCreate({ lat: clickLat, lng: clickLng });
    });
}

function updateCreateCoordinates(position) {
    const lat = typeof position.lat === 'function' ? position.lat() : position.lat;
    const lng = typeof position.lng === 'function' ? position.lng() : position.lng;
    document.getElementById('modal_latitude').value = lat.toFixed(8);
    document.getElementById('modal_longitude').value = lng.toFixed(8);
}

function reverseGeocodeCreate(location) {
    createGeocoder.geocode({ location: location }, (results, status) => {
        if (status === 'OK' && results[0]) {
            document.getElementById('modal_address').value = results[0].formatted_address;
        }
    });
}

// Initialize Edit Map
function initEditMap(lat = null, lng = null) {
    const mapElement = document.getElementById('editMap');
    if (!mapElement) {
        console.error('Edit map element not found');
        return;
    }
    
    const latInput = document.getElementById('edit_latitude');
    const lngInput = document.getElementById('edit_longitude');
    const defaultLat = lat !== null ? lat : (parseFloat(latInput.value) || 40.7128);
    const defaultLng = lng !== null ? lng : (parseFloat(lngInput.value) || -74.0060);
    
    if (editMap) {
        // Map already exists, just update center and marker
        if (!editGeocoder) {
            editGeocoder = new google.maps.Geocoder();
        }
        editMap.setCenter({ lat: defaultLat, lng: defaultLng });
        if (editMarker) {
            editMarker.setPosition({ lat: defaultLat, lng: defaultLng });
        } else if (latInput.value && lngInput.value) {
            editMarker = new google.maps.Marker({
                position: { lat: defaultLat, lng: defaultLng },
                map: editMap,
                draggable: true
            });
            google.maps.event.addListener(editMarker, 'dragend', (event) => {
                const dragLat = event.latLng.lat();
                const dragLng = event.latLng.lng();
                updateEditCoordinates({ lat: dragLat, lng: dragLng });
                reverseGeocodeEdit({ lat: dragLat, lng: dragLng });
            });
        }
        return;
    }
    
    editMap = new google.maps.Map(mapElement, {
        center: { lat: defaultLat, lng: defaultLng },
        zoom: 10
    });

    editGeocoder = new google.maps.Geocoder();

    // Set initial marker if coordinates exist
    if (latInput.value && lngInput.value) {
        editMarker = new google.maps.Marker({
            position: { lat: defaultLat, lng: defaultLng },
            map: editMap,
            draggable: true
        });
        google.maps.event.addListener(editMarker, 'dragend', (event) => {
            const dragLat = event.latLng.lat();
            const dragLng = event.latLng.lng();
            updateEditCoordinates({ lat: dragLat, lng: dragLng });
            reverseGeocodeEdit({ lat: dragLat, lng: dragLng });
        });
    }

    // Click event to place marker
    editMap.addListener('click', (event) => {
        const clickLat = event.latLng.lat();
        const clickLng = event.latLng.lng();
        
        if (editMarker) {
            editMarker.setPosition({ lat: clickLat, lng: clickLng });
        } else {
            editMarker = new google.maps.Marker({
                position: { lat: clickLat, lng: clickLng },
                map: editMap,
                draggable: true
            });
            google.maps.event.addListener(editMarker, 'dragend', (event) => {
                const dragLat = event.latLng.lat();
                const dragLng = event.latLng.lng();
                updateEditCoordinates({ lat: dragLat, lng: dragLng });
                reverseGeocodeEdit({ lat: dragLat, lng: dragLng });
            });
        }
        
        updateEditCoordinates({ lat: clickLat, lng: clickLng });
        reverseGeocodeEdit({ lat: clickLat, lng: clickLng });
    });
}

function updateEditCoordinates(position) {
    const lat = typeof position.lat === 'function' ? position.lat() : position.lat;
    const lng = typeof position.lng === 'function' ? position.lng() : position.lng;
    
    document.getElementById('edit_latitude').value = lat.toFixed(8);
    document.getElementById('edit_longitude').value = lng.toFixed(8);
}

function reverseGeocodeEdit(location) {
    editGeocoder.geocode({ location: location }, (results, status) => {
        if (status === 'OK' && results[0]) {
            document.getElementById('edit_address').value = results[0].formatted_address;
        }
    });
}

// Initialize maps when modals are shown
document.addEventListener('DOMContentLoaded', function() {
    const createModal = document.getElementById('createModal');
    const editModal = document.getElementById('editModal');

    createModal.addEventListener('shown.bs.modal', function() {
        if (!createMap) {
            setTimeout(() => initCreateMap(), 100);
        }
    });

    editModal.addEventListener('shown.bs.modal', function() {
        // Wait a bit for modal to be fully rendered
        setTimeout(() => {
            const latInput = document.getElementById('edit_latitude');
            const lngInput = document.getElementById('edit_longitude');
            const lat = latInput && latInput.value ? parseFloat(latInput.value) : null;
            const lng = lngInput && lngInput.value ? parseFloat(lngInput.value) : null;
            
            initEditMap(lat, lng);
        }, 300);
    });
});

// Reset form when create modal is closed
document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('createForm').reset();
});

// Auto-open create modal if there are validation errors (for create)
@if($errors->any() && !session('success') && request()->method() === 'POST' && !old('boom_lift_id'))
    document.addEventListener('DOMContentLoaded', function() {
        var createModal = new bootstrap.Modal(document.getElementById('createModal'));
        createModal.show();
    });
@endif

// Auto-open edit modal if there are validation errors (for edit)
@if($errors->any() && old('boom_lift_id'))
    document.addEventListener('DOMContentLoaded', function() {
        const editingId = {{ old('boom_lift_id', 0) }};
        if (editingId) {
            const editButton = document.querySelector(`.edit-btn[data-id="${editingId}"]`);
            if (editButton) {
                editButton.click();
            }
        }
    });
@endif

// Handle edit button click
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editModal');
    
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const form = document.getElementById('editForm');
            const specifications = JSON.parse(button.getAttribute('data-specifications') || '{}');
            
            // Set form action and boom lift ID
            form.action = button.getAttribute('data-update-url');
            const boomLiftId = button.getAttribute('data-id');
            document.getElementById('edit_boom_lift_id').value = boomLiftId;
            
            // Only populate from button data if fields don't already have values (from old() on validation errors)
            const nameField = document.getElementById('edit_name');
            if (!nameField.value) {
                // Populate form fields from button data
                nameField.value = button.getAttribute('data-name') || '';
                document.getElementById('edit_model').value = button.getAttribute('data-model') || '';
                document.getElementById('edit_description').value = button.getAttribute('data-description') || '';
                document.getElementById('edit_address').value = button.getAttribute('data-address') || '';
                const editLat = button.getAttribute('data-latitude') || '';
                const editLng = button.getAttribute('data-longitude') || '';
                document.getElementById('edit_latitude').value = editLat;
                document.getElementById('edit_longitude').value = editLng;
                document.getElementById('edit_hourly_rate').value = button.getAttribute('data-hourly-rate') || '';
                document.getElementById('edit_daily_rate').value = button.getAttribute('data-daily-rate') || '';
                document.getElementById('edit_monthly_rate').value = button.getAttribute('data-monthly-rate') || '';
                
                // Set specifications
                document.getElementById('edit_max_height').value = specifications.max_height || '';
                document.getElementById('edit_platform_capacity').value = specifications.platform_capacity || '';
                document.getElementById('edit_outreach').value = specifications.outreach || '';
                document.getElementById('edit_weight').value = specifications.weight || '';
                
                // Set availability checkbox
                document.getElementById('edit_is_available').checked = button.getAttribute('data-is-available') === '1';
            }
            
            // Set current image if exists
            const imageUrl = button.getAttribute('data-image-url');
            const currentImageContainer = document.getElementById('edit_current_image_container');
            const currentImage = document.getElementById('edit_current_image');
            if (imageUrl) {
                currentImage.src = imageUrl;
                currentImageContainer.style.display = 'block';
            } else {
                currentImageContainer.style.display = 'none';
            }
        });
    });
    
    // Reset form when edit modal is closed
    editModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('editForm').reset();
        document.getElementById('edit_current_image_container').style.display = 'none';
    });
});
</script>
@endpush
@endsection


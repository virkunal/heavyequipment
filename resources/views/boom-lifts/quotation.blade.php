@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Get Quotation')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calculator"></i> Get Quotation for {{ $boomLift->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('boom-lifts.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>

                    <!-- Boom Lift Summary -->
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($boomLift->image)
                                        <img src="{{ Storage::url($boomLift->image) }}" alt="{{ $boomLift->name }}" class="img-fluid rounded">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                            <span class="text-muted">No Image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h5 class="fw-bold">{{ $boomLift->name }}</h5>
                                    @if($boomLift->model)
                                        <p class="text-muted mb-2"><strong>Model:</strong> {{ $boomLift->model }}</p>
                                    @endif
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="text-center p-2 bg-info bg-opacity-10 rounded">
                                                <small class="text-muted d-block">Hourly Rate</small>
                                                <strong class="text-info">₹{{ number_format($boomLift->hourly_rate, 2) }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center p-2 bg-success bg-opacity-10 rounded">
                                                <small class="text-muted d-block">Daily Rate</small>
                                                <strong class="text-success">₹{{ number_format($boomLift->daily_rate, 2) }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center p-2 bg-warning bg-opacity-10 rounded">
                                                <small class="text-muted d-block">Monthly Rate</small>
                                                <strong class="text-warning">₹{{ number_format($boomLift->monthly_rate, 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quotation Form -->
                    <form id="quotationForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rental_type" class="form-label">Rental Type *</label>
                                    <select id="rental_type" name="rental_type" class="form-select" required>
                                        <option value="">Select rental type</option>
                                        <option value="hourly">Hourly - ₹{{ number_format($boomLift->hourly_rate, 2) }}/hour</option>
                                        <option value="daily">Daily - ₹{{ number_format($boomLift->daily_rate, 2) }}/day</option>
                                        <option value="monthly">Monthly - ₹{{ number_format($boomLift->monthly_rate, 2) }}/month</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity *</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date *</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Your Name *</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email Address *</label>
                            <input type="email" id="customer_email" name="customer_email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone Number *</label>
                            <input type="tel" id="customer_phone" name="customer_phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Any special requirements or additional information..."></textarea>
                        </div>

                        <!-- Quotation Result -->
                        <div id="quotationResult" class="alert alert-info d-none">
                            <h5 class="alert-heading"><i class="fas fa-receipt"></i> Quotation</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Rental Type:</strong> <span id="result_rental_type"></span></p>
                                    <p class="mb-1"><strong>Duration:</strong> <span id="result_duration"></span></p>
                                    <p class="mb-1"><strong>Quantity:</strong> <span id="result_quantity"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Rate per Unit:</strong> ₹<span id="result_rate"></span></p>
                                    <p class="mb-1"><strong>Subtotal:</strong> ₹<span id="result_subtotal"></span></p>
                                    <h4 class="mb-0 text-primary"><strong>Total Amount: ₹<span id="result_total"></span></strong></h4>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" id="calculateBtn" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Calculate Quotation
                            </button>
                            @auth
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#rentalModal">
                                    <i class="fas fa-check"></i> Proceed to Rent
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success">
                                    <i class="fas fa-sign-in-alt"></i> Login to Rent
                                </a>
                            @endauth
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
<!-- Rental Modal -->
<div class="modal fade" id="rentalModal" tabindex="-1" aria-labelledby="rentalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rentalModalLabel">
                    <i class="fas fa-shopping-cart"></i> Rent: {{ $boomLift->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('rentals.store', $boomLift) }}" id="rentalForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal_rental_type" class="form-label">Rental Type *</label>
                        <select id="modal_rental_type" name="rental_type" class="form-select" required>
                            <option value="">Select rental type</option>
                            <option value="hourly">Hourly - ₹{{ number_format($boomLift->hourly_rate, 2) }}/hour</option>
                            <option value="daily">Daily - ₹{{ number_format($boomLift->daily_rate, 2) }}/day</option>
                            <option value="monthly">Monthly - ₹{{ number_format($boomLift->monthly_rate, 2) }}/month</option>
                        </select>
                        @error('rental_type')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_start_date" class="form-label">Start Date *</label>
                                <input type="date" id="modal_start_date" name="start_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                                @error('start_date')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_end_date" class="form-label">End Date *</label>
                                <input type="date" id="modal_end_date" name="end_date" class="form-control" required>
                                @error('end_date')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_quantity" class="form-label">Quantity *</label>
                        <input type="number" id="modal_quantity" name="quantity" class="form-control" min="1" value="1" required>
                        @error('quantity')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>Note:</strong> Please ensure all details are correct before submitting your rental request.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Submit Rental Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rentalType = document.getElementById('rental_type');
    const quantity = document.getElementById('quantity');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const calculateBtn = document.getElementById('calculateBtn');
    const quotationResult = document.getElementById('quotationResult');

    const rates = {
        hourly: {{ $boomLift->hourly_rate }},
        daily: {{ $boomLift->daily_rate }},
        monthly: {{ $boomLift->monthly_rate }}
    };

    calculateBtn.addEventListener('click', function() {
        if (!rentalType.value || !startDate.value || !endDate.value) {
            alert('Please fill in all required fields.');
            return;
        }

        if (new Date(endDate.value) <= new Date(startDate.value)) {
            alert('End date must be after start date.');
            return;
        }

        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        const qty = parseInt(quantity.value) || 1;
        const rate = rates[rentalType.value];

        let duration = 0;
        let durationText = '';

        if (rentalType.value === 'hourly') {
            duration = Math.ceil((end - start) / (1000 * 60 * 60));
            durationText = duration + ' hour(s)';
        } else if (rentalType.value === 'daily') {
            duration = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            durationText = duration + ' day(s)';
        } else if (rentalType.value === 'monthly') {
            duration = Math.max(1, Math.ceil((end - start) / (1000 * 60 * 60 * 24 * 30)));
            durationText = duration + ' month(s)';
        }

        const subtotal = rate * duration;
        const total = subtotal * qty;

        document.getElementById('result_rental_type').textContent = rentalType.options[rentalType.selectedIndex].text;
        document.getElementById('result_duration').textContent = durationText;
        document.getElementById('result_quantity').textContent = qty;
        document.getElementById('result_rate').textContent = rate.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('result_subtotal').textContent = subtotal.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('result_total').textContent = total.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        quotationResult.classList.remove('d-none');
        quotationResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    // Pre-fill modal form from quotation form
    const rentalModal = document.getElementById('rentalModal');
    if (rentalModal) {
        rentalModal.addEventListener('show.bs.modal', function () {
            // Copy values from quotation form to modal form if available
            const quotationRentalType = document.getElementById('rental_type').value;
            const quotationQuantity = document.getElementById('quantity').value;
            const quotationStartDate = document.getElementById('start_date').value;
            const quotationEndDate = document.getElementById('end_date').value;

            if (quotationRentalType) {
                document.getElementById('modal_rental_type').value = quotationRentalType;
            }
            if (quotationQuantity) {
                document.getElementById('modal_quantity').value = quotationQuantity;
            }
            if (quotationStartDate) {
                document.getElementById('modal_start_date').value = quotationStartDate;
            }
            if (quotationEndDate) {
                document.getElementById('modal_end_date').value = quotationEndDate;
            }
        });
    }
});
</script>
@endpush
@endsection


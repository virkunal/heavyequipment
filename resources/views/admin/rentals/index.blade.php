@extends('layouts.admin')

@section('title', 'Rent Requests')
@section('page_title', 'Rent Requests')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.boom-lifts.index') }}">Admin</a></li>
    <li class="breadcrumb-item active">Rent Requests</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Rental Requests</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="rentalsTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Boom Lift</th>
                        <th>User</th>
                        <th>Rental Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                        <tr>
                            <td>{{ $rental->id }}</td>
                            <td>{{ $rental->boomLift->name }}</td>
                            <td>{{ $rental->user->name }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($rental->rental_type) }}</span>
                            </td>
                            <td>{{ $rental->start_date->format('M d, Y') }}</td>
                            <td>{{ $rental->end_date->format('M d, Y') }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'completed' => 'primary',
                                        'cancelled' => 'secondary',
                                    ];
                                    $color = $statusColors[$rental->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ ucfirst($rental->status) }}</span>
                            </td>
                            <td>
                                <button type="button" 
                                    class="btn btn-primary btn-sm view-details-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailsModal"
                                    data-rental-id="{{ $rental->id }}"
                                    data-boom-lift-name="{{ $rental->boomLift->name }}"
                                    data-user-name="{{ $rental->user->name }}"
                                    data-rental-type="{{ $rental->rental_type }}"
                                    data-start-date="{{ $rental->start_date->format('Y-m-d') }}"
                                    data-end-date="{{ $rental->end_date->format('Y-m-d') }}"
                                    data-quantity="{{ $rental->quantity }}"
                                    data-rate="{{ $rental->rate }}"
                                    data-duration="{{ $rental->duration }}"
                                    data-total-amount="{{ $rental->total_amount }}"
                                    data-status="{{ $rental->status }}"
                                    data-notes="{{ $rental->notes ?? '' }}">
                                    <i class="fas fa-eye"></i> Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No rental requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{ $rentals->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">
                        <i class="fas fa-info-circle"></i> Rental Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Boom Lift:</label>
                                <p class="mb-0" id="modal_boom_lift_name"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">User:</label>
                                <p class="mb-0" id="modal_user_name"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rental Type:</label>
                                <p class="mb-0"><span id="modal_rental_type" class="badge bg-info"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <p class="mb-0"><span id="modal_status" class="badge"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Start Date:</label>
                                <p class="mb-0" id="modal_start_date"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">End Date:</label>
                                <p class="mb-0" id="modal_end_date"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Quantity:</label>
                                <p class="mb-0" id="modal_quantity"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rate:</label>
                                <p class="mb-0" id="modal_rate"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Duration:</label>
                                <p class="mb-0" id="modal_duration"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Total Amount:</label>
                                <p class="mb-0 fw-bold text-success" id="modal_total_amount"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Notes:</label>
                                <p class="mb-0" id="modal_notes"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsModal = document.getElementById('detailsModal');
    const viewDetailsButtons = document.querySelectorAll('.view-details-btn');

    viewDetailsButtons.forEach(button => {
        button.addEventListener('click', function() {
            const boomLiftName = this.getAttribute('data-boom-lift-name');
            const userName = this.getAttribute('data-user-name');
            const rentalType = this.getAttribute('data-rental-type');
            const startDate = this.getAttribute('data-start-date');
            const endDate = this.getAttribute('data-end-date');
            const quantity = this.getAttribute('data-quantity');
            const rate = parseFloat(this.getAttribute('data-rate'));
            const duration = parseInt(this.getAttribute('data-duration'));
            const totalAmount = parseFloat(this.getAttribute('data-total-amount'));
            const status = this.getAttribute('data-status');
            const notes = this.getAttribute('data-notes');

            // Populate modal with rental data
            document.getElementById('modal_boom_lift_name').textContent = boomLiftName;
            document.getElementById('modal_user_name').textContent = userName;
            
            const rentalTypeText = rentalType.charAt(0).toUpperCase() + rentalType.slice(1);
            document.getElementById('modal_rental_type').textContent = rentalTypeText;
            
            // Format dates
            const startDateObj = new Date(startDate);
            const endDateObj = new Date(endDate);
            document.getElementById('modal_start_date').textContent = startDateObj.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            document.getElementById('modal_end_date').textContent = endDateObj.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            // Status badge
            const statusColors = {
                'pending': 'warning',
                'approved': 'success',
                'rejected': 'danger',
                'completed': 'primary',
                'cancelled': 'secondary'
            };
            const statusBadge = document.getElementById('modal_status');
            const statusText = status.charAt(0).toUpperCase() + status.slice(1);
            statusBadge.textContent = statusText;
            statusBadge.className = 'badge bg-' + (statusColors[status] || 'secondary');

            document.getElementById('modal_quantity').textContent = quantity;
            document.getElementById('modal_rate').textContent = '₹' + rate.toLocaleString('en-IN', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            });
            
            // Format duration based on rental type
            let durationText = duration + ' ';
            if (rentalType === 'hourly') {
                durationText += duration === 1 ? 'Hour' : 'Hours';
            } else if (rentalType === 'daily') {
                durationText += duration === 1 ? 'Day' : 'Days';
            } else {
                durationText += duration === 1 ? 'Month' : 'Months';
            }
            document.getElementById('modal_duration').textContent = durationText;
            
            document.getElementById('modal_total_amount').textContent = '₹' + totalAmount.toLocaleString('en-IN', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            });
            document.getElementById('modal_notes').textContent = notes || 'No notes provided.';
        });
    });
});
</script>
@endpush


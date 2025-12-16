@extends('layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'View Boom Lift')
@section('page_title', 'View Boom Lift')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.boom-lifts.index') }}">Boom Lifts</a></li>
<li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $boomLift->name }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.boom-lifts.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($boomLift->image)
                            <img src="{{ Storage::url($boomLift->image) }}" alt="{{ $boomLift->name }}" class="img-fluid rounded">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="min-height: 400px;">
                                <span class="text-muted">No Image Available</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            @if($boomLift->model)
                                <dt class="col-sm-4">Model:</dt>
                                <dd class="col-sm-8">{{ $boomLift->model }}</dd>
                            @endif

                            @if($boomLift->description)
                                <dt class="col-sm-4">Description:</dt>
                                <dd class="col-sm-8">{{ $boomLift->description }}</dd>
                            @endif

                            @if($boomLift->address)
                                <dt class="col-sm-4">Address:</dt>
                                <dd class="col-sm-8">{{ $boomLift->address }}</dd>
                            @endif

                            @if($boomLift->latitude && $boomLift->longitude)
                                <dt class="col-sm-4">Location:</dt>
                                <dd class="col-sm-8">
                                    Latitude: {{ $boomLift->latitude }}, Longitude: {{ $boomLift->longitude }}
                                    <br>
                                    <a href="https://www.google.com/maps?q={{ $boomLift->latitude }},{{ $boomLift->longitude }}" target="_blank" class="btn btn-sm btn-primary mt-1">
                                        <i class="fas fa-map-marker-alt"></i> View on Map
                                    </a>
                                </dd>
                            @endif

                            @if($boomLift->specifications)
                                <dt class="col-sm-4">Specifications:</dt>
                                <dd class="col-sm-8">
                                    <ul class="list-unstyled">
                                        @foreach($boomLift->specifications as $key => $value)
                                            <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </dd>
                            @endif

                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                @if($boomLift->is_available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Unavailable</span>
                                @endif
                            </dd>
                        </dl>

                        <div class="mt-4">
                            <h5>Rental Rates</h5>
                            <div class="row">
                                <div class="col-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="far fa-clock"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Hourly</span>
                                            <span class="info-box-number">₹{{ number_format($boomLift->hourly_rate, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="far fa-calendar-day"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Daily</span>
                                            <span class="info-box-number">₹{{ number_format($boomLift->daily_rate, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="far fa-calendar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Monthly</span>
                                            <span class="info-box-number">₹{{ number_format($boomLift->monthly_rate, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.boom-lifts.index') }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.boom-lifts.destroy', $boomLift) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this boom lift?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


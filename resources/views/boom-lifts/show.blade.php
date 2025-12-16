@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', $boomLift->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2">
                @if($boomLift->image)
                    <img src="{{ Storage::url($boomLift->image) }}" alt="{{ $boomLift->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-xl">No Image</span>
                    </div>
                @endif
            </div>
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $boomLift->name }}</h1>
                
                @if($boomLift->model)
                    <p class="text-gray-600 mb-2"><strong>Model:</strong> {{ $boomLift->model }}</p>
                @endif

                @if($boomLift->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $boomLift->description }}</p>
                    </div>
                @endif

                @if($boomLift->specifications)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Specifications</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach($boomLift->specifications as $key => $value)
                                <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Rental Rates</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600">Hourly</p>
                            <p class="text-2xl font-bold text-blue-600">₹{{ number_format($boomLift->hourly_rate, 2) }}</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600">Daily</p>
                            <p class="text-2xl font-bold text-blue-600">₹{{ number_format($boomLift->daily_rate, 2) }}</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded">
                            <p class="text-sm text-gray-600">Monthly</p>
                            <p class="text-2xl font-bold text-blue-600">₹{{ number_format($boomLift->monthly_rate, 2) }}</p>
                        </div>
                    </div>
                </div>

                @auth
                    <a href="{{ route('rentals.create', $boomLift) }}" 
                        class="block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 text-lg font-semibold">
                        Rent Now
                    </a>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                        <p class="text-yellow-800">Please <a href="{{ route('login') }}" class="underline">login</a> to rent this boom lift.</p>
                    </div>
                @endauth

                <a href="{{ route('boom-lifts.index') }}" class="block text-center text-blue-600 hover:underline mt-4">
                    ← Back to Browse
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


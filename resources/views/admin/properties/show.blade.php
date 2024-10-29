{{-- resources/views/admin/properties/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-[#1B2E35] p-6 rounded-xl shadow-lg border border-gray-700">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-white">Property Details #{{ $property->id }}</h2>
            <div class="flex space-x-2">
                @if(!$isExclusive)
                <a href="{{ route('admin.properties.edit', $property->id) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Property
                </a>
                @endif
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="space-y-4">
                <div>
                    <label class="text-gray-400 text-sm">Title</label>
                    <p class="text-white">{{ $property->title }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">Type</label>
                    <p class="text-white">{{ str_replace('_', ' ', ucfirst($property->type)) }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">Price</label>
                    <p class="text-white">₱{{ number_format($property->price) }}</p>
                </div>
            </div>

            <!-- Location Information -->
            <div class="space-y-4">
                <div>
                    <label class="text-gray-400 text-sm">City</label>
                    <p class="text-white">{{ $property->city }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">Address</label>
                    <p class="text-white">{{ $property->property_address }}</p>
                </div>
            </div>

            <!-- Property Details -->
            <div class="space-y-4">
                <div>
                    <label class="text-gray-400 text-sm">Bedrooms</label>
                    <p class="text-white">{{ $property->bedrooms }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">Bathrooms</label>
                    <p class="text-white">{{ $property->bathrooms }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">Area (sqm)</label>
                    <p class="text-white">{{ $property->sqm }}</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4">
                <div>
                    <label class="text-gray-400 text-sm">Email</label>
                    <p class="text-white">{{ $property->contact_email }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">Messenger</label>
                    <p class="text-white">{{ $property->contact_messenger }}</p>
                </div>

                <div>
                    <label class="text-gray-400 text-sm">WhatsApp</label>
                    <p class="text-white">{{ $property->contact_whatsapp }}</p>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <label class="text-gray-400 text-sm">Description</label>
            <p class="text-white mt-2">{{ $property->description }}</p>
        </div>

        <!-- Features -->
        <div class="mt-6">
            <label class="text-gray-400 text-sm">Features</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                @foreach(['swimming_pool', 'gym_access', 'living_room', 'dining_room'] as $feature)
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded-full {{ $property->$feature ? 'bg-green-500' : 'bg-gray-500' }}"></div>
                        <span class="text-white">{{ str_replace('_', ' ', ucfirst($feature)) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

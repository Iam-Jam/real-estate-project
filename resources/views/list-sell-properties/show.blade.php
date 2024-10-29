@extends('layouts.app')

@section('content')
  <!-- Add the messages section right here, before the main content -->

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mb-4" role="alert">
                <strong class="font-bold">Please fix the following errors:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
<div class="min-h-screen bg-gray-100 pt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Property Header -->
            <div class="bg-primary p-4">
                <h2 class="text-2xl font-bold text-white">{{ $listProperty->title }}</h2>
                <p class="text-sm text-white">{{ ucfirst($listProperty->property_option) }} Property</p>
            </div>

            <!-- Property Images -->
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($listProperty->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}"
                            alt="Property image"
                            class="w-full h-48 object-cover rounded">
                    @empty
                        <div class="col-span-3 text-center py-8 bg-gray-100 rounded">
                            No images available
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Property Details -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="col-span-2 md:col-span-1">
                        <h3 class="text-lg font-semibold mb-2">Property Details</h3>
                        <dl class="grid grid-cols-2 gap-2">
                            <dt class="text-gray-600">Type:</dt>
                            <dd>{{ ucfirst(str_replace('_', ' ', $listProperty->type)) }}</dd>

                            <dt class="text-gray-600">Price:</dt>
                            <dd>₱{{ number_format($listProperty->price, 2) }}</dd>

                            <dt class="text-gray-600">Bedrooms:</dt>
                            <dd>{{ $listProperty->bedrooms }}</dd>

                            <dt class="text-gray-600">Bathrooms:</dt>
                            <dd>{{ $listProperty->bathrooms }}</dd>

                            <dt class="text-gray-600">Floor Area:</dt>
                            <dd>{{ $listProperty->sqm }} sqm</dd>
                        </dl>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <h3 class="text-lg font-semibold mb-2">Location</h3>
                        <p class="text-gray-700">{{ $listProperty->property_address }}</p>
                        <p class="text-gray-700">{{ $listProperty->city }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $listProperty->description }}</p>
                </div>

                <!-- Amenities -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Amenities</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['swimming_pool', 'gym_access', 'living_room', 'dining_room'] as $amenity)
                            @if($listProperty->$amenity)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($listProperty->contact_whatsapp)
                            <a href="https://wa.me/{{ $listProperty->contact_whatsapp }}"
                                target="_blank"
                                class="flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                <span>WhatsApp</span>
                            </a>
                        @endif

                        @if($listProperty->contact_messenger)
                            <a href="https://m.me/{{ $listProperty->contact_messenger }}"
                                target="_blank"
                                class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                <span>Messenger</span>
                            </a>
                        @endif

                        @if($listProperty->contact_email)
                            <a href="mailto:{{ $listProperty->contact_email }}"
                                class="flex items-center justify-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                <span>Email</span>
                            </a>
                        @endif
                    </div>
                </div>
<!-- Status Toggle Button (Admin/Agents) -->
@if(Auth::user()->user_type === 'admin' || in_array(Auth::user()->user_type, ['agent1', 'agent2']))
    <div class="mt-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('list-sell-property.toggle-status', $listProperty) }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full py-3 px-6 rounded-lg text-center font-semibold transition duration-300 ease-in-out text-white shadow-lg
                    {{ $listProperty->status === 'pending'
                        ? 'bg-[#052e16] hover:bg-[#14532d]'
                        : 'bg-[#1a2e05] hover:bg-[#365314]' }}">
                {{ $listProperty->status === 'pending' ? 'Approve Listing' : 'Mark as Pending' }}
            </button>
        </form>
    </div>
@endif

<!-- Featured/Exclusive Buttons (Admin Only) -->
@if(Auth::user()->user_type === 'admin')
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('toggle-featured', $listProperty) }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="w-full py-3 px-6 rounded-lg text-center font-semibold transition duration-300 ease-in-out text-white shadow-lg
                    {{ $listProperty->is_featured
                        ? 'bg-[#14532d] hover:bg-[#052e16]'
                        : 'bg-[#1a2e05] hover:bg-[#365314]' }}">
                {{ $listProperty->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
            </button>
        </form>

        <form action="{{ route('toggle-exclusive', $listProperty) }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="w-full py-3 px-6 rounded-lg text-center font-semibold transition duration-300 ease-in-out text-white shadow-lg
                    {{ $listProperty->is_exclusive
                        ? 'bg-[#14532d] hover:bg-[#052e16]'
                        : 'bg-[#1a2e05] hover:bg-[#365314]' }}">
                {{ $listProperty->is_exclusive ? 'Remove Exclusive' : 'Mark as Exclusive' }}
            </button>
        </form>
    </div>
@endif

<!-- Status Tags -->
<div class="flex flex-wrap gap-2 mt-6 px-4 sm:px-6 lg:px-8">
    <span class="px-4 py-2 rounded-full text-sm font-semibold
        {{ $listProperty->status === 'pending'
            ? 'bg-[#052e16] text-white'
            : 'bg-[#14532d] text-white' }}">
        {{ ucfirst($listProperty->status) }}
    </span>

    @if($listProperty->is_featured)
        <span class="px-4 py-2 bg-[#1a2e05] text-white rounded-full text-sm font-semibold">
            Featured
        </span>
    @endif

    @if($listProperty->is_exclusive)
        <span class="px-4 py-2 bg-[#365314] text-white rounded-full text-sm font-semibold">
            Exclusive
        </span>
    @endif
</div>

<!-- Action Buttons (Edit/Delete/Back) -->
@if(Auth::check() && (in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2', 'seller']) &&
    (Auth::id() === $listProperty->user_id || Auth::user()->user_type === 'admin')))
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('list-sell-property.edit', $listProperty) }}"
            class="inline-flex justify-center items-center px-6 py-3 bg-[#052e16] text-white font-semibold rounded-lg
                hover:bg-[#14532d] transition duration-300 ease-in-out shadow-lg text-center">
            Edit Listing
        </a>

        <form action="{{ route('list-sell-property.destroy', $listProperty) }}"
            method="POST"
            class="w-full"
            onsubmit="return confirm('Are you sure you want to delete this listing?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full px-6 py-3 bg-red-600 text-white font-semibold rounded-lg
                    hover:bg-red-700 transition duration-300 ease-in-out shadow-lg">
                Delete Listing
            </button>
        </form>

         <a href="{{ route('profile.submitted-forms') }}"
            class="inline-flex justify-center items-center px-6 py-3 bg-[#14532d] text-white font-semibold rounded-lg
                hover:bg-[#052e16] transition duration-300 ease-in-out shadow-lg text-center">
                Back to My Submitted Forms
        </a>
    </div>
@else
    <!-- Back Button Only for Non-Owners -->
    <div class="px-4 sm:px-6 lg:px-8 mt-6">
       <a href="{{ route('profile.submitted-forms') }}"
            class="block w-full px-6 py-3 bg-[#14532d] text-white font-semibold rounded-lg text-center
                hover:bg-[#052e16] transition duration-300 ease-in-out shadow-lg">
            Back to My Submitted Forms
        </a>
    </div>
@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

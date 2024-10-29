@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-100 pt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-primary p-4">
                <h2 class="text-2xl font-bold text-white">List Your Property</h2>
                <p class="text-sm text-white">Showcase your property to thousands of potential buyers</p>
            </div>
            @if ($errors->any())
            <div class="bg-red-50 p-4 mb-6">
                <div class="font-medium text-red-600">Please correct the following errors:</div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(auth()->check())
        <form action="{{ route('list-sell-property.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

                <div class="bg-gray-100 p-4 rounded mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <input type="radio" id="list" name="property_option" value="list" class="form-radio text-primary" {{ old('property_option', 'list') === 'list' ? 'checked' : '' }}>
                            <label for="list" class="ml-2 text-gray-700">List Property</label>
                        </div>
                        <div>
                            <input type="radio" id="sell" name="property_option" value="sell" class="form-radio text-primary" {{ old('property_option') === 'sell' ? 'checked' : '' }}>
                            <label for="sell" class="ml-2 text-gray-700">Sell Property</label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                        <select name="type" id="type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="lot" {{ old('type') === 'lot' ? 'selected' : '' }}>Lot</option>
                            <option value="house_and_lot" {{ old('type') === 'house_and_lot' ? 'selected' : '' }}>House and Lot</option>
                            <option value="townhouse" {{ old('type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                            <option value="condominium" {{ old('type') === 'condominium' ? 'selected' : '' }}>Condominium Unit</option>
                            <option value="apartment" {{ old('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="room" {{ old('type') === 'room' ? 'selected' : '' }}>Room</option>
                        </select>
                    </div>

                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                        <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', 0) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
                        <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', 0) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="sqm" class="block text-sm font-medium text-gray-700 mb-1">Square Meters</label>
                        <input type="number" name="sqm" id="sqm" value="{{ old('sqm') }}" required step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" required step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="property_address" class="block text-sm font-medium text-gray-700 mb-1">Property Address</label>
                    <input type="text" name="property_address" id="property_address" value="{{ old('property_address') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>

                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center">
                        <input type="hidden" name="swimming_pool" value="0">
                        <input type="checkbox" name="swimming_pool" id="swimming_pool" value="1"
                               class="form-checkbox text-primary" {{ old('swimming_pool') ? 'checked' : '' }}>
                        <label for="swimming_pool" class="ml-2 text-sm text-gray-700">Swimming Pool</label>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="gym_access" value="0">
                        <input type="checkbox" name="gym_access" id="gym_access" value="1"
                               class="form-checkbox text-primary" {{ old('gym_access') ? 'checked' : '' }}>
                        <label for="gym_access" class="ml-2 text-sm text-gray-700">Gym Access</label>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="living_room" value="0">
                        <input type="checkbox" name="living_room" id="living_room" value="1"
                               class="form-checkbox text-primary" {{ old('living_room') ? 'checked' : '' }}>
                        <label for="living_room" class="ml-2 text-sm text-gray-700">Living Room</label>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="dining_room" value="0">
                        <input type="checkbox" name="dining_room" id="dining_room" value="1"
                               class="form-checkbox text-primary" {{ old('dining_room') ? 'checked' : '' }}>
                        <label for="dining_room" class="ml-2 text-sm text-gray-700">Dining Room</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Images (up to 3)</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    <p class="mt-1 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG (max 2MB each)</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                        <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ old('contact_whatsapp') }}"
                               placeholder="WhatsApp number"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="contact_messenger" class="block text-sm font-medium text-gray-700 mb-1">Messenger</label>
                        <input type="text" name="contact_messenger" id="contact_messenger" value="{{ old('contact_messenger') }}"
                               placeholder="Messenger username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                           placeholder="Email address"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                </div>

                @if(auth()->user()->user_type === 'admin')  {{-- Changed from type to user_type --}}
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured"
                               class="form-checkbox text-primary" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured" class="ml-2 text-sm text-gray-700">Feature this property</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_exclusive" id="is_exclusive"
                               class="form-checkbox text-primary" {{ old('is_exclusive') ? 'checked' : '' }}>
                        <label for="is_exclusive" class="ml-2 text-sm text-gray-700">Mark as exclusive</label>
                    </div>
                </div>
                @endif
                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">Submit Property</button>
                </div>
            </form>
        @else
            <div class="p-8 text-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Authorization Required</h3>
                <p class="text-gray-600 mb-6">You need to be an authorized user to list properties.</p>
                <a href="{{ route('forms.index') }}"
                   class="inline-block bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition duration-300">
                    Go to Forms
                </a>
            </div>
        @endif

        {{-- Flash message for unauthorized users --}}
        @if(session('info'))
            <div class="fixed bottom-4 right-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded shadow-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">{{ session('info') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button class="text-blue-400 hover:text-blue-500" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

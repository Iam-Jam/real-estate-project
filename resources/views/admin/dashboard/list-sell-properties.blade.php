
<!-- Pending Listings Section -->
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Pending Listings</h2>
    </div>
    <div class="p-6">
        @forelse($pendingListings ?? [] as $listing)
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 last:border-0">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">{{ $listing->title }}</h4>
                    <p class="text-sm text-gray-600">{{ $listing->property_address }}</p>
                    <p class="text-sm text-gray-500">Submitted by: {{ $listing->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $listing->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('list-sell-property.toggle-status', $listing) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Approve
                        </button>
                    </form>
                    <form action="{{ route('toggle-featured', $listing) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                            {{ $listing->is_featured ? 'Unmark Featured' : 'Mark Featured' }}
                        </button>
                    </form>
                    <form action="{{ route('toggle-exclusive', $listing) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                            {{ $listing->is_exclusive ? 'Unmark Exclusive' : 'Mark Exclusive' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center">No pending listings</p>
        @endforelse
    </div>
</div>

<!-- Approved Listings Section -->
<div class="bg-white shadow rounded-lg mt-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Approved Listings</h2>
    </div>
    <div class="p-6">
        @forelse($approvedListings ?? [] as $listing)
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 last:border-0">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">{{ $listing->title }}</h4>
                    <p class="text-sm text-gray-600">{{ $listing->property_address }}</p>
                    <p class="text-sm text-gray-500">Status:
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Approved
                        </span>
                    </p>
                    <div class="mt-1 space-x-2">
                        @if($listing->is_featured)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                Featured
                            </span>
                        @endif
                        @if($listing->is_exclusive)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Exclusive
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('list-sell-property.show', $listing) }}"
                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        View
                    </a>
                    <form action="{{ route('list-sell-property.toggle-status', $listing) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                            Unpublish
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center">No approved listings</p>
        @endforelse
    </div>
</div>

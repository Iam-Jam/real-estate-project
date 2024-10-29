{{-- resources/views/admin/dashboard/properties-management.blade.php --}}
<div x-data="propertyManagement()" class="space-y-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-white">Properties Management</h2>
    </div>

    <!-- Search Controls -->
    <div class="bg-gray-800/40 p-6 rounded-xl backdrop-blur-sm border border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-white mb-2">Property ID</label>
                <input type="text"
                       x-model="searchId"
                       @keyup.enter="performSearch"
                       class="w-full rounded-lg bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Enter Property ID">
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-2">Property Type</label>
                <select x-model="searchType"
                        @change="performSearch"
                        class="w-full rounded-lg bg-gray-700 border-gray-600 text-white focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="lot">Lot</option>
                    <option value="house_and_lot">House and Lot</option>
                    <option value="townhouse">Townhouse</option>
                    <option value="condominium">Condominium</option>
                    <option value="apartment">Apartment</option>
                </select>
            </div>

            <div class="flex items-end">
                <button @click="performSearch"
                        class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                    Search Properties
                </button>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-gray-800/40 rounded-xl backdrop-blur-sm border border-gray-700 overflow-hidden">
        <!-- Loading Overlay -->
        <div x-show="loading"
             class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID & Title</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <template x-if="!loading && properties.length === 0">
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                No properties found
                            </td>
                        </tr>
                    </template>
                    <template x-for="property in properties" :key="property.id">
                        <tr class="hover:bg-gray-700/30 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-white">
                                        #<span x-text="property.id"></span>
                                    </div>
                                    <div class="text-sm text-gray-300" x-text="property.title"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-white capitalize" x-text="property.type.replace('_', ' ')"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-white" x-text="'₱' + Number(property.price).toLocaleString()"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-white" x-text="property.city"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button @click="viewProperty(property.id)"
                                            class="p-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button @click="editProperty(property.id)"
                                            class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button @click="deleteProperty(property.id)"
                                            class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function propertyManagement() {
    return {
        searchId: '',
        searchType: '',
        properties: @json($properties ?? []),
        loading: false,

        async performSearch() {
            this.loading = true;
            try {
                const response = await fetch('/admin/properties/search', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        property_id: this.searchId,
                        type: this.searchType
                    })
                });

                if (!response.ok) throw new Error('Search failed');

                const data = await response.json();
                this.properties = data;
            } catch (error) {
                console.error('Search error:', error);
                alert('Failed to search properties');
            } finally {
                this.loading = false;
            }
        },

        viewProperty(id) {
            window.location.href = `/properties/${id}`;
        },

        editProperty(id) {
            window.location.href = `/properties/${id}/edit`;
        },

        async deleteProperty(propertyId) {
            if (!confirm('Are you sure you want to delete this property?')) return;

            try {
                const response = await fetch(`/properties/${propertyId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Deletion failed');

                this.properties = this.properties.filter(p => p.id !== propertyId);

            } catch (error) {
                console.error('Deletion error:', error);
                alert('Failed to delete property');
            }
        }
    }
}
</script>

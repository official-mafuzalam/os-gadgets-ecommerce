<x-admin-layout>
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6">Subscribers</h1>

            <form action="{{ route('admin.subscribers.bulkAction') }}" method="POST" id="bulkForm">
                @csrf
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-4">
                        <select name="action" id="bulkAction" class="border rounded px-3 py-2">
                            <option value="">Select Action</option>
                            <option value="delete">Delete Selected</option>
                            <option value="send_deal">Send Deal to Selected</option>
                        </select>
                        <button type="submit" id="applyAction"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Apply
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subscribed At
                                </th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subscribers as $subscriber)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected[]" value="{{ $subscriber->id }}"
                                            class="selectItem">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $subscriber->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $subscriber->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}"
                                            method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No subscribers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="mt-4">
                {{ $subscribers->links() }}
            </div>
        </div>

        <!-- Deal Selection Modal -->
        <div id="dealModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 max-h-screen overflow-y-auto">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Select Deal to Send</h3>

                    <form id="dealForm" action="{{ route('admin.subscribers.sendBulkDeal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subscribers" id="selectedSubscribers">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="dealSelect">
                                Choose a Deal
                            </label>
                            <select name="deal_id" id="dealSelect"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Select a Deal</option>
                                @foreach ($deals as $deal)
                                    <option value="{{ $deal->id }}">{{ $deal->title }} ({{ $deal->discount }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" id="closeModal"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Send Deal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- JavaScript for handling bulk actions and modal --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.selectItem');
                const bulkAction = document.getElementById('bulkAction');
                const applyButton = document.getElementById('applyAction');
                const dealModal = document.getElementById('dealModal');
                const closeModal = document.getElementById('closeModal');
                const selectedSubscribers = document.getElementById('selectedSubscribers');
                const dealForm = document.getElementById('dealForm');

                // Select all functionality
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                });

                // Handle bulk action form submission
                document.getElementById('bulkForm').addEventListener('submit', function(e) {
                    const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);

                    if (selected.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one subscriber.');
                        return;
                    }

                    if (bulkAction.value === 'delete') {
                        if (!confirm('Are you sure you want to delete the selected subscribers?')) {
                            e.preventDefault();
                        }
                    } else if (bulkAction.value === 'send_deal') {
                        e.preventDefault();
                        // Show the deal modal
                        selectedSubscribers.value = selected.join(',');
                        dealModal.classList.remove('hidden');
                    }
                });

                // Close modal
                closeModal.addEventListener('click', function() {
                    dealModal.classList.add('hidden');
                });

                // Close modal when clicking outside
                dealModal.addEventListener('click', function(e) {
                    if (e.target === dealModal) {
                        dealModal.classList.add('hidden');
                    }
                });
            });
        </script>
    </x-slot>
</x-admin-layout>
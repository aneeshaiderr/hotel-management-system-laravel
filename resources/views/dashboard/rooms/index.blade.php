<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms DataTable') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table id="rooms-table" class="w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hotel ID</th>
                                <th>Room Number</th>
                                <th>Floor</th>
                                <th>Status</th>
                                <th>Beds</th>
                                <th>Max Guests</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
        <script>
            $(function () {
                $('#rooms-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('dashboard.rooms.datatable') }}',
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hotel_id', name: 'hotel_id' },
                        { data: 'room_number', name: 'room_number' },
                        { data: 'floor', name: 'floor' },
                        { data: 'status', name: 'status' },
                        { data: 'beds', name: 'beds' },
                        { data: 'max_guests', name: 'max_guests' },
                        { data: 'created_at', name: 'created_at' }
                    ],
                    order: [[0, 'desc']]
                });
            });
        </script>
    @endpush
</x-app-layout>

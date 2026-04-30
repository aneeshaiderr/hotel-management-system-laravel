<x-app-layout :showDefaultNavigation="false">
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Rooms DataTable (Yajra Server Side)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="rooms-table" class="table table-striped table-bordered w-100">
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

    @push('scripts')
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

<x-app-layout :showDefaultNavigation="false">
    <div class="container py-5">
        <h5 class="fw-bold mb-2 mt-7 ps-2">Room</h5>
        <div class="mb-2">
            <a href="{{ url('room/create') }}" class="btn btn-sm btn-success" style="background-color:#16a34a; color:white;">
                + Create Room
            </a>
        </div>

        <div class="card card-custom w-100">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Room List</h6>
                <table id="example" class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Room #</th>
                            <th>Floor</th>
                            <th>Beds</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')

        <script>
            $(function () {
                const table = $('#example').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 5,
                    lengthChange: false,
                    ajax: {
                        url: "{{ route('dashboard.rooms.datatable') }}",
                        type: "GET"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'room_number' },
                        { data: 'floor' },
                        { data: 'beds' },
                        { data: 'max_guests' },
                        {
                            data: 'status',
                            render: function (data, type, row) {
                                return `
                                    <select class="form-select form-select-sm room-status" data-id="${row.id}">
                                        <option value="available" ${data === 'available' ? 'selected' : ''}>Available</option>
                                        <option value="booked" ${data === 'booked' ? 'selected' : ''}>Booked</option>
                                        <option value="maintenance" ${data === 'maintenance' ? 'selected' : ''}>Maintenance</option>
                                    </select>
                                `;
                            }
                        },
                        {
                            data: 'id',
                            render: function (id) {
                                return `
                                    <a href="{{ url('room/edit') }}/${id}" class="btn btn-sm btn-success">View</a>
                                    <form class="delete-form d-inline" action="{{ url('room/delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="${id}">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                `;
                            }
                        }
                    ]
                });

                $(document).on('change', '.room-status', function () {
                    const roomId = $(this).data('id');
                    const status = $(this).val();
                    $.ajax({
                        url: "{{ url('room') }}",
                        type: "POST",
                        data: {
                            id: roomId,
                            status: status,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function () {
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            alert('Status update failed');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>



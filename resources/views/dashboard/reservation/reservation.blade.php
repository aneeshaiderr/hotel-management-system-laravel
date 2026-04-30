<x-app-layout :showDefaultNavigation="false">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-2 ps-2">Reservations</h5>
        </div>
        <div class="mb-4">
            <a href="{{ url('reservation/create') }}" class="btn btn-sm btn-success" style="background-color:#16a34a; color:white; padding:8px 16px; border-radius:6px; text-decoration:none;">
                + Create Reservation
            </a>
        </div>

        <div class="card card-custom w-100">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Reservation List</h6>
                <table id="reservationsTable" class="table table-striped table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Hotel Code</th>
                            <th>Email</th>
                            <th>Hotel Name</th>
                            <th>Room ID</th>
                            <th>Discount Name</th>
                            <th>Check In</th>
                            <th>Check Out</th>
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
            $(document).ready(function () {
                $('#reservationsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 5,
                    lengthChange: false,
                    ajax: {
                        url: "{{ route('dashboard.reservation.datatable') }}",
                        type: "GET"
                    },
                    columns: [
                        { data: 'hotel_code' },
                        { data: 'email' },
                        { data: 'hotel_name' },
                        { data: 'room_id' },
                        { data: 'discount_name' },
                        { data: 'check_in' },
                        { data: 'check_out' },
                        {
                            data: 'status',
                            render: function (status) {
                                status = (status || '').toLowerCase();
                                if (status === 'active') return '<span class="badge bg-success">Active</span>';
                                if (status === 'inactive') return '<span class="badge bg-danger">Inactive</span>';
                                return `<span class="badge bg-warning text-dark">${status}</span>`;
                            }
                        },
                        {
                            data: 'id',
                            orderable: false,
                            render: function (id) {
                                return `
                                    <div class="d-flex">
                                        <a href="{{ url('reservation/edit') }}/${id}" class="btn btn-sm btn-primary me-1">View</a>
                                        <form class="d-inline m-0" method="POST" action="{{ url('reservation/delete') }}" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            <input type="hidden" name="id" value="${id}">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>

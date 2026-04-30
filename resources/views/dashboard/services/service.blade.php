<x-app-layout :showDefaultNavigation="false">
    <div class="container py-5">
        <h5 class="fw-bold mb-2 ps-2">Service</h5>
        <div class="mb-4">
            <a href="{{ url('services/create') }}" class="btn btn-sm btn-success">
                + Create Services
            </a>
        </div>

        <div class="card card-custom w-100">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Service List</h6>
                <table id="example" class="table table-striped table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Service Name</th>
                            <th>Price</th>
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
                $('#example').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 5,
                    lengthChange: false,
                    ajax: {
                        url: "{{ url('services/datatable') }}",
                        type: "GET"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'service_name' },
                        {
                            data: 'price',
                            render: function (data) { return '$' + data; }
                        },
                        {
                            data: 'status',
                            render: function (status) {
                                status = (status || '').toLowerCase();
                                if (status === 'active' || status === '1') return '<span class="badge bg-success">Active</span>';
                                if (status === 'inactive' || status === '0') return '<span class="badge bg-danger">Inactive</span>';
                                return '<span class="badge bg-warning text-dark">' + status + '</span>';
                            }
                        },
                        {
                            data: 'id',
                            orderable: false,
                            searchable: false,
                            render: function (id) {
                                return `
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ url('services/edit') }}/${id}" class="btn btn-sm btn-primary">View</a>
                                        <form method="post" action="{{ url('services/delete') }}" onsubmit="return confirm('Are you sure you want to delete this service?')" class="m-0">
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

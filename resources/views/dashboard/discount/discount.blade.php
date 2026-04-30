<x-app-layout :showDefaultNavigation="false">
    <div class="container py-5">
        <h5 class="fw-bold mb-2 ps-2">Discount</h5>
        <div class="mb-4">
            <a href="{{ url('discount/create') }}" class="btn btn-sm btn-success">
                + Create Discount
            </a>
        </div>

        <div class="card card-custom w-100">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Discount List</h6>
                <table id="example" class="table table-striped table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Discount Type</th>
                            <th>Discount Name</th>
                            <th>Value</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                        url: "{{ route('dashboard.discount.datatable') }}",
                        type: "GET"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'discount_type' },
                        { data: 'discount_name' },
                        { data: 'value' },
                        { data: 'start_date' },
                        { data: 'end_date' },
                        {
                            data: 'status',
                            render: function (data) {
                                data = (data || '').toLowerCase();
                                if (data === 'active') return '<span class="badge bg-success">Active</span>';
                                if (data === 'inactive') return '<span class="badge bg-danger">Inactive</span>';
                                return '<span class="badge bg-warning text-dark">' + data + '</span>';
                            }
                        },
                        {
                            data: 'id',
                            orderable: false,
                            searchable: false,
                            render: function (id) {
                                return `
                                    <div class="d-flex gap-1">
                                        <a href="{{ url('discount/edit') }}/${id}" class="btn btn-sm btn-primary">View</a>
                                        <form method="post" action="{{ url('discount/delete') }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
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

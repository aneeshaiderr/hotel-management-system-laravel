<x-app-layout :showDefaultNavigation="false">
    <div class="container py-5">
        <h5 class="fw-bold mb-2 mt-7 ps-2">Hotels</h5>
        <div class="mb-2">
            <a href="{{ url('hotel/create') }}" class="btn btn-sm btn-success" style="background-color:#16a34a; color:white;">
                + Create Hotel
            </a>
        </div>

        <div class="card card-custom w-100">
            <div class="card-body">
                <h6 class="mb-3 fw-bold">Hotel List</h6>
                <table id="example" class="table table-striped table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Hotel Name</th>
                            <th>Address</th>
                            <th>Contact</th>
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
                        url: "{{ url('hotel/datatable') }}",
                        type: "GET"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'hotel_name' },
                        { data: 'address' },
                        { data: 'contact_no' },
                        {
                            data: 'id',
                            orderable: false,
                            searchable: false,
                            render: function (id) {
                                return `
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ url('hotel/edit') }}/${id}" class="btn btn-sm btn-primary">View</a>
                                        <form class="delete-form d-inline" action="{{ url('hotel/delete') }}" method="post">
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

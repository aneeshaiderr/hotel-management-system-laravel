<x-app-layout :showDefaultNavigation="false">
    <div class="container py-5">
            <h5 class="ps-2">Users</h5>
            <div class="mb-3">
                <a href="{{ url('user/create') }}" class="btn btn-sm btn-success">
                    + Create User
                </a>
            </div>

            <div class="row g-3 align-items-start">
                <!-- Users Table Column -->
                <div class="col-lg-8 col-md-7">
                    <div class="card w-100">
                        <div class="card-body">
                            <h6 class="mb-3">Users List</h6>
                            <div class="table-responsive">
                                <table id="usersTable" class="table table-striped table-bordered align-middle w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Column -->
                <div class="col-lg-4 col-md-5">
                    <div class="card text-center w-100 profile-outer-card">
                        <div class="card-body profile-inner-card-body">
                            <h1 class="h5 mb-2">Angelica Ramos</h1>
                            <img src="{{ asset('assets_dashboard/img/avatar-3.jpg') }}" class="userprofile-pic mb-3" alt="Profile picture">
                            <div class="mb-3 text-start">
                                <h2 class="h6 mb-1">About me</h2>
                                <p class="small text-muted profile-text-ellipsis">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                            <div class="mb-3 text-start profile-info-container">
                                <div class="d-flex py-1 profile-info-row">
                                    <div class="text-muted small fw-bold w-50">Name</div>
                                    <div class="small ms-1">Angelica Ramos</div>
                                </div>
                                <div class="d-flex py-1 profile-info-row">
                                    <div class="text-muted small fw-bold w-50">Company</div>
                                    <div class="small ms-1">The Wiz</div>
                                </div>
                                <div class="d-flex py-1 profile-info-row">
                                    <div class="text-muted small fw-bold w-50">Email</div>
                                    <div class="small ms-1">angelica@ramos.com</div>
                                </div>
                                <div class="d-flex py-1 profile-info-row">
                                    <div class="text-muted small fw-bold w-50">Phone</div>
                                    <div class="small ms-1">+1234123123123</div>
                                </div>
                                <div class="d-flex align-items-center py-1 profile-info-row">
                                    <div class="text-muted small fw-bold w-50">Status</div>
                                    <span class="badge bg-success ms-1">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    pageLength: 5,
                    ajax: {
                        url: "{{ url('user/datatable') }}",
                        type: "GET"
                    },
                    columns: [
                        { data: 'username' },
                        { data: 'name' },
                        { data: 'email' },
                        {
                            data: 'id',
                            orderable: false,
                            render: function (id) {
                                return `
                                    <div class="d-flex">
                                        <a href="{{ url('user/edit') }}/${id}" class="btn btn-sm btn-primary me-1">View</a>
                                        <form method="post"
                                              action="{{ url('user/delete') }}"
                                              class="d-inline m-0"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            <input type="hidden" name="id" value="${id}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
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

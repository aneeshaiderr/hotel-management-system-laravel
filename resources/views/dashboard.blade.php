<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="{{ asset('assets_dashboard/css/style.css') }}">
</head>
<body>
    @include('dashPartials.sidebar')
    @include('dashPartials.nav')

    <main class="main-content">
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
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets_dashboard/js/script.js') }}"></script>
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
</body>
</html>

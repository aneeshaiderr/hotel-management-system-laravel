<?php

namespace App\Http\Controllers;

use App\Models\Room as RoomModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Room extends Controller
{
    public function index(Request $request)
    {
        return view('Frontend/room');
    }

    public function dashboardIndex()
    {
        return view('dashboard.rooms.index');
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $rooms = RoomModel::query()->select([
            'id',
            'hotel_id',
            'room_number',
            'floor',
            'status',
            'beds',
            'max_guests',
            'created_at',
        ]);

        return DataTables::eloquent($rooms)
            ->editColumn('created_at', static fn (RoomModel $room) => $room->created_at?->format('Y-m-d H:i'))
            ->toJson();
    }
}

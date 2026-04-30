<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Discount;
use App\Models\Room;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $current_uri = request()->segment(1) ?: 'dashboard';
        return view('dashboard.reservation.reservation', ['title' => 'Reservations', 'current_uri' => $current_uri]);
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $query = DB::table('reservations as r')
            ->select(
                'r.id', 'r.hotel_code', 'r.room_id', 'r.check_in', 'r.check_out', 'r.status',
                'u.email as email', 'h.hotel_name', 'd.discount_name'
            )
            ->leftJoin('users as u', 'r.user_id', '=', 'u.id')
            ->leftJoin('hotels as h', 'r.hotel_id', '=', 'h.id')
            ->leftJoin('discounts as d', 'r.discount_id', '=', 'd.id')
            ->whereNull('r.deleted_at');

        return DataTables::query($query)
            ->toJson();
    }

    public function create()
    {
        $users = User::all();
        $hotels = Hotel::all();
        $rooms = Room::all();
        $discounts = Discount::all();
        
        $current_uri = request()->segment(1) ?: 'dashboard';
        return view('dashboard.reservation.create', compact('users', 'hotels', 'rooms', 'discounts', 'current_uri'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'hotel_code' => 'required',
            'hotel_id' => 'required',
            'room_id' => 'required',
            'discount_id' => 'nullable',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|string'
        ]);
        
        // guest_id is required by DB schema
        $validatedData['guest_id'] = $validatedData['user_id'];

        Reservation::createReservation($validatedData);

        return redirect()->route('dashboard.reservation')->with('success', 'Reservation created successfully');
    }

    public function edit($id)
    {
        $reservation = Reservation::getReservationById($id);
        
        if (!$reservation) {
            return redirect()->route('dashboard.reservation')->with('error', 'Reservation not found');
        }

        $users = User::all();
        $hotels = Hotel::all();
        $rooms = Room::all();
        $discounts = Discount::all();

        $current_uri = request()->segment(1) ?: 'dashboard';
        return view('dashboard.reservation.edit', compact('reservation', 'users', 'hotels', 'rooms', 'discounts', 'current_uri'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $validatedData = $request->validate([
            'user_id' => 'required',
            'hotel_code' => 'required',
            'hotel_id' => 'required',
            'room_id' => 'required',
            'discount_id' => 'nullable',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|string'
        ]);

        $validatedData['guest_id'] = $validatedData['user_id'];

        Reservation::updateReservation($id, $validatedData);

        return redirect()->route('dashboard.reservation')->with('success', 'Reservation updated successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        Reservation::softDeleteById($id);

        return redirect()->route('dashboard.reservation')->with('success', 'Reservation deleted successfully');
    }
}

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

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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

        $query = Reservation::with(['user', 'hotel', 'discount']);

        // If not super-admin or staff, only show their own reservations
        if (Gate::denies('isStaff')) {
            $query->where('user_id', Auth::id());
        }

        return DataTables::eloquent($query)
            ->addColumn('email', function($row) {
                return $row->user ? $row->user->email : '';
            })
            ->addColumn('hotel_name', function($row) {
                return $row->hotel ? $row->hotel->hotel_name : '';
            })
            ->addColumn('discount_name', function($row) {
                return $row->discount ? $row->discount->discount_name : '';
            })
            ->toJson();
    }

    public function create()
    {
        $users = Gate::allows('isStaff') ? User::all() : User::where('id', Auth::id())->get();
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

        $reservation = new Reservation();
        $reservation->fill($validatedData);
        $reservation->save();

        return redirect()->route('dashboard.reservation')->with('success', 'Reservation created successfully');
    }

    public function edit($id)
    {
        $reservation = Reservation::with(['user', 'hotel', 'discount'])->find($id);
        
        if (!$reservation) {
            return redirect()->route('dashboard.reservation')->with('error', 'Reservation not found');
        }

        // Only staff/admin can edit reservations, or users can edit their own (if you want)
        // Following user request: users can create, but management is usually for staff
        if (Gate::denies('isStaff') && $reservation->user_id != Auth::id()) {
            abort(403);
        }

        $users = Gate::allows('isStaff') ? User::all() : User::where('id', Auth::id())->get();
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

        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->update($validatedData);
        }

        return redirect()->route('dashboard.reservation')->with('success', 'Reservation updated successfully');
    }

    public function delete(Request $request)
    {
        Gate::authorize('isStaff');
        $id = $request->input('id');
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->delete();
        }

        return redirect()->route('dashboard.reservation')->with('success', 'Reservation deleted successfully');
    }
}

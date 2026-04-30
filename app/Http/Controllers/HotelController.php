<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HotelController extends Controller
{
    public function index()
    {
        return view('dashboard.hotel.hotel');
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $hotels = Hotel::query()->select([
            'id',
            'hotel_name',
            'address',
            'contact_no',
            'created_at',
        ]);

        return DataTables::eloquent($hotels)
            ->editColumn('created_at', static fn (Hotel $hotel) => $hotel->created_at?->format('Y-m-d H:i'))
            ->toJson();
    }

    public function create()
    {
        return view('dashboard.hotel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_no' => 'required|string|max:50',
        ]);

        try {
            Hotel::create($request->only(['hotel_name', 'address', 'contact_no']));
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Hotel created successfully.']);
            }
            return redirect()->route('dashboard.hotel')->with('success', 'Hotel created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('dashboard.hotel.edit', compact('hotel'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_no' => 'required|string|max:50',
        ]);

        try {
            $hotel = Hotel::findOrFail($request->id);
            $hotel->update($request->only(['hotel_name', 'address', 'contact_no']));
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Hotel updated successfully.']);
            }
            return redirect()->route('dashboard.hotel')->with('success', 'Hotel updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $hotel = Hotel::findOrFail($request->id);
            $hotel->delete();
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Hotel deleted successfully.']);
            }
            return redirect()->route('dashboard.hotel')->with('success', 'Hotel deleted successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }
}

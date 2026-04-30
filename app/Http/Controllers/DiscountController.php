<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    public function index()
    {
        return view('dashboard.discount.discount');
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $discounts = Discount::query()->select([
            'id',
            'discount_type',
            'discount_name',
            'value',
            'start_date',
            'end_date',
            'status',
        ]);

        return DataTables::eloquent($discounts)
            ->toJson();
    }

    public function create()
    {
        return view('dashboard.discount.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount_type' => 'required|string',
            'discount_name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        try {
            Discount::create($request->all());
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Discount created successfully.']);
            }
            return redirect()->route('dashboard.discount')->with('success', 'Discount created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('dashboard.discount.edit', compact('discount'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'discount_type' => 'required|string',
            'discount_name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        try {
            $discount = Discount::findOrFail($request->id);
            $discount->update($request->all());
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Discount updated successfully.']);
            }
            return redirect()->route('dashboard.discount')->with('success', 'Discount updated successfully.');
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
            $discount = Discount::findOrFail($request->id);
            $discount->delete();
            if ($request->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Discount deleted successfully.']);
            }
            return redirect()->route('dashboard.discount')->with('success', 'Discount deleted successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return back()->with('error', $e->getMessage());
        }
    }
}

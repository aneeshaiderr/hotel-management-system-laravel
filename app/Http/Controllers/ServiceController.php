<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index()
    {
        return view('dashboard.services.service');
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $services = Service::query()->select([
            'id',
            'service_name',
            'status',
            'price',
        ]);

        return DataTables::eloquent($services)
            ->toJson();
    }

    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'price'        => 'required|numeric',
            'status'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
            ]);
        }

        $data = $request->only(['service_name', 'price', 'status']);

        try {
            Service::createService($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Service created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            return redirect('/services');
        }

        $service = Service::getById($id);

        if (!$service) {
            return redirect('/services')->with('error', 'Service not found!');
        }

        // Using 'edt' since that was the view name found earlier in the directory
        return view('dashboard.services.edt', [
            'service' => $service,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'           => 'required|integer',
            'service_name' => 'required|string|max:255',
            'price'        => 'required|numeric',
            'status'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
            ]);
        }

        $id = $request->input('id');
        $data = $request->only(['service_name', 'price', 'status']);

        try {
            Service::updateService($id, $data);
            return response()->json([
                'status' => 'success', 
                'message' => 'Service updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Something went wrong!'
            ]);
        }
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }

        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service ID missing'
            ]);
        }

        if (Service::softDeleteService($id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Service deleted successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Delete failed'
        ]);
    }
}

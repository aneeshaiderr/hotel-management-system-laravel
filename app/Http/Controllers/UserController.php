<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Normal user view
        return view('dashboard.user.index', [
            'user' => $user,
        ]);
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $users = User::query()->select([
            'id',
            'username',
            'name',
            'email',
        ]);

        return DataTables::eloquent($users)
            ->toJson();
    }

    public function create()
    {
        return view('dashboard.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'   => 'required|min:3',
            'name'       => 'required',
            'email'      => 'required|email',
            'password'   => 'required|min:6',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'validation',
                    'errors' => $validator->errors()
                ]);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['username', 'name', 'email']);
            $data['password'] = Hash::make($request->input('password'));

            $userId = User::createUser($data);

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'User created successfully!',
                    'user_id' => $userId
                ]);
            }
            return redirect()->route('dashboard.user')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Something went wrong: ' . $e->getMessage()
                ]);
            }
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::getUserWithInfo($id);

        if (!$user) {
            return redirect('/user')->with('error', 'User not found');
        }

        return view('dashboard.user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'         => 'required|integer',
            'username'   => 'required|min:3',
            'name'       => 'required',
            'email'      => 'required|email',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'validation',
                    'errors' => $validator->errors()
                ]);
            }
            return back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');
        $data = $request->only(['username', 'name', 'email']);

        try {
            $success = User::updateUserWithInfo($id, $data);

            if ($success) {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'User updated successfully'
                    ]);
                }
                return redirect()->route('dashboard.user')->with('success', 'User updated successfully');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to update user'
                    ]);
                }
                return back()->with('error', 'Failed to update user');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Server error: ' . $e->getMessage()
                ]);
            }
            return back()->with('error', 'Server error: ' . $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        if (!$id) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User ID missing'
                ]);
            }
            return back()->with('error', 'User ID missing');
        }

        if (User::softDeleteUser($id)) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User deleted successfully'
                ]);
            }
            return redirect()->route('dashboard.user')->with('success', 'User deleted successfully');
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Delete failed'
            ]);
        }
        return back()->with('error', 'Delete failed');
    }
}

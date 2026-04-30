<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Everyone can see this page, but the view will handle what to show
        return view('dashboard.user.index', [
            'user' => $user,
        ]);
    }

    public function datatable(Request $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $query = User::query()->select([
            'id',
            'username',
            'name',
            'email',
        ]);

        // If not super-admin or staff, only show self
        if (Gate::denies('isStaff')) {
            $query->where('id', Auth::id());
        }

        return DataTables::eloquent($query)
            ->toJson();
    }

    public function create()
    {
        Gate::authorize('isSuperAdmin');
        return view('dashboard.user.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('isSuperAdmin');
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
            $user = new User();
            $user->username = $data['username'] ?? '';
            $user->name     = $data['name'];
            $user->email    = $data['email'];
            $user->password = Hash::make($request->input('password'));
            $user->status   = 1;
            $user->role     = $request->input('role', 'user');
            $user->save();

            $userId = $user->id;

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
        // Users can only edit themselves, Super Admins can edit anyone
        if (Gate::denies('isSuperAdmin') && Auth::id() != $id) {
            abort(403);
        }

        $user = User::select('id', 'username', 'name', 'email')->find($id);

        if (!$user) {
            return redirect('/user')->with('error', 'User not found');
        }

        return view('dashboard.user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        
        // Users can only update themselves, Super Admins can update anyone
        if (Gate::denies('isSuperAdmin') && Auth::id() != $id) {
            abort(403);
        }
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
            $user = User::find($id);
            if ($user) {
                $success = $user->update([
                    'username' => $data['username'] ?? '',
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'role'     => $request->input('role', 'user'),
                ]);
            } else {
                $success = false;
            }

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
        Gate::authorize('isSuperAdmin');
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

        $user = User::find($id);
        if ($user && $user->delete()) {
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

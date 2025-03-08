<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);

        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->with('roles')
            ->paginate($perPage);

        $roles = Role::all();
        $statusOptions = User::getStatusOptions();

        return view('admin.users.index', compact('users', 'roles', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $statusOptions = User::getStatusOptions();
        return view('admin.users.create', compact('roles', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required',
                'status' => 'required|in:active,inactive,suspended',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'status' => $validated['status'],
            ]);

            $user->createWalletIfNotExists();

            $role = $request->has('role') ? $request->role : 'user';
            $user->assignRole($role);

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');

            } catch (ValidationException $e) {
                // Handle validation errors
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput();

            } catch (\Exception $e) {
                // Log unexpected errors
                \Log::error('User creation failed: ' . $e->getMessage());

                return redirect()->back()
                    ->with('error', 'An unexpected error occurred.')
                    ->withInput();
            }
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // $statusOptions = User::getStatusOptions();
        // return view('admin.users.show', compact('user', 'statusOptions'));
        // Eager load relationships to prevent N+1 queries

        $user->load([
            'profile',
            'roles',
            'wallets',
            'transactions' => function($query) {
                $query->latest()->take(5);
            }
        ]);

        return view('admin.users.show', compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $statusOptions = User::getStatusOptions();
        return view('admin.users.edit', compact('user', 'roles', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return DB::transaction(function () use ($request, $user) {

            try {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                    'password' => 'nullable|string|min:8|confirmed',
                    'role' => 'required',
                    'status' => 'required|in:active,inactive,suspended',
                ]);

                $userData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'status' => $validated['status'],
                    'role' => $validated['role'],

                ];

                if ($request->filled('password')) {
                    $userData['password'] = bcrypt($validated['password']);
                }

                $user->update($userData);

                if ($request->has('role')) {
                    $user->syncRoles($request->role);
                } else {
                    $user->syncRoles([]);
                }

                return redirect()->route('admin.users.index')
                    ->with('success', 'User updated successfully.');
            } catch (ValidationException $e) {
                // Handle validation errors
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput();

            } catch (\Exception $e) {
                // Log unexpected errors
                \Log::error('User updated failed: ' . $e->getMessage());

                return redirect()->back()
                    ->with('error', 'An unexpected error occurred.')
                    ->withInput();
            }
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Update user status via AJAX
     */
    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $user->update(['status' => $validated['status']]);

        return response()->json(['success' => true]);
    }
}


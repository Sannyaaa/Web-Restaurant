<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('isAdmin');

        $roles = Role::all();

        return view('dashboard.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('isAdmin');

        return view('dashboard.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $this->authorize('isAdmin');

        $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|max:255',
        ]);
        Role::create($request->all());
        return redirect()->route('role.index')->with('success','role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        $this->authorize('isAdmin');

        return view('dashboard.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $this->authorize('isAdmin');

        $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|max:255',
        ]);

        $role->update($request->all());

        return redirect()->route('role.index')->with('success','role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $this->authorize('isAdmin');

        $role->delete();

        return redirect()->route('role.index')->with('success','role deleted successfully');
    }
}

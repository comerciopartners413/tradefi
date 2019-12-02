<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Permission;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('permissions.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $permission = new Permission([
            'name'         => $request->get('name'),
            'display_name' => $request->get('display_name'),
            'description'  => $request->get('description'),
        ]);
        $this->validate($request, [
            'name' => 'required|unique:roles|max:255',
        ]);
        if ($permission->save()) {
            return redirect('/permissions/create')->with('success', $permission->name . ' has been added to roles successfully.');
        } else {
            return redirect('/permissions/create')->withInput()->with('danger', $permission->name . ' was not added to roles</a>');
        }
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
    }
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        if ($permission->update($request->all())) {
            return redirect('/permissions/create')->with('success', $permission->name . ' has been updated successfully.');
        } else {
            return redirect('/permissions/create')->withInput()->with('danger', $permission->name . ' was not added to roles');
        }
    }
    public function destroy($id)
    {
        //
    }

}

<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Role;
use TradefiUBA\Permission;
use TradefiUBA\Company;
use Illuminate\Http\Request;
use TradefiUBA\Menu;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    // Different functions, same View
    public function create()
    {
        $company_id = auth()->user()->company_id;

        $roles       = Role::where('company_id', $company_id)->get();
        $permissions = Permission::all();
        $companies = Company::all();

        if ($company_id == '1') {
          $menus       = Menu::where('route', '!=', '#')->get();
        } else {
          $menus       = Menu::where('route', '!=', '#')->whereDoesntHave('roles', function($q){
            $q->whereIn('name', ['admin', 'customer']);
          })->get();
        }
        
        return view('roles.create', compact('roles', 'permissions', 'companies', 'menus'));
    }
    // Different functions, same View
    public function create_uba()
    {
        $roles       = Role::where('company_id', '2')->get();
        $permissions = Permission::all();
        // $companies = Company::all();
        $menus       = Menu::where('route', '!=', '#')->whereDoesntHave('roles', function($q){
          $q->whereIn('name', ['admin', 'customer']);
        })->get();
        return view('roles.create', compact('roles', 'permissions', 'companies', 'menus'));
    }
    public function store(Request $request)
    {
      $this->validate($request, [
          'name' => 'required|unique:roles|max:255',
      ]);


        $role = new Role([
            'name'         => $request->get('name'),
            'display_name' => $request->get('display_name'),
            'description'  => $request->get('description'),
            'company_id'  => $request->get('company_id') ?? auth()->user()->company_id,
        ]);

        if ($role->save()) {
            if (!empty($request->permission)) {
              $role->attachPermissions($request->permission);
            }

            $role->menus()->detach();
            if (!empty($request->menus)) {
              $role->menus()->attach($request->menus);
            }

            return redirect()->back()->with('success', $role->name . ' has been added to roles successfully.');
        } else {
            return redirect()->back()->withInput()->with('danger', $role->name . ' was not added to roles</a>');
        }
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $role        = Role::find($id);
        $permissions = Permission::all();
        $permission  = $role->perms;
        $companies = Company::all();
        $role_menus = $role->menus;
        // dd($permission);

        $company_id = auth()->user()->company_id;
        if ($company_id == '1') {
          $menus       = Menu::where('route', '!=', '#')->get();
        } else {
          $menus       = Menu::where('route', '!=', '#')->whereDoesntHave('roles', function($q){
            $q->whereIn('name', ['admin', 'customer']);
          })->get();
        }

        return view('roles.edit', compact('role', 'permissions', 'permission', 'companies', 'role_menus', 'menus'));
    }
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if ($role->update($request->except(['permission', 'menus']))) {

          if (!empty($request->permission)) {
            $role->perms()->sync([]);
            $role->attachPermissions($request->permission);
          }

            $role->menus()->detach();
            if (!empty($request->menus)) {
              $role->menus()->attach($request->menus);
            }

            return redirect('/roles/create')->with('success', $role->name . ' has been updated successfully.');
        } else {
            return redirect('/roles/create')->withInput()->with('danger', $role->name . ' was not added to roles');
        }
    }
    public function destroy($id)
    {
        //
    }

    public function remove_menu($menu_id, $role_id)
    {
        $menu_role = Role::find($role_id);
        $menu      = $menu_role->menus->find($menu_id);
        if ($menu->delete()) {
            return redirect()->route('roles.create')->with('success', 'Menu was removed from ' . $menu_role->name . ' successfully');
        }
    }

    // List menus for a role
    public function list_menus($id)
    {
        $role       = Role::find($id);
        $role_menus = $role->menus->sortBy('parent_id');
        // dd($role_menus);
        return view('roles.menus', compact('role_menus', 'role'));
    }
}

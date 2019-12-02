<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\User;
use TradefiUBA\Role;
use TradefiUBA\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $workflowdata   = Workflow::all();
        $staff          = User::where('admin', 1)->get();
        $roles          = Role::select('display_name', 'id')->get();
        $admin_profiles = $staff->transform(function ($item, $key) {
            $item->name = $item->profile->fullname;
            return $item;
        });
        return view('workflow.create', compact('admin_profiles', 'roles', 'workflowdata'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'ModuleID' => 'unique:tblWorkflowData',
        ], [
            'ModuleID.unique' => 'Module has been mapped already',
        ]);
        $workflow = new Workflow($request->all());

        if ($workflow->save()) {
            return redirect()->route('workflow.create')->with('success', 'Workflow updated successfully');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $staff    = User::where('admin', 1)->get();
        $roles    = Role::select('display_name', 'id')->get();
        $workflow = Workflow::find($id);
        return view('workflow.edit', compact('workflow', 'staff', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $workflow = Workflow::find($id);
        if ($workflow->update($request->all())) {
            return redirect()->route('workflow.create')->with('success', 'Workflow has been updated successfully');
        } else {
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace Helvetiapps\LiveControls\Http\Controllers;

use Helvetiapps\LiveControls\Models\UserPermissions\UserPermission;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function create(){
        if(!config('livecontrols.userpermissions_enabled', false)){
            abort(404, 'User permissions disabled!');
        }
        
        return view('livecontrols::userpermissions.create');
    }

    public function store(Request $request){
        if(!config('livecontrols.userpermissions_enabled', false)){
            abort(404, 'User permissions disabled!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $userPermission = UserPermission::create($validated);

        if(!is_null($userPermission)){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'permissions'])->with('success', __('livecontrols::general.type_created', ['type' => __('livecontrols::admin.permission')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'permissions'])->with('exception',  __('livecontrols::general.type_not_created', ['type' => __('livecontrols::admin.permission')]));
    }

    public function edit(UserPermission $userPermission){
        if(!config('livecontrols.userpermissions_enabled', false)){
            abort(404, 'User permissions disabled!');
        }
        
        return view('livecontrols::userpermissions.edit', ['userPermission' => $userPermission]);
    }

    public function update(Request $request, UserPermission $userPermission){
        if(!config('livecontrols.userpermissions_enabled', false)){
            abort(404, 'User permissions disabled!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'description' => 'nullable|string'
        ]);

        if($userPermission->update($validated)){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'permissions'])->with('success',  __('livecontrols::general.type_updated', ['type' => __('livecontrols::admin.permission')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'permissions'])->with('exception',  __('livecontrols::general.type__not_updated', ['type' => __('livecontrols::admin.permission')]));
    }

    public function destroy(UserPermission $userPermission){
        if(!config('livecontrols.userpermissions_enabled', false)){
            abort(404, 'User permissions disabled!');
        }
        
        if($userPermission->delete()){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'permissions'])->with('success',  __('livecontrols::general.type_deleted', ['type' => __('livecontrols::admin.permission')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'permissions'])->with('exception',  __('livecontrols::general.type_not_deleted', ['type' => __('livecontrols::admin.permission')]));
    }
}

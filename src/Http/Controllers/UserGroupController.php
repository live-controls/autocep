<?php

namespace LiveControls\Http\Controllers;

use LiveControls\Models\UserGroups\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function create(){
        if(!config('livecontrols.usergroups_enabled', false)){
            abort(404, 'User groups disabled!');
        }

        return view('livecontrols::usergroups.create');
    }

    public function store(Request $request){
        if(!config('livecontrols.usergroups_enabled', false)){
            abort(404, 'User groups disabled!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'color' => 'required',
            'description' => 'nullable|string'
        ]);

        $userGroup = UserGroup::create($validated);

        if(!is_null($userGroup)){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'groups'])->with('success', __('livecontrols::general.type_created', ['type' => __('livecontrols::admin.user_group')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'groups'])->with('exception', __('livecontrols::general.type_not_created', ['type' => __('livecontrols::admin.user_group')]));
    }

    public function edit(UserGroup $userGroup){
        if(!config('livecontrols.usergroups_enabled', false)){
            abort(404, 'User groups disabled!');
        }
        
        return view('livecontrols::usergroups.edit', ['userGroup' => $userGroup]);
    }

    public function update(Request $request, UserGroup $userGroup){
        if(!config('livecontrols.usergroups_enabled', false)){
            abort(404, 'User groups disabled!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'color' => 'required',
            'description' => 'nullable|string'
        ]);

        if($userGroup->update($validated)){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'groups'])->with('success', __('livecontrols::general.type_updated', ['type' => __('livecontrols::admin.user_group')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'groups'])->with('exception', __('livecontrols::general.type_not_updated', ['type' => __('livecontrols::admin.user_group')]));
    }

    public function destroy(UserGroup $userGroup){
        if(!config('livecontrols.usergroups_enabled', false)){
            abort(404, 'User groups disabled!');
        }
        
        if($userGroup->delete()){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'groups'])->with('success', __('livecontrols::general.type_deleted', ['type' => __('livecontrols::admin.user_group')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'groups'])->with('exception', __('livecontrols::general.type_not_deleted', ['type' => __('livecontrols::admin.user_group')]));
    }
}

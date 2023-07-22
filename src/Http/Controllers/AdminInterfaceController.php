<?php

namespace LiveControls\Http\Controllers;

class AdminInterfaceController extends Controller
{
    public function index(){
        if(!config('livecontrols.admininterface_enabled', false)){
            abort('404', 'Admin Interface disabled!');
        }
        return view('livecontrols::admin.index');
    }
}

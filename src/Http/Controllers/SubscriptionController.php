<?php

namespace Helvetiapps\LiveControls\Http\Controllers;

use Helvetiapps\LiveControls\Models\Subscriptions\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function create(){
        if(!config('livecontrols.subscriptions_enabled', false)){
            abort(404, 'Subscriptions disabled!');
        }

        return view('livecontrols::subscriptions.create');
    }

    public function store(Request $request){
        if(!config('livecontrols.subscriptions_enabled', false)){
            abort(404, 'Subscriptions disabled!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'duration_in_days' => 'required|numeric'
        ]);

        $subscription = Subscription::create(
            array_merge(
                $validated,
                ['value_in_cents' => $validated["value"] * 100]
            )
        );

        if(!is_null($subscription)){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'subscriptions'])->with('success', __('livecontrols::general.type_created', ['type' => __('livecontrols::admin.subscription')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'subscriptions'])->with('exception', __('livecontrols::general.type_not_created', ['type' => __('livecontrols::admin.subscription')]));
    }

    public function edit(Subscription $subscription){
        if(!config('livecontrols.subscriptions_enabled', false)){
            abort(404, 'Subscriptions disabled!');
        }
        
        return view('livecontrols::subscriptions.edit', ['subscription' => $subscription]);
    }

    public function update(Request $request, Subscription $subscription){
        if(!config('livecontrols.subscriptions_enabled', false)){
            abort(404, 'Subscriptions disabled!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'duration_in_days' => 'required|numeric'
        ]);

        if($subscription->update(array_merge($validated, ['value_in_cents' => $validated["value"] * 100]))){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'subscriptions'])->with('success', __('livecontrols::general.type_updated', ['type' => __('livecontrols::admin.subscription')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'subscriptions'])->with('exception', __('livecontrols::general.type_not_updated', ['type' => __('livecontrols::admin.subscription')]));
    }

    public function destroy(Subscription $subscription){
        if(!config('livecontrols.subscriptions_enabled', false)){
            abort(404, 'Subscriptions disabled!');
        }
        
        if($subscription->delete()){
            return redirect()->route('livecontrols.admin.dashboard', ['p' => 'subscriptions'])->with('success', __('livecontrols::general.type_deleted', ['type' => __('livecontrols::admin.subscription')]));
        }
        return redirect()->route('livecontrols.admin.dashboard', ['p' => 'subscriptions'])->with('exception', __('livecontrols::general.type_not_deleted', ['type' => __('livecontrols::admin.subscription')]));
    }
}

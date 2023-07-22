<?php

namespace LiveControls\Http\Controllers;

use LiveControls\Models\Support\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(){
        if(!config('livecontrols.support_enabled', false)){
            abort('404', 'Support System disabled!');
        }

        if(auth()->user()->support_team){
            $supportTickets = SupportTicket::orderBy('created_at', 'desc')->paginate();
            return view('livecontrols::support.moderator.index', ['supportTickets' => $supportTickets]);
        }

        $supportTickets = auth()->user()->supportTickets()->paginate();
        return view('livecontrols::support.user.index', ['supportTickets' => $supportTickets]);
    }

    public function show(SupportTicket $supportTicket){
        if(!config('livecontrols.support_enabled', false)){
            abort('404', 'Support System disabled!');
        }
        
        //Check if user did create support ticket or if he is in support team
        if($supportTicket->user_id != auth()->id() && !auth()->user()->support_team){
            return abort(403);
        }
        return view('livecontrols::support.show', ['supportTicket' => $supportTicket]);
    }

    public function create(){
        if(!config('livecontrols.support_enabled', false)){
            abort('404', 'Support System disabled!');
        }
        
        if(auth()->user()->support_team){
            abort(403);
        }
        return view('livecontrols::support.user.create');
    }

    public function store(Request $request){
        if(!config('livecontrols.support_enabled', false)){
            abort('404', 'Support System disabled!');
        }
        
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'priority' => 'required'
        ]);

        $supportTicket = SupportTicket::create(array_merge($validated, [
            'status' => 0,
            'user_id' => auth()->id()
        ]));

        if(!is_null($supportTicket)){
            return redirect()->route('livecontrols.support.index')->with('success', __('livecontrols::general.type_created', ['type' => __('livecontrols::support.support_ticket')]));
        }
        return redirect()->route('livecontrols.support.index')->with('exception', __('livecontrols::general.type_not_created', ['type' => __('livecontrols::support.support_ticket')]));
    }

    public function destroy(SupportTicket $supportTicket){
        if(!config('livecontrols.support_enabled', false)){
            abort('404', 'Support System disabled!');
        }
        
        //Check if user did create support ticket or if he is in support team
        if($supportTicket->user_id != auth()->id() && !auth()->user()->support_team){
            return abort(403);
        }

        if($supportTicket->delete()){
            return redirect()->route('livecontrols.support.index')->with('success', __('livecontrols::general.type_deleted', ['type' => __('livecontrols::support.support_ticket')]));
        }
        return redirect()->route('livecontrols.support.index')->with('exception', __('livecontrols::general.type__not_deleted', ['type' => __('livecontrols::support.support_ticket')]));
    }

    public function reopen(SupportTicket $supportTicket){
        if(!config('livecontrols.support_enabled', false)){
            abort('404', 'Support System disabled!');
        }
        
        $supportTicket->update([
            'status' => 0
        ]);

        return redirect()->route('livecontrols.support.show', ['supportTicket' => $supportTicket])->popup([
            'type' => 'success',
            'message' => __('livecontrols::support.reopened')
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function dashboard()
    {
        $status = new Status();
        // dd($status->status());
        return response()->json($status->status());
    }
    public function store(Request $request)
    {
        $data = $request->getContent();
        $input = json_decode($data, true);
        $item = new Item();
        $parent = $item->where('item_id', $input['item_parent_id'])->first();
        $item_priority = $item->where('item_parent_id', $input['item_parent_id'])->max('item_priority');
        

        $item->level_id = $parent->level_id;
        $item->type_id = $input['type_id'];
        $item->category_id = $parent->category_id;
        $item->user_id = Auth::id();
        $item->item_parent_id = $input['item_parent_id'];
        $item->item_priority = $item_priority+5;
        $item->status_id = $input['status_id'];
        $item->item_title = $input['item_title'];
        //$item->save();
        if($item->save()){
            return response()->json($item->milestoneWithDetail($item->id));
        }
        // return response()->json($item->milestoneWithDetail($item->item_id));
        // return redirect()->route('posts');
    }
}

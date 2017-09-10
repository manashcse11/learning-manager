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
    public function __construct(\App\Models\Item $itemModel)
    {
        $this->middleware('auth');
        $this->itemModel = $itemModel;
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
    public function sort(Request $request)
    {
        $data = $request->getContent();
        $input = json_decode($data, true);
        $priority = countArrayItemsInsideArray($input, 'milestones') * 5; // Initial value, There will be 5 difference in each priority
        
        $this->itemModel->where('type_id', 5)->update(['item_priority' => 0]);
        foreach($input as $status){
            if(count($status['milestones']) > 0){
                foreach($status['milestones'] as $milestone){
                    $item['status_id'] = $status['status_id'];
                    $item['item_priority'] = $priority;
                    $this->itemModel->where('item_id', $milestone['item_id'])->update($item);
                    $priority = $priority - 5;
                }
            }
        }
        
        return response()->json(array('sorted' => true));
    }
}

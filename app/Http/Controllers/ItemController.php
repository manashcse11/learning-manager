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
    public function __construct(\App\Models\Item $itemModel, \App\Models\Status $statusModel, \App\Models\Color $colorModel)
    {
        $this->middleware('auth');
        $this->itemModel = $itemModel;
        $this->statusModel = $statusModel;
        $this->colorModel = $colorModel;
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
    public function dashboard() {
        $status = new Status();
        return response()->json($status->status());
    }
    public function store(Request $request) {
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
    }
    public function storeSubCategory(Request $request) {
        $data = $request->getContent();
        $input = json_decode($data, true);
        $item = new Item();
        $item->type_id = 3;
        $item->category_id = $input['category_id'];
        $item->user_id = Auth::id();
        // $item->item_parent_id = 0;
        $item->item_title = $input['item_title'];
        $item->item_description = isset($input['item_description']) ? $input['item_description'] : "";
        if($item->save()){
            return response()->json($item->itemByID($item->id));
        }
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
    public function show($id){
        $data['item'] = $this->itemModel->itemWithChild($id);
        $data['breadcrumb'] = $this->generateBreadcrumb($data['item']->item_id, $data['item']->type_id);
        $data['statuses'] = $this->statusModel->get();
        $data['colors'] = $this->colorModel->get();
        $data['status_count'] = $this->itemModel->countByStatus($id, $data['item']->type_id);
        return response()->json($data);
    }

    public function update($id, Request $request) {
        $data = $request->getContent();
        $input = json_decode($data, true);
        
        if($this->itemModel->where('item_id', $id)->update($input)){
            return response()->json(array('success' => true));
        }
    }
    public function generateBreadcrumb($item_id, $type_id){

        if(isMilestone($type_id)){
            $param = $this->itemModel->milestoneWithDetail($item_id);
            $breadcrumb['category'] = array('id' => $param->item->category->category_id, 'title' => $param->item->category->category_title);
            $breadcrumb['subcategory'] = array('id' => $param->item->subcategory->item_id, 'title' => $param->item->subcategory->item_title);
            $breadcrumb['item'] = array('id' => $param->item->item_id, 'title' => $param->item->item_title);
            $breadcrumb['milestone'] = $param->item_title;
            $breadcrumb['color'] = $param->item->color->color_code;
            return $breadcrumb;
        }     

        else if(isItem($type_id)){ // For example Angularjs or Laravel
            $param = $this->itemModel->where('item_id', $item_id)->with('color')->with('subcategory')->with('category')->first();
            $breadcrumb['category'] = array('id' => $param->category->category_id, 'title' => $param->category->category_title);
            $breadcrumb['subcategory'] = array('id' => $param->subcategory->item_id, 'title' => $param->subcategory->item_title);
            $breadcrumb['item'] = $param->item_title;
            $breadcrumb['milestone'] = "";
            $breadcrumb['color'] = $param->color->color_code;
            return $breadcrumb;
        }   

        else if(isSubCategory($type_id)){ // For example Language/Framework/Technology or Tool
            $param = $this->itemModel->where('item_id', $item_id)->with('category')->first();
            $breadcrumb['category'] = array('id' => $param->category->category_id, 'title' => $param->category->category_title);
            $breadcrumb['subcategory'] = $param->item_title;
            $breadcrumb['item'] = "";
            $breadcrumb['milestone'] = "";
            $breadcrumb['color'] = "#FEAF20";
            return $breadcrumb;
        }        
    }
    public function subcategories(){
        $data['subcategories'] = $this->itemModel->subcategoriesByUserID(Auth::id());
        return response()->json($data);
    }
}

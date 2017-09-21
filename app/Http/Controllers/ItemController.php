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
    public function dashboard()
    {
        $status = new Status();
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
    public function show($id){
        $data['item'] = $this->itemModel->where('item_id', $id)->first();
        $data['breadcrumb'] = $this->generateBreadcrumb($data['item']->item_id, $data['item']->type_id);
        $data['statuses'] = $this->statusModel->get();
        $data['colors'] = $this->colorModel->get();
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
    // public function generateBreadcrumb($item_id, $type_id){

    //     if(isMilestone($type_id)){
    //         $param = $this->itemModel->milestoneWithDetail($item_id);
    //         $breadcrumb = '<div style="border-bottom: 2px solid '. $param->item->color->color_code .'; border-left: 2px solid '. $param->item->color->color_code .'" class="panel-heading">
    //             <a href="#!category/'. $param->item->category->category_id .'" class="badge bgblue">'. $param->item->category->category_title .'</a> >> <a href="#!item/'. $param->item->subcategory->item_id .'" class="badge bgorange">'. $param->item->subcategory->item_title .'</a> >> <a href="#!item/'. $param->item->item_id .'" class="badge" style="background-color: '. $param->item->color->color_code .' !important;">'. $param->item->item_title .'</a> >> <span class="item-title">Milestone: '. $param->item_title .'</span>
    //         </div>';
    //         return $breadcrumb;
    //     }     

    //     else if(isItem($type_id)){ // For example Angularjs or Laravel
    //         $param = $this->itemModel->where('item_id', $item_id)->with('color')->with('subcategory')->with('category')->first();
    //         $breadcrumb = '<div style="border-bottom: 2px solid '. $param->color->color_code .'; border-left: 2px solid '. $param->color->color_code .'" class="panel-heading">
    //             <a href="#!category/'. $param->category->category_id .'" class="badge bgblue">'. $param->category->category_title .'</a> >> <a href="#!item/'. $param->subcategory->item_id .'" class="badge bgorange">'. $param->subcategory->item_title .'</a> >> '. $param->item_title .'</span>
    //         </div>';
    //         return $breadcrumb;
    //     }   

    //     else if(isSubCategory($type_id)){ // For example Language/Framework/Technology or Tool
    //         $param = $this->itemModel->where('item_id', $item_id)->with('category')->first();
    //         $breadcrumb = '<div style="border-bottom: 2px solid #FEAF20; border-left: 2px solid #FEAF20" class="panel-heading">
    //             <a href="#!category/'. $param->category->category_id .'" class="badge bgblue">'. $param->category->category_title .'</a> >> '. $param->item_title .'</span>
    //         </div>';
    //         return $breadcrumb;
    //     }        
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProgressController extends Controller
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
    public function groupByStatusSumByPoint($collect){
        return $grouped = $collect->groupBy('status_id')
        ->map(function ($item) {
            return $item->sum('item_point');
        });
    }

    public function processForProgressInput($grouped){
        foreach($grouped as $key => $val){
            $input = array();
            $input['status_id'] = $key;
            $input['total'] = $val;
            $inputs[] = $input;
        }
        return $inputs;
    }
    public function index()
    {
        $points = $this->itemModel->userAllMilestonesPointSumByStatus(Auth::id());
        foreach($points as $list){
            $grouped = $this->groupByStatusSumByPoint($list->milestones);
            $list->progress = $this->progress($this->processForProgressInput($grouped));
            unset($list->milestones);
        }
        $data['summary'] = $points;
        return response()->json($data);
    }

    public function show($id){
        $points = $this->itemModel->milestonesPointSumByStatus($id);
        $data['progress'] = $this->progress($points);
        return response()->json($data);
    }

    public function progress($points){
        $total_point = 0; 
        $achieved_point = 0;
        $done_status = array(3);
        foreach($points as $point){
            if(in_array($point['status_id'], $done_status)){
                $achieved_point = $achieved_point + $point['total'];
            }
            $total_point = $total_point + $point['total'];
        }
        return $achieved_percent = number_format((($achieved_point/$total_point) * 100), 2);
    }
}

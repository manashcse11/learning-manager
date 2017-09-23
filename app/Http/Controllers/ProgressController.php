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
    public function index()
    {
        return view('progress_summary');
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

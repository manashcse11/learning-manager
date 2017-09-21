<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\Status;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Item $itemModel, \App\Models\Status $statusModel)
    {
        $this->middleware('auth');
        $this->itemModel = $itemModel;
        $this->statusModel = $statusModel;
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
        $data['dashboard'] = $this->statusModel->status(Auth::id());
        $data['items'] = $this->itemModel->where('type_id', 4)->where('user_id', Auth::id())->get(); // 4 = item (e.g. Angularjs or Reactjs or Laravel)
        return response()->json($data);
    }
}

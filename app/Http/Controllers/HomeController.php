<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Status;

class HomeController extends Controller
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the Instruction.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instruction');
    }
}

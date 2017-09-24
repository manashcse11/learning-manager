<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Category $categoryModel)
    {
        $this->middleware('auth');
        $this->categoryModel = $categoryModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = $this->categoryModel->allCategory();
        return response()->json($data);
    }

    public function show($id){
        $data['category'] = $this->categoryModel->categoryByID($id);
        return response()->json($data);
    }

}

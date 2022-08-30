<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    /**
     * Display a listing of the resource
     */
    public function create(Request $request)
    {
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }
}
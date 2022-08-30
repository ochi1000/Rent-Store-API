<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    
    /**
     * Display a listing of the resource
     */
    public function index()
    {
        $equipments = Product::where('category_id', 2)->get();
        if($equipments->isEmpty()) $message = "No equipments found";
        return response()->json([
            "status"=> true,
            "message" => $message ?? "Equipments found",
            "data" => $equipments
        ], 200);
    }
    
    /**
     * Store a new resource
     */
    public function store(Request $request)
    {
        // validate
        $fields = $this->validate($request, [
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "string|max:500" 
        ]);

        $newEquipment = Product::create([
            "name" => $fields["name"],
            "price" => $fields["price"],
            "description" => $fields["description"],
            "category_id" => 2
        ]);

        return response()->json([
            "status"=> true,
            "message" => "Equipment created",
            "data" => $newEquipment
        ], 201);

    }

    /**
     * Show a specific resource
     */
    public function show($id)
    {
        $equipment = Product::where('category_id', 2)->find($id);
        
        // validate
        if(!$equipment) return response()->json([
            "status"=> false,
            "message" => "Equipment not found",
        ], 404);

        return response()->json([
            "status" => true,
            "message" => "Equipment found",
            "data" => $equipment
        ]);
    }

    /**
     * Update a resource
     */
    public function update(Request $request, $id)
    {
        $equipment = Product::where('category_id', 2)->find($id);
        
        // validate
        if(!$equipment) return response()->json([
            "status"=> false,
            "message" => "Equipment not found",
        ], 404);

        $fields = $this->validate($request, [
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "string|max:500" 
        ]);

        $equipment->update($fields);

        return response()->json([
            "status" => true,
            "message" => "Equipment updated",
            "data" => $equipment
        ]);
        
    }
    
    /**
     * Delete a resource
     */
    public function delete($id)
    {
        $equipment = Product::where('category_id', 2)->find($id);
        
        // validate
        if(!$equipment) return response()->json([
            "status"=> false,
            "message" => "Equipment not found",
        ], 404);

        $equipment->delete();

        return response()->json([
            "status" => true,
            "message" => "Equipment deleted",
        ]);
        
    }
    
}

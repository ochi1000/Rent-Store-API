<?php

namespace App\Http\Controllers;

use App\Product;
use App\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    
    /**
     * Display a listing of the resource
     */
    public function index()
    {
        $rents = Rent::with('product')->get();
        // validate
        if($rents->isEmpty()) $message = "No rents found";

        return response()->json([
            "status"=> true,
            "message" => $message ?? "Rents found",
            "data" => $rents
        ], 200);
    }
    
    /**
     * Display a listing of all books rented
     */
    public function rented_books()
    {
        // get books from rent model
        $rents = Rent::whereHas('product', function($q){
            $q->where('products.category_id', '=', 1);
        })->get();

        // validate
        if($rents->isEmpty()) $message = "No Book rents found";

        return response()->json([
            "status"=> true,
            "message" => $message ?? "Book rents found",
            "data" => $rents
        ], 200);
    }
    
    /**
     * Display a listing of all books rented
     */
    public function returned_books()
    {
        // get books from rent model
        $rents = Rent::where('returned', 1)->whereHas('product', function($q){
            $q->where('products.category_id', '=', 1);
        })->get();

        // validate
        return response()->json($rents);
        if($rents->isEmpty()) $message = "No Book rents found";

        return response()->json([
            "status"=> true,
            "message" => $message ?? "Book rents found",
            "data" => $rents
        ], 200);
    }
    
    /**
     * Display a listing of all equipments rented
     */
    public function rented_equipments()
    {
        // get equipments from rent model
        $rents = Rent::whereHas('product', function($q){
            $q->where('products.category_id', '=', 2);
        })->get();

        // validate
        if($rents->isEmpty()) $message = "No Equipment rents found";

        return response()->json([
            "status"=> true,
            "message" => $message ?? "Equipment rents found",
            "data" => $rents
        ], 200);
    }
    
    /**
     * Display a listing of all equipments rented
     */
    public function returned_equipments()
    {
        // get return equipments from rent model
        $rents = Rent::where('returned', 1)->whereHas('product', function($q){
            $q->where('products.category_id', '=', 2);
        })->get();

        // validate
        return response()->json($rents);
        if($rents->isEmpty()) $message = "No equipment rents found";

        return response()->json([
            "status"=> true,
            "message" => $message ?? "Equipment rents found",
            "data" => $rents
        ], 200);
    }
    
    /**
     * Store a new rent resource
     */
    public function store(Request $request)
    {
        // validate
        $fields = $this->validate($request, [
            "product_id" => "required|numeric",
            "price" => "required|numeric",
            "supposed_return_date" => "required|date|after:created_at" 
        ]);

        // check if product exists and is available
        $product = Product::find($fields["product_id"]);
        
        if(!$product) return response()->json([
            "status"=> false,
            "message" => "Product not found",
        ], 404);
        if(!$product->available) return response()->json([
            "status"=> false,
            "message" => "Product not available",
        ], 404);
        // var_dump($fields);return;
        // create new rent
        $newRent = Rent::create([
            "product_id" => $fields["product_id"],
            "price" => $fields["price"],
            "supposed_return_date" => $fields["supposed_return_date"],
        ]);

        // update availability of product
        $product->update([
            'available' => false
        ]);

        return response()->json([
            "status"=> true,
            "message" => "Rent made",
            "data" => $newRent
        ], 201);

    }
    
    /**
     * Return a rented product
     */
    public function returnRent($id)
    {
        // validate
        $rented = Rent::with('product')->find($id);

        // check if rent exists and is returnred        
        if(!$rented) return response()->json([
            "status"=> false,
            "message" => "Rent not found",
        ], 404);

        if($rented->returned) return response()->json([
            "status"=> false,
            "message" => "Rent already returned",
        ], 404);
        
        // return rent
        $rented->product->available = true;
        $rented->returned = true;
        $rented->returned_date = date("m/d/Y");
        $rented->push();
        

        return response()->json([
            "status"=> true,
            "message" => "Rent returned",
        ], 200);

    }

    /**
     * Show a specific resource
     */
    public function show($id)
    {
        $book = Product::where('category_id', 1)->find($id);
        
        // validate
        if(!$book) return response()->json([
            "status"=> false,
            "message" => "Book not found",
        ], 404);

        return response()->json([
            "status" => true,
            "message" => "Book found",
            "data" => $book
        ]);
    }

    /**
     * Update a resource
     */
    public function update(Request $request, $id)
    {
        $book = Product::where('category_id', 1)->find($id);
        
        // validate
        if(!$book) return response()->json([
            "status"=> false,
            "message" => "Book not found",
        ], 404);

        $fields = $this->validate($request, [
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "string|max:500" 
        ]);

        $book->update($fields);

        return response()->json([
            "status" => true,
            "message" => "Book updated",
            "data" => $book
        ]);
        
    }
    
    /**
     * Delete a resource
     */
    public function delete($id)
    {
        $book = Product::where('category_id', 1)->find($id);
        
        // validate
        if(!$book) return response()->json([
            "status"=> false,
            "message" => "Book not found",
        ], 404);

        $book->delete();

        return response()->json([
            "status" => true,
            "message" => "Book deleted",
        ]);
        
    }
    
}

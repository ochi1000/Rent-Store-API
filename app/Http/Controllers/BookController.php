<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    /**
     * Display a listing of the resource
     */
    public function index()
    {
        $books = Product::where('category_id', 1)->get();
        if($books->isEmpty()) $message = "No books found";
        return response()->json([
            "status"=> true,
            "message" => $message ?? "Books found",
            "data" => $books
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

        $newBook = Product::create([
            "name" => $fields["name"],
            "price" => $fields["price"],
            "description" => $fields["description"],
            "category_id" => 1
        ]);

        return response()->json([
            "status"=> true,
            "message" => "Book created",
            "data" => $newBook
        ], 201);

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

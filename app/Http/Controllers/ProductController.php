<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        if ($products) {
           return response()->json($products, 200);
        } else {
           return response()->json('No Product Found!');
        }
    }

    public function show ($id) {
       $product = Product::find($id);
       if ($product) {
        return response()->json($product, 200);
     } else {
        return response()->json('No Product Found!');
     }
    }


    public function store (Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|numeric',
                'brand_id' => 'required|numeric',
                'discount' => 'required|numeric',
                'amount' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

            ]);
            $product = new Product();
            $product->name=$request->name;

             // Handle the image upload
             if ($request->hasFile('image')) {
                 // Get the uploaded file
                 $file = $request->file('image');

                 // Generate a unique filename
                 $filename = time() . '.' . $file->getClientOriginalExtension();

                 // Define the path to store the image
                 $path = $file->storeAs('public/images', $filename);

                 // Save the file path to the database (assuming you have an 'image' column)
                 $product->image = $filename;
             }

            $product->save();
            return response()->json('Product added', 201);
         } catch(Exception $e) {
            return response()->json($e, 500);
         }
    }

    public function update_product($id, Request $request) {
        try {
            // Validate the request data
            $validated = $request->validate([
                'name' => 'required' . $id, // Update validation for unique name
                'price' => 'required|numeric',
                'category_id' => 'required|numeric',
                'brand_id' => 'required|numeric',
                'discount' => 'required|numeric',
                'amount' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            // Find the category by ID
            $product = Product::findOrFail($id);

            // Update the category name
            $product->name = $request->name;

            // Handle the image upload if provided
            if ($request->hasFile('image')) {
                // Get the uploaded file
                $file = $request->file('image');

                // Generate a unique filename
                $filename = time() . '.' . $file->getClientOriginalExtension();

                // Define the path to store the image
                $path = $file->storeAs('public/images', $filename);

                // Update the image path in the category
                $product->image = $filename;
            }

            // Save the category
            $product->save();

            return response()->json('Product updated', 200);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


      // Delete brand
      public function delete_product($id) {
          $product = Product::find($id);
          if($product) {
            $product->delete();
            return response()->json('Product deleted');
          } else {
            return response()->json('Product not found');
          }
      }

}

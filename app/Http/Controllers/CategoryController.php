<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Faker\Extension\FileExtension;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
      // Get all Categories
   public function index() {
    $categories = Category::all();
    return response()->json($categories, 200);
  }

  //Show a single category
  public function show ($id) {
    $category = Category::find($id);
    if($category) {
       return response()->json($category, 200);
    } else {
       return response()->json('Brand not found');
    }
  }

  //Save a category
  public function store(Request $request) {
    try {
       $validated = $request->validate([
           'name' => 'required|unique:brands,name',
           'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

       ]);
       $category = new Category();
       $category->name=$request->name;

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Get the uploaded file
            $file = $request->file('image');

            // Generate a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Define the path to store the image
            $path = $file->storeAs('public/images', $filename);

            // Save the file path to the database (assuming you have an 'image' column)
            $category->image = $filename;
        }

       $category->save();
       return response()->json('Category added', 201);
    } catch(Exception $e) {
       return response()->json($e, 500);
    }
  }

  //Update brand
public function update_category($id, Request $request) {
    try {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $id, // Update validation for unique name
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // Make image validation nullable
        ]);

        // Find the category by ID
        $category = Category::findOrFail($id);

        // Update the category name
        $category->name = $request->name;

        // Handle the image upload if provided
        if ($request->hasFile('image')) {
            // Get the uploaded file
            $file = $request->file('image');

            // Generate a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Define the path to store the image
            $path = $file->storeAs('public/images', $filename);

            // Update the image path in the category
            $category->image = $filename;
        }

        // Save the category
        $category->save();

        return response()->json('Category updated', 200);
    } catch(Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


  // Delete brand
  public function delete_category($id) {
      $category = Category::find($id);
      if($category) {
        $category->delete();
        return response()->json('Category deleted');
      } else {
        return response()->json('Category not found');
      }
  }
}

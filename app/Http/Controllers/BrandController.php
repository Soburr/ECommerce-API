<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
  // Get all brands
   public function index() {
     $brands = Brand::all();
     return response()->json($brands, 200);
   }

   //Show a single brand
   public function show ($id) {
     $brand = Brand::find($id);
     if($brand) {
        return response()->json($brand, 200);
     } else {
        return response()->json('Brand not found');
     }
   }

   //Save a brand
   public function store(Request $request) {
     try {
        $validated = $request->validate([
            'name' => 'required|unique:brand,name'
        ]);
        $brand = new Brand();
        $brand->name=$request->name;
        $brand->save();
        return response()->json('brand added', 201);
     } catch(Exception $e) {
        return response()->json($e, 500);
     }
   }

   //Update brand
   public function update_brand($id, Request $request) {
       try{
        $validated = $request->validate([
            'name' => 'required|unique:brand,name'
        ]);
        Brand::where('id', $id)->update([
            'name' => $request->name
        ]);
        return response()->json('brand updated', 200);
       } catch(Exception $e) {
        return response()->json($e, 500);
     }
   }

   // Delete brand
   public function delete_brand($id) {
       $brand = Brand::find($id);
       if($brand) {
         $brand->delete();
         return response()->json('brand deleted');
       } else {
         return response()->json('brand not found');
       }
   }

}


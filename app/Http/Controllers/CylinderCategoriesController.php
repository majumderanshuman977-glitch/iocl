<?php

namespace App\Http\Controllers;

use App\Models\CylinderCategories;
use Illuminate\Http\Request;

class CylinderCategoriesController extends Controller
{
    public function index(){
    
        $cylinderCategories = CylinderCategories::with('creator')->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('cylinder_categories.index',compact('cylinderCategories'));
    }

   public function store(Request $request){
        $user=auth()->user();
        $request->validate([
            'name' => 'required|string|unique:cylinder_categories,name'
        ],[
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
        ]);
              $cylinderCategories = new CylinderCategories();
              $cylinderCategories->name = $request->name;
              $cylinderCategories->created_by = $user->id;
              $cylinderCategories->save();
        return redirect()->route('cylinder-category.list')->with('success', 'Cylinder category created successfully.');
   }

   public function update(Request $request, $id){
         $request->validate([
            'name' => 'required|string|unique:cylinder_categories,name,'.$id
         ])
         ;
         $cylinderCategories = CylinderCategories::findOrFail($id);
         $cylinderCategories->name = $request->name;
         $cylinderCategories->save();
        return redirect()->route('cylinder-category.list')->with('success', 'Cylinder category updated successfully.');
   }

   public function updateStatus(Request $request){
        $cylinderCategory = CylinderCategories::findOrFail($request->id);
        $cylinderCategory->status = $cylinderCategory->status == 1 ? 0 : 1;
        $cylinderCategory->save();

        return response()->json([
            'success' => true,
            'message' => 'Cylinder category status updated successfully'
        ]);
   }
}

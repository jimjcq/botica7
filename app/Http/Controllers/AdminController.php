<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;

class AdminController extends Controller
{
    // Category categories
    public function categories(){
        return view('admin.categories');
    }
    public function dtcategories(){
        $categories = Category::all();

        return datatables()->of(
            $categories
        )->toJson();
    }
    public function savecategories(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $category = new Category();
            }else{
                $category = Category::find($request->id);
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->state = $request->state;
            $category->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deletecategories($id)
    {
        $category = category::find($id);
        $category->state = 0;
        $category->save();
        return response()->json(true);
    }

}

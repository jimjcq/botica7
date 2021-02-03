<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Product;
use App\Service;
use App\Promotion;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    // Services services
    public function services(){
        return view('admin.services');
    }
    public function dtservices(){
        $services = Service::all();

        return datatables()->of(
            $services
        )->toJson();
    }
    public function saveservices(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $service = new Service();
            }else{
                $service = Service::find($request->id);
            }

            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->state = $request->state;
            $service->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deleteservices($id)
    {
        $service = Service::find($id);
        $service->state = 0;
        $service->save();
        return response()->json(true);
    }

    // Promotions promotions
    public function promotions(){
        return view('admin.promotions');
    }
    public function dtpromotions(){
        $promotions = Promotion::all();

        return datatables()->of(
            $promotions
        )->toJson();
    }
    public function savepromotions(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $promotion = new Promotion();
            }else{
                $promotion = Promotion::find($request->id);
            }

            $promotion->name = $request->name;
            $promotion->description = $request->description;
            $promotion->state = $request->state;
            $promotion->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deletepromotions($id)
    {
        $promotion = Promotion::find($id);
        $promotion->state = 0;
        $promotion->save();
        return response()->json(true);
    }

    // Products products
    public function products(){
        $categories = Category::where('state', 1)->get();
        return view('admin.products', compact('categories'));
    }
    public function dtproducts(){
        $products = Product::with('category')->get();

        return datatables()->of(
            $products
        )->toJson();
    }
    public function saveproducts(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $product = new Product();
            }else{
                $product = Product::find($request->id);
            }

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->expiration = $request->expiration;
            $product->stock = $request->stock;
            $product->state = $request->state;
            $product->category_id = $request->category_id;
            $product->save();

            /*
            $table->string('name');
            $table->string('description')->nullable();
            $table->double('price');
            $table->date('expiration');
            $table->integer('stock');
            $table->boolean('state');
            $table->foreignId('category_id');
            */

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deleteproducts($id)
    {
        $product = Product::find($id);
        $product->state = 0;
        $product->save();
        return response()->json(true);
    }

    // User users
    public function users(){ return view('admin.users'); }
    public function dtusers(){
        $users = User::all();
        return datatables()->of( $users )->toJson();
    }
    public function saveusers(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $user = new User();
            }else{
                $user = User::find($request->id);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            if($request->password != null)
                $user->password = Hash::make($request->password);

            $user->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }

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
        $category = Category::find($id);
        $category->state = 0;
        $category->save();
        return response()->json(true);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ProductController extends Controller
{

    public function index(){
        $product= Product::all();
        return response()->json([
            'success' => true,
            'message'=> "Data fetched succesfully",
            'data' => $product,
            ]);
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'slug'=>'required',
            'price'=>'required'
        ]);
       $data = Product::create($request->all());
       return response()->json([
        'success' => true,
        'message'=> "Data inserted succesfully",
        'data' => $data,
        ]);

    }

    public function update(Request $request,$id)
    {
        //
        $product=Product::find($id);
        $product->update($request->all());
        return response()->json([
            'success' => true,
            'message'=> "Data updated succesfully",
            'data' => $product,
            ]);

    }

    public function destroy($id)
    {
        //
        $product= Product::destroy($id);
        return response()->json([
            'success' => true,
            'message'=> "Data deleted succesfully",
            'data' => $product,
            ]);
    }

    public function search($name)
    {
        //
        $product= Product::where('name','like','%'.$name.'%')->get();
        return response()->json([
            'success' => true,
            'message'=> "Data found succesfully!",
            'data' => $product,
            ]);
    }
}

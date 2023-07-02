<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(5);
    
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

  
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $product = new Product();
        $product->name = $request->name;
        $product->details = $request->detail;

        if($product->save()){
            return redirect()->route('products.index')
            ->with('success','Product created successfully.');
        }
        else{
            return redirect()->route('products.index')->with('error', 'Data failed to add');
        }
        
    }

    
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->detail = $request->detail;

        if ( $product->save()){
            return redirect()->route('products.index')
            ->with('success','Product updated successfully');
        }
        else{
            return redirect()->route('products.index')->with('error', 'Data failed to add');
        }
    
        
    }

   

    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}

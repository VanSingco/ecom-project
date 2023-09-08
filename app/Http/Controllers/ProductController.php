<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetched products',
            'products' => $products
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        
        $image_path = $this->uploadFile($request->image);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $image_path,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created',
            'product' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        
        if ($product) {

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully retrieve product',
                'product' => $product
            ]);

        } else  {

            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);

        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);

        }

        $product_data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ];

        if (isset($request->image) && $request->hasFile('image')) {
            $product_data['image'] = $this->uploadFile($request->image);
        }
        
        $product->update($product_data);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully deleted',
        ]);
    }

    public function uploadFile($file) {
        return Storage::putFile('products', $file);
    }
}

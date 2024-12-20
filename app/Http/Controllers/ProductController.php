<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {

        $products = Product::getProducts();
        $totalSum = 0;
        foreach ($products as $product) {
            $totalSum += $product['total_value'];
        }
        return view('products.index', compact('products', 'totalSum'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'quantity' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0'
            ]);

            Product::createProduct($validated);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'products' => Product::getProducts()
                ]);
            }

            return redirect()->route('products.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'edit-name' => 'required|string',
                'edit-quantity' => 'required|integer|min:0',
                'edit-price' => 'required|numeric|min:0'
            ]);

            $updatedProduct = Product::updateProduct($id, $validated);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'product' => $updatedProduct,
                    'products' => Product::getProducts()
                ]);
            }

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

}

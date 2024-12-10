<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    public static function getProducts()
    {
        $path = 'products.json';

        // if (!Storage::exists($path)) {
        //     Storage::put($path, json_encode([]));
        // }
        // return json_decode(Storage::get($path), true) ?? [];

        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, json_encode([]));
        }

        return json_decode(Storage::disk('public')->get($path), true) ?? [];
    }

    public static function createProduct($data)
    {
        $products = self::getProducts();

        $newProduct = [
            'name' => $data['name'],
            'quantity' => intval($data['quantity']),
            'price' => floatval($data['price']),
            'datetime' => now()->format('Y-m-d H:i:s'),
            'total_value' => intval($data['quantity']) * floatval($data['price'])
        ];

        $products[] = $newProduct;
        Storage::disk('public')->put('products.json', json_encode($products));

        return $newProduct;
    }

    public static function updateProduct($id, $data)
    {
        $products = self::getProducts();

        if (!isset($products[$id])) {
            throw new \Exception('Product not found.');
        }

        $products[$id]['name'] = $data['edit-name'];
        $products[$id]['quantity'] = intval($data['edit-quantity']);
        $products[$id]['price'] = floatval($data['edit-price']);
        $products[$id]['datetime'] = now()->format('Y-m-d H:i:s');
        $products[$id]['total_value'] = intval($data['edit-quantity']) * floatval($data['edit-price']);

        Storage::disk('public')->put('products.json', json_encode($products));

        return $products[$id];
    }

}

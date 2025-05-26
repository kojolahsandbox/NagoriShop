<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // limit 10
        $products = $products->take(10);
        // random
        $products = $products->shuffle();
        // desc
        $products = $products->sortByDesc('created_at');


        foreach ($products as $product) {
            $product->variants = ProductVariant::where('product_id', $product->id)->get();
            $product->seller = User::find($product->seller_id);
        }

        $data = [
            'products' => $products
        ];

        return view('landing.index', $data);

    }

    public function show($name, $slug)
    {
        $name = str_replace('-', ' ', $name);
        $slug = str_replace('-', ' ', $slug);

        $user = User::where('name', $name)->first();
        $product = Product::where('name', $slug)->first();

        $others = Product::all();
        // limit 10
        $others = $others->take(10);
        // random
        $others = $others->shuffle();
        // desc
        $others = $others->sortByDesc('created_at');

        if ($user && $product) {
            $product->variants = ProductVariant::where('product_id', $product->id)->get();
            $product->seller = User::find($product->seller_id);

            $data = [
                'product' => $product,
                'others' => $others
            ];

            return view('landing.show', $data);
        } else {
            echo "Product Tidak ada.";
        }
    }
}

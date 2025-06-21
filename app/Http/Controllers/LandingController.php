<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\OrderItem;

class LandingController extends Controller
{
    public function index()
    {
        $slide = Setting::all();

        $slides = [
            'slide1' => $slide[0]->option_value,
            'slide2' => $slide[1]->option_value,
            'slide3' => $slide[2]->option_value,
        ];

        $products = Product::all();
        // limit 10
        $products = $products->take(10);
        // random
        $products = $products->shuffle();
        // desc
        $products = $products->sortByDesc('created_at');

        // 6 products best seller
        $best_seller = Product::select('products.*')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('products.*, SUM(order_items.quantity) as total_quantity')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->take(4)
            ->get();

        // product with category flash sale 
        $flash_sale = Product::where('category', 'flash sale')
            ->get()
            ->shuffle()
            ->take(6);
        $data = [
            'slides' => $slides,
            'products' => $products,
            'best_seller' => $best_seller,
            'flash_sale' => $flash_sale
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
            return view('404');
        }
    }

    public function search(Request $request)
    {
        $search = $request->query('keyword');

        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('category', 'like', '%' . $search . '%')
            ->orWhereHas('seller', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
            ->take(10)
            ->get();

        foreach ($products as $p) {
            $p->variants = ProductVariant::where('product_id', $p->id)->get();
            $p->seller = User::find($p->seller_id);
        }

        $others = Product::inRandomOrder()->take(10)->get();

        return view('landing.search', [
            'products' => $products,
            'others' => $others
        ]);

    }


}

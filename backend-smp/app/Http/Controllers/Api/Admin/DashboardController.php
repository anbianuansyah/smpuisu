<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Post;
use App\Models\Product;
use App\Models\Guru;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //count categories
        $categories = Category::count();

        //count posts
        $posts = Post::count();

        //count products
        $products = Product::count();

        //count gurus
        $gurus = Guru::count();

        //return response json
        return response()->json([
            'success'   => true,
            'message'   => 'List Data on Dashboard',
            'data'      => [
                'categories' => $categories,
                'posts'      => $posts,
                'products'   => $products,
                'gurus'  => $gurus,
            ]
        ]);
    }
}
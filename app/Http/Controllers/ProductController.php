<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    private $base_url = 'https://dummyjson.com';

   public function getProducts(Request $request) {

    try {
        $size = isset($request->size) ? $request->size : 10;
        $page = isset($request->page) ? $request->page - 1 : 0;
        $skip =  $page * $size;

        $response = null;
        $indexes = 'title,price,thumbnail';
        if (isset($request->search)) {
            $search = "q=$request->search";
            $response = Http::get("$this->base_url/products/search?$search&select=$indexes&limit=$size&skip=$skip");
        } else {
            $response = Http::get("$this->base_url/products?limit=$size&skip=$skip&select=$indexes");
        }

        if ($response) {
            $products =  $response->json();
            return response()->json(['success' => true, 'content' => $products['products']], 200);

        }

        return response()->json(['success' => false, 'message' => 'Failed to get products'], 400);
     
    } catch (\Throwable $th) {
        return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
    }

   }

   public function getProduct(Request $request) {
    try {
        $id = $request->id;
        $response = Http::get("$this->base_url/products/$id");

        $product =  $response->json();


        if (!$product)
        return response()->json(['success' => false, 'message' => 'Failed to get product'], 400);
     
         return response()->json(['success' => true, 'content' => $product], 200);
    } catch (\Throwable $th) {
        return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
    }
   }
}

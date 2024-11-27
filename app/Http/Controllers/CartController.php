<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();
        $product_slug = $product_info->product_slug;

        $content = Cart::getContent(); // Corrected method to get cart contents
        $kiemtra = false;
        
        foreach ($content as $v_content) {
            if ($v_content->id == $productId) { // Check if the product is already in the cart
                if ($request->qty > $product_info->product_num - $v_content->quantity) {
                    Session::put('message', 'Số lượng vượt quá số lượng trong kho');
                    return redirect::to('chi-tiet-san-pham/'.$product_slug);
                } else {
                    $kiemtra = true;
                }
            }
        }

        // Check if quantity is valid or update the cart
        if ($quantity <= $product_info->product_num || $kiemtra) {
            $data = [
                'id' => $product_info->product_id,
                'name' => $product_info->product_name,
                'quantity' => $quantity,
                'price' => $product_info->product_price,
                'attributes' => ['image' => $product_info->product_image],
            ];

            Cart::add($data);
            return Redirect::to('/show-cart');
        } else {
            Session::put('message', 'Số lượng vượt quá số lượng trong kho');
            return redirect::to('chi-tiet-san-pham/'.$product_slug);
        }
    }

    public function show_cart(Request $request) {
        // SEO
        $meta_desc = "Giỏ hàng của bạn"; 
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        // SEO

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get(); 

        return view('pages.cart.show_cart', [
            'category' => $cate_product,
            'brand' => $brand_product,
            'meta_desc' => $meta_desc,
            'meta_keywords' => $meta_keywords,
            'meta_title' => $meta_title,
            'url_canonical' => $url_canonical
        ]);
    }

    public function delete_to_cart($rowId) {
        Cart::remove($rowId); // Correct method for removing item from cart
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $request) {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;

        $content = Cart::getContent(); // Correct method to get cart contents
        
        foreach ($content as $v_content) {
            $product_info = DB::table('tbl_product')->where('product_id', $v_content->id)->first();
            if ($qty > $product_info->product_num) {
                Session::put('message', 'Số lượng vượt quá số lượng trong kho');
                return Redirect::to('/show-cart');
            } else {
                Cart::update($rowId, ['quantity' => $qty]);
            }
        }

        return Redirect::to('/show-cart');
    }
}

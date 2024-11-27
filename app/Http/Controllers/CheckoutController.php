<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Darryldecode\Cart\Facades\CartFacade as Cart; // Update Cart facade import
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
use App\City;

class CheckoutController extends Controller
{
    public function login_checkout(Request $request)
    {
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get(); 

        return view('pages.checkout.login_checkout')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }

    public function add_customer(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect::to('/checkout');
    }

    public function checkout(Request $request)
    {
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get(); 
        return view('pages.checkout.show_checkout')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }

    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        
        if ($result) {
            Session::put('customer_id', $result->customer_id);
            Session::put('customer_name', $result->customer_name);
            Session::put('customer_email', $result->customer_email);
            Session::put('customer_phone', $result->customer_phone);
            return Redirect::to('/checkout');
        } else {
            return Redirect::to('/login-checkout');
        }
    }

    public function logout_checkout()
    {
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_method'] = $request->shipping_method;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_email', $request->shipping_email);
        Session::put('shipping_id', $shipping_id);

        return Redirect::to('/payment');
    }

    public function payment(Request $request)
    {
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get(); 
        return view('pages.checkout.payment')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }

    public function order_place(Request $request)
    {
        // Insert payment method
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        // Insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::getTotal();  // Updated to use Cart::getTotal() for total
        $order_data['order_status'] = 1;
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
        $body_message = 'mã đơn hàng  ' . $order_id . ' tổng tiền: ' . $order_data['order_total'];

        // Insert order details
        $content = Cart::getContent(); // Updated to use Cart::getContent() for cart items
        foreach ($content as $v_content) {
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->quantity;
            DB::table('tbl_order_details')->insert($order_d_data);
        }

        // Update product quantity in the product table
        $datapro = array();
        foreach ($content as $v_content) {
            $product_info = DB::table('tbl_product')->where('product_id', $v_content->id)->first(); 
            $datapro['product_num'] = $product_info->product_num - $v_content->quantity;
            DB::table('tbl_product')->where('product_id', $v_content->id)->update($datapro);     
        }

        if ($data['payment_method'] == 1) {
            echo 'Thanh toán thẻ ATM';
        } elseif ($data['payment_method'] == 2) {
            Cart::clear();  // Updated to use Cart::clear() to empty the cart
            $to_name = Session::get('customer_name');
            $to_email = Session::get('shipping_email'); // Send to this email
            $data = array("name" => $body_message, "body" => 'Mail gửi về vấn đề hàng hóa'); // Body of mail.blade.php

            Mail::send('pages.send_mail', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Đơn hàng được gửi từ shop Laravel');
                $message->from($to_email, $to_name);
            });
        } else {
            echo 'Thẻ ghi nợ';
        }

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '1')->orderby('brand_id', 'desc')->get(); 
        return view('pages.checkout.handcash')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }
}

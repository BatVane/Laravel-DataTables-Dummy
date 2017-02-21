<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DTController extends Controller
{
    //function to access the view only
    public function index(){

    	return view('index');
    }

    //function to retrieve products from database , handle searching and sorting
    public function fetchProducts(Request $request){

        //fecth products by using Fluent
    	$products = DB::table('products');

        //get all the parameters from the session
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'];
        $orderColumn = isset($request->get('order')[0]['column']) ? $request->get('order')[0]['column'] : '';
        $dir = isset($request->get('order')[0]['dir']) ? $request->get('order')[0]['dir'] : ''; 

        //search
        if ($search) {
            $products = $products->where('productName', 'LIKE', '%'. $search .'%')
                                    ->orWhere('productVendor', 'LIKE', '%'. $search .'%');
        }

        //count the total records and send them to the front-end
        $recordsTotal = $products->count();

        $orderBy = [
            //0 => 'productName',
            1 => 'productVendor',
            //2 => 'another column', // in case you want to add more columns
            
        ];

        //Datable sorts by the first column by default so we're gonna add these conditions
        if ($orderColumn !== '0') {
            if (in_array($orderColumn, array_keys($orderBy))) {
                $products = $products->orderBy($orderBy[$orderColumn], $dir);
            }
        } else {
            if ($dir === 'desc') {
                $products = $products->orderBy('productName', 'desc');
            } else {
                $products = $products->orderBy('productName', 'asc');
            }
        }

        //check the length parameter and then take records
        if ($length > 0) {
            $products = $products->skip($start)->take($length);
        }

        $products = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $products->get()->all()
        ];

    	return json_encode($products);
    }

    public function updateProduct(Request $request){
        dd($request->all());
        //return; 
    }
}

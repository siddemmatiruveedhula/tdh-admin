<?php

namespace App\Http\Controllers\Pos;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function ProductAll(){

        $product = Product::latest()->get();
        return view('backend.product.product_all',compact('product'));

    } // End Method 


    public function ProductAdd(){

        $supplier = Supplier::active()->get();
        $category = Category::active()->get();
        $unit = Unit::active()->get();
        $brands = Brand::active()->get();
        return view('backend.product.product_add',compact('supplier','category','unit','brands'));
    } // End Method 


    public function ProductStore(Request $request){

        Product::insert([

            'name' => $request->name,
            // 'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id, 
            'default_price' => $request->default_price,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'quantity' => '0',
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

            'gst' => $request->gst,
            'hsn_no' => $request->hsn_no,
            'is_cess' => $request->is_cess,
            'ad_val' => $request->ad_val,
            'is_promo_sku' => $request->is_promo_sku,
            'units_per_case' => $request->units_per_case,
            'sku_code' => $request->sku_code,
            'product_description' => $request->product_description,
            'total_weight_in_qtl' => $request->total_weight_in_qtl,
        ]);

        $notification = array(
            'message' => 'Product Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('product.all')->with($notification); 

    } // End Method 



    public function ProductEdit($id){
        
        $product = Product::findOrFail($id);
        $supplier = Supplier::active()->orWhere('id', '=', $product['supplier_id'])->get();
        // $supplier = Supplier::active()->get();
        $category = Category::active()->orWhere('id', '=', $product['category_id'])->get();
        $unit = Unit::active()->orWhere('id', '=', $product['unit_id'])->get();
        $brands = Brand::active()->orWhere('id', '=', $product['brand_id'])->get();
        return view('backend.product.product_edit',compact('product','supplier','category','unit','brands'));
    } // End Method 



    public function ProductUpdate(Request $request){

        $product_id = $request->id;

         Product::findOrFail($product_id)->update([

            'name' => $request->name,
            // 'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id, 
            'brand_id' => $request->brand_id, 
            'default_price' => $request->default_price,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,

            'gst' => $request->gst,
            'hsn_no' => $request->hsn_no,
            'is_cess' => $request->is_cess,
            'ad_val' => $request->ad_val,
            'is_promo_sku' => $request->is_promo_sku,
            'units_per_case' => $request->units_per_case,
            'sku_code' => $request->sku_code,
            'product_description' => $request->product_description,
            
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 
            'total_weight_in_qtl' => $request->total_weight_in_qtl,
        ]);

        $sql = "update order_details b1, ( SELECT inv.id, (inv.`selling_qty` * p.total_weight_in_qtl) total_qtl FROM `order_details` inv join products p on inv.product_id = p.id ) as b2 SET b1.`selling_qtl` = b2.total_qtl where b1.id = b2.id";

        DB::statement($sql);


        $notification = array(
            'message' => 'Product Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('product.all')->with($notification); 


    } // End Method 


    public function ProductDelete($id){
       
       Product::findOrFail($id)->delete();
            $notification = array(
            'message' => 'Product Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // End Method 

    public function changeStatus($id)
    {
        $product = Product::find($id);
        if ($product->status == 1) {
            $product->status = 0;
            $product->save();
            $message = "Inactive Successfully";
        } else {
            $product->status = 1;
            $product->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }

}
 
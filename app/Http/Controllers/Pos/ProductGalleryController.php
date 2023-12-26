<?php

namespace App\Http\Controllers\Pos;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductGalleryController extends Controller
{
    public function index($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $gallery = ProductGallery::where('product_id', $productId)->get();
            return view('backend.product.product_gallery', compact('gallery', 'product'));
        } else {
            return redirect()->route('product.all');
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'image' => 'required',
            'status' => 'required'
        ];
        $this->validate($request, $rules);

        $products = Product::find($request->product_id)->first();

        if ($products) {
            if ($request->image) {
                foreach ($request->image as $index => $images) {

                    $extention = $images->getClientOriginalExtension();
                    $image_name = 'product_gallery' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                    $image_path = 'upload/product-gallery/';
                    $images->move($image_path, $image_name);
                    $gallery = new ProductGallery();
                    $gallery->product_id = $request->product_id;
                    $gallery->image = $image_name;
                    $gallery->status = $request->status;
                    $gallery->save();
                }
                return redirect()->back()->with('success', 'Image Uploaded successfully.');
            }
        } else {
            return redirect()->back()->with('success', 'Something went wrong');
        }
    }

    
    public function destroy($id)
    {
        $gallery = ProductGallery::findorFail($id);
        $old_image = "upload/product-gallery/" . $gallery->image;
        if ($old_image) {
            if (File::exists(public_path() . '/' . $old_image)) unlink(public_path() . '/' . $old_image);
        }
        $gallery->delete();
        return redirect()->back()->with('success', 'Delete Successfully');
    }

    public function changeStatus($id)
    {
        $productgallery = ProductGallery::find($id);
        if ($productgallery->status == 1) {
            $productgallery->status = 0;
            $productgallery->save();
            $message = "Inactive Successfully";
        } else {
            $productgallery->status = 1;
            $productgallery->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
}

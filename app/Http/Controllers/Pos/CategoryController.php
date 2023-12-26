<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;


class CategoryController extends Controller
{
    public function CategoryAll()
    {

        $categoris = Category::latest()->get();
        return view('backend.category.category_all', compact('categoris'));
    } // End Mehtod 

    public function CategoryAdd()
    {
        return view('backend.category.category_add');
    } // End Mehtod 


    public function CategoryStore(Request $request)
    {

        $rules = [
            'name' => 'required|unique:categories',
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already exist'),

        ];

        $this->validate($request, $rules, $customMessages);
        Category::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    } // End Method 

    public function CategoryEdit($id)
    {

        $category = Category::findOrFail($id);
        return view('backend.category.category_edit', compact('category'));
    } // End Method 


    public function CategoryUpdate(Request $request)
    {

        $category_id = $request->id;

        $rules = [
            'name' => 'required|unique:categories,name,'.$category_id,
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already exist'),

        ];
        $this->validate($request, $rules, $customMessages);

        Category::findOrFail($category_id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    } // End Method 


    public function CategoryDelete($id)
    {

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        $message = "Updated Successfully";

        if ($category->status == 1) {
            $category->status = 0;
            $category->save();
            $message = "Inactive Successfully";
        } else {
            $category->status = 1;
            $category->save();
            $message = "Active Successfully";
        }

        return response()->json($message);
    }
}

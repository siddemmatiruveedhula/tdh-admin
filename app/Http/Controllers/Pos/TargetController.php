<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::latest()->get();

        return view('backend.target.index', compact('targets'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name', 'asc')->get();
        $categories = Category::all();
        // $products = Product::all();
        return view('backend.target.create', compact('employees', 'categories'));
    }
    public function getProducts($category_id)
    {
        $products = Product::active()->select('id', 'name')->where('category_id', $category_id)->get();
        return view('backend.target.product_category', compact('products'));
    }



    public function store(Request $request)
    {
        $rules = [
            'employee_id' => Rule::unique('targets')->where(function ($query) use ($request) {
                return $query->where('month', $request->month)->where('year', $request->year);
            }),
        ];
        $customMessages = [
            'employee_id.unique' => trans('Employees already taken in selected month and year'),
        ];
        $this->validate($request, $rules, $customMessages);

        $target  = new Target();
        $target->employee_id  =  $request->employee_id;
        $target->category_id   =  $request->category_id;
        $target->product_id   =  $request->product_id;
        $target->month   =  $request->month;
        $target->year   =  $request->year;
        $target->targets   =  $request->targets;
        $target->status  =  $request->status;
        $target->save();
        $notification = array(
            'message' => 'Target Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('target.index')->with($notification);
    }

    public function edit($id)
    {
        $target = Target::findOrFail($id);
        $employees = Employee::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        // $products = Product::orderBy('name', 'asc')->get();
        $products = Product::select('id', 'name')
            ->where('category_id', $target->product->category_id ?? '')
            ->active()
            ->get();

        return view('backend.target.edit', compact('target', 'employees', 'categories', 'products'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'employee_id' => Rule::unique('targets')->where(function ($query) use ($request) {
                return $query->where('month', $request->month)->where('year', $request->year);
            })->ignore($id),
        ];
        $customMessages = [
            'employee_id.unique' => trans('Employees already taken in selected month and year'),
        ];
        $this->validate($request, $rules, $customMessages);
        
        $target = Target::findOrFail($id);
        $target->employee_id  =  $request->employee_id;
        $target->category_id   =  $request->category_id;
        $target->product_id   =  $request->product_id;
        $target->month   =  $request->month;
        $target->year   =  $request->year;
        $target->targets   =  $request->targets;
        $target->status  =  $request->status;

        $target->save();

        $notification = array(
            'message' => 'Target Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('target.index')->with($notification);
    }

    public function changeStatus(Request $request, $id)
    {

        $target = Target::findOrFail($id);
        $message = "Updated Successfully";

        if ($target->status == 1) {
            $target->status = 0;
            $target->save();
            $message = "Inactive Successfully";
        } else {
            $target->status = 1;
            $target->save();
            $message = "Active Successfully";
        }

        return response()->json($message);
    }
}

<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function allCategories()
    {
        $categories = Category::latest()->get();
        return view('admin.backend.category.all_categories', compact('categories'));
    }

    public function deleteCategory($id)
    {
        Category::findorFail($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



    public function addCategory()
    {

        $category = Category::latest()->get();
        return view('admin.backend.category.category_add');
    }

    public function storeCategory(Request $request)
    {
        Category::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Category Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    }

    public
    function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.backend.category.category_edit', compact('category'));
    }

    public
    function updateCategory(Request $request)
    {

        Category::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('category.all')->with($notification);
    }


}

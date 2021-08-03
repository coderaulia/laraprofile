<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function AllCat(){
        $categories = Category::latest()->paginate(5);

        //using query builder
        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id', 'users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(5);
        // $categories = DB::table('categories')->latest()->paginate(5);

        return view('admin.category.index', compact('categories'));
    }

    public function AddCat(Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ], [
            'category_name.required' => 'Please input the category name!',
            'category_name.unique' => 'Please input the another category name!',
            'category_name.max' => 'Category name is too long! 255 character maximum value',
        ]);

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id, 
            'created_at' => Carbon::now()
        ]);

        // another way:
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id,
        // $category->save();

        // // using query builder:
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        // return with message
        return Redirect()->back()->with('success', 'Category inserted successfully!');


    }
}
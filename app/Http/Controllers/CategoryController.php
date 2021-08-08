<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Auth;

class CategoryController extends Controller
{

    public function __construct(){
        // creating page restriction
        $this->middleware('auth');
    }

    public function AllCat(){
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        //using query builder
        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id', 'users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(5);
        // $categories = DB::table('categories')->latest()->paginate(5);

        return view('admin.category.index', compact('categories', 'trashCat'));
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

    public function Edit($id){
        $categories =  Category::find($id);
        
        // using query builder
        // $categories = DB::table('categories')->where('id', $id)->first();
        
        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id){
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        //using query builder
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->where('id', $id)->update($data);
        
        return Redirect()->route('all.category')->with('success', 'Category updated successfully!');
        
    }
    
    public function SoftDelete($id){
        $delete = Category::find($id)->delete();
        
        return Redirect()->back()->with('success', 'Category (soft)deleted successfully!');
        
    }
    
    public function Restore($id){
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category restored successfully!');
    }
    
    public function PDelete($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Deleted successfully!');
    }

}
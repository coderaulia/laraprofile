<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function AllBrand(){
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function AddBrand(Request $request){
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
        ], [
            'brand_name.required' => 'Please input the brand name!',
            'brand_image.required' => 'Please add the brand image files!',
            'brand_name.unique' => 'Please input the another brand name!',
            'brand_name.min' => 'Brand name is too short! 4 character minimum value',
        ]);

        $brand_image = $request->file('brand_image');
        //generate unique id
        $name_gen = hexdec(uniqid());
        // get image extension
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        //generated image
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location, $img_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand inserted successfully!');
        
    }

    public function Edit($id){
        $brands = Brand::find($id);

        return view('admin.brand.edit', compact('brands'));
    }

    public function Update(Request $request, $id){
        $validatedData = $request->validate([
            'brand_name' => 'required|min:4',
        ], [
            'brand_name.required' => 'Please input the brand name!',
            'brand_name.min' => 'Brand name is too short! 4 character minimum value',
        ]);
        
        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');

        if($brand_image){
            //generate unique id
            $name_gen = hexdec(uniqid());
            // get image extension
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            //generated image
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location, $img_name);

            unlink($old_image);

            $brands = Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()

            ]);

            return Redirect()->back()->with('success', 'Brand updated successfully!');

        } else {
            
            $brands = Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()

            ]);

            return Redirect()->back()->with('success', 'Brand updated successfully!');
        }
        
        
    }
    
    public function Delete($id){

        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        $delete = Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand deleted successfully!');
    }


}
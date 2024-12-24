<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function AllProduct(){

        $products = Product::latest()->get();
        return view('backend.product.product_all',compact('products'));
    } // End Method

    public function AddProduct(){

        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        return view('backend.product.product_add',compact('categories','subcategory'));
    } // End Method

    public function StoreProduct(Request $request){

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('/upload/thambnail/'),$name_gen);
        $save_url = 'upload/thambnail/'.$name_gen;

         Product::insert([

            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'product_thambnail' => $save_url,
            'created_at' => Carbon::now(), 
        ]);
        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.product')->with($notification);
    } // End Method

    public function EditProduct($id){

        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_edit',compact('categories','products','subcategory',));
    } // End Method

    public function UpdateProduct(Request $request){

        $product_id = $request->id;

        Product::findOrfail($product_id)->update([
            
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'created_at' => Carbon::now(), 
        ]);

        $notification = array(
            'message' => 'Product Updated Without Image Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.product')->with($notification);
    } // End Method

    public function UpdateProductThambnail(Request $request){

        $pro_id = $request->id;
        $oldImage = $request->old_img;

        if ($request->file('product_thambnail')) {

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); 
        $image->move(public_path('upload/thambnail'), $name_gen);
        $save_url = 'upload/thambnail/'.$name_gen;
        
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Product::findOrFail($pro_id)->update([
            'product_thambnail' =>  $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product Image Thambnail Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.product')->with($notification);
        } 
    } // End Method

    public function ProductDelete($id){

        $product = Product::findOrFail($id);
        unlink($product->product_thambnail);

        Product::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    } // End Method

    public function AllTest(){
        $tests = Product::latest()->get();
        return view('backend.product.test_view',compact('tests'));
    }//


    public function productTest(){
        return view('backend.product.test_view');
    }

    public function fetchData(Request $request)
    {
        $search = $request->input('search');

        $sort = $request->input('sort');

        $products = Product::query();

        if (!empty($search)) {
            $products->where('id', $search);
        }

        $products->orderBy('created_at', $sort);

        return response()->json($products->get());
    }

}

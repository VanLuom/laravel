<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       


        $cates =Product::orderby('id','desc')->get();
        return view('admin.products.index')->with(compact('cates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $product = Product::create($request->only(['name', 'img', 'desc','price','category_id']));
        // $message = "Seccess full Created";
        // if($product == null){
        //     $message = "Seccess full failed";
        // }
        $data = $request->validate(
            [
                'name' => 'required|unique:categories|max:225',
                'desc' =>'required',
                'img'=>'required',
                'price'=>'required'
            ],
            [
                'name.required' => 'Nhập Tiêu đề',
                'name.unique' => 'Tiêu đề này đã tồn tại, Nhập tiêu đề khác',
                'desc.required' => 'Nhập mô tả',
                'img.required' => 'thêm ảnh',
                'price.required' =>'Nhập giá'


            ]
            );
            $cate = new Product;
            $cate ->name = $data['name'];
            $cate->desc = $data['desc'];
            $cate->img = $data['img'];
            $cate->price = $data['price'];
            $cate->save();

        return redirect()->route('admin.products.index')->with('status', 'Thêm danh mục thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product = Product::findOrFail($id);
        $bool = $product->update($request->only(['name', 'img', 'desc','category_id','price']));
        $message = "Seccess full Created";
        if(!$bool){
            $message = "Seccess full failed";

        }
        return redirect()->route('admin.products.index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $message = "Seccess full deleted";
        if (!Product::destroy($id)) {
            $message = "Seccess full failed";
        }

        return redirect()->route('admin.products.index')->with('message', $message);
    }
}

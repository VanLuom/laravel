<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoryList = Category::all();
        return view('admin.categories.index', ['categoryList' => $categoryList]);

        $cate =Category::orderby('id','desc')->get();
        return view('admin.categories.index')->with(compact('cates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
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
        // $category = Category::create($request->only(['name','desc','img']));
      
        
        $data = $request->validate(
            [
                'name' => 'required|unique:categories|max:225',
                'desc' =>'required',
                'img'=>'required'
            ],
            [
                'name.required' => 'Nhập Tiêu đề',
                'name.unique' => 'Tiêu đề này đã tồn tại, Nhập tiêu đề khác',
                'desc.required' => 'Nhập mô tả',
                'img.required' => 'thêm ảnh'


            ]
            );
            $cate = new Category;
            $cate ->name = $data['name'];
            $cate->desc = $data['desc'];
            $cate->img = $data['img'];
            $cate->save();

            return redirect()->route('admin.categories.index')->with('status', 'Thêm danh mục thành công');

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
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
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
        $category = Category::findOrFail($id);
        $bool = $category->update($request->only(['name','desc']));
        $message = "Seccess full Created";
        if(!$bool){
            $message = "Success full failed";

        }
        return redirect()->route('admin.categories.index')->with('message', $message);
       
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
        if (!Category::destroy($id)) {
            $message = "Seccess full failed";
        }
        Category::find($id)->deleted();
        return redirect()->route('categories.index')->with('status', 'Xóa danh mục thành công');

        return redirect()->route('admin.products.index')->with('message', $message);
    }
}
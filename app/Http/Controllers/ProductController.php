<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreFormRequest;
use App\Http\Requests\ProductUpdateFormRequest;
use Brian2694\Toastr\Facades\Toastr;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreFormRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
        ]);
        
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $fileName = 'products-'. rand() .'.' .$image->extension('image');
            $upload_path = 'uploads/products/';
            $img_url = $upload_path.$fileName;
            $image->move($upload_path, $fileName);
            $product->image = $img_url;
            $product->save();
        }

            $products = Product::all();
            $view = view('partials.all', compact('products'));
            $datas = $view->render();

            return response()->json(['status' => 'success', 'message' => 'Product Successfully Added', 'datas' => $datas]);
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
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateFormRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $fileName = 'products-'. rand() .'.' .$image->extension('image');
            $upload_path = 'uploads/products/';
            $img_url = $upload_path.$fileName;
            $image->move($upload_path, $fileName);
            $product->image = $img_url;
            $product->save();
        }

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
            if ($data->delete()) {
                $products = Product::all();
                $view = view('partials.all', compact('products'));
                $datas = $view->render();
                return response()->json(['status' => 'success', 'message' => 'Product Successfully Deleted', 'datas' => $datas]);
            }else{
                $output = ['status' => 'error', 'message' => 'Data cannot delete!'];
            }
        return response()->json($output);

    }
}

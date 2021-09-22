<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use File;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ProductGallery::all();

        return view('pages.product-galleries.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();

        return view('pages.product-galleries.create')->with([
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request)
    {
        $data = $request->all();
        $uploadedFile = $request->file('photo');

        if($uploadedFile != null) 
        {
            $fileName = time().'_'.$uploadedFile->getClientOriginalName();
            $filePath = public_path().'/images/products';

            $data['photo'] = url('/').$fileName;
            $uploadedFile->move($filePath,$fileName);
        }
        
        /*
        $data['photo'] = $request->file('photo')->store(
            'assets/product','public'
        );
        */ 

        ProductGallery::create($data);
        return redirect()->route('product-galleries.index');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ProductGallery::findOrFail($id);

        if($item != null) {
            try {
                $oldPhoto = $item->photo;
                $pathPhoto = 'images/products/';
                unlink($pathPhoto.$oldPhoto);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        $item->delete();

        return redirect()->route('product-galleries.index');
    }
}

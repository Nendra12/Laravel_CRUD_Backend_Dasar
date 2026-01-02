<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);

        return view('product.index', compact('products'));
    }

    public function create() 
    {
        return view('product.create');
    }

    public function store(Request $request)
    {   

        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $foto = $request->file('foto');
        $foto->storeAs('', $foto->hashName(), 'public');

        Product::create([
            'nama' => $request->nama,
            'harga' => str_replace(".", '',$request->harga),
            'deskripsi' => $request->deskripsi,
            'foto' => $foto->hashName()
        ]);

        return redirect()->route('product.index')->with('success', 'Product Was Added Succesfully');
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'image|mimes:png,jpg,jpeg'
        ]);

        $product->nama = $request->nama;
        $product->harga = str_replace(".", '',$request->harga);
        $product->deskripsi = $request->deskripsi;


        if($request->file('foto')) {
            if($product->foto !== 'noImage.png'){
                Storage::disk('public')->delete($product->foto);
            }

            $foto = $request->file('foto');
            $foto->storeAs('', $foto->hashName(), 'public');
            $product->foto = $foto->hashName();
        }

        $product->update();

        return redirect()->route('product.index')->with('success', 'Product Was Updated Succesfully');
    }

    public function destroy(Product $product) 
    {
        if($product->foto !== 'noImage.png'){
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product Was Deleted Succesfully');
    }
}

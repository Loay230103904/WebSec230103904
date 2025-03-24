<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::user() || (!Auth::user()->isAdmin() && !Auth::user()->isEmployee())) {
            abort(403, 'Unauthorized action.');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user() || (!Auth::user()->isAdmin() && !Auth::user()->isEmployee())) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }
        
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if (!Auth::user() || (!Auth::user()->isAdmin() && !Auth::user()->isEmployee())) {
            abort(403, 'Unauthorized action.');
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (!Auth::user() || (!Auth::user()->isAdmin() && !Auth::user()->isEmployee())) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->only(['name', 'description', 'price', 'stock', 'image']));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if (!Auth::user() || (!Auth::user()->isAdmin() && !Auth::user()->isEmployee())) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    public function purchase(Product $product)
    {
        $user = Auth::user();
    
        // ✅ Check if user has enough credit
        if ($user->credit < $product->price) {
            return redirect()->back()->with('error', 'Not enough credit to purchase this product.');
        }
    
        // ✅ Check if product is in stock
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'This product is out of stock.');
        }
    
        // ✅ Deduct price from user credit
        $user->credit -= $product->price;
        $user->save();
    
        // ✅ Reduce product stock
        $product->stock -= 1;
        $product->save();
    
        // ✅ Record the purchase in the `purchases` table
        $user->purchases()->create([
            'product_id' => $product->id,
            'amount' => $product->price,
        ]);
    
        return redirect()->route('users.profile')->with('success', 'Product purchased successfully!');
    }
    

 
}

<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use session;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */

    public function index()
    {
        // $products = Product::orderby('id', 'desc')->paginate(5);
        // return view('product.index', compact('products'));


        
            $products = Product::all();
           
            return view('product.index', compact('products'));
        
    }

    public function cart()
    {
        return view('product.cart');
    }

    // public function addToCart($id)
    // {
    //     $product = Product::findOrFail($id);
          
    //     $cart = session()->get('cart', []);
  
    //     if(isset($cart[$id])) {
    //         $cart[$id]['quantity']++;
    //     } else {
    //         $cart[$id] = [
    //             "name" => $product->name,
    //             "quantity" => 1,
    //             "price" => $product->price,
    //             "image" => $product->image
    //         ];
    //     }
          
    //     session()->put('cart', $cart);
    //     return redirect()->back()->with('success', 'Product added to cart successfully!');
    // }

    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
        $this->validate($request, [
            'name'           => 'required|string|max:255',
            'description'          => 'required|string|max:255',
            'price'              => 'required|string|max:255',
            'rating'        => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1999'
        ]);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/image', $fileNameToStore);
            }
            // Else add a dummy image
            else {
            $fileNameToStore = 'noimage.jpg';
            }
             //create product
             $product = new Product;
             $product->user_id = Auth::User()->id;
             $product ->description =$request->input('description');
             $product ->name =$request->input('name');
             $product ->price =$request->input('price');
             $product ->rating =$request->input('rating');
             $product ->image =$fileNameToStore;
            
             $product->save();
             
            return redirect()->route('products.index')->with('flash_message', 'Products,'. $product->name.' created');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product= Product::findOrFail($id);

        return view ('product.show', compact('product'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product.edit', compact('product'));
        return redirect()->route('products.index')->with('flash_message', 'Products,'. 
        $product->name.' Edited');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        {
            $this->validate($request, [
                'name'           => 'required|string|max:255',
                'description'          => 'required|string|max:255'
                // 'price'              => 'required|string|max:255',
                // 'rating'        => 'required|numeric',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1999'
            ]);
    
            if ($request->hasFile('image')) {
                $filenameWithExt = $request->file('image')->getClientOriginalName ();
                // Get Filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just Extension
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename To store
                $fileNameToStore = $filename. '_'. time().'.'.$extension;
                // Upload Image
                $path = $request->file('image')->storeAs('public/image', $fileNameToStore);
                }
                // Else add a dummy image
                else {
                $fileNameToStore = 'noimage.jpg';
                }
                 //create product
                 $product = Product::findOrFail($id);

                 $product->user_id = Auth::User()->id;
                 $product ->description =$request->input('description');
                 $product ->name =$request->input('name');
                //  $product ->price =$request->input('price');
                //  $product ->rating =$request->input('rating');
                //  $product ->image =$fileNameToStore;
                
                 $product->save();
                 
                return redirect()->route('products.index')
                ->with('flash_message', 'Products,'. $product->name.' updated');
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('flash_message',
             'Product successfully deleted');
    }

    public function addToCart(Request $req)
    {
        if($req->session()->has('user'))
        {
           $cart= new Cart;
           $cart->user_id=$req->session()->get('user')['id'];
           $cart->product_id=$req->product_id;
           return $cart;
           $cart->save();

           return 'hell';
           return redirect('/products');

        }
        else
        {
            return redirect('/login');
        }
    }
}

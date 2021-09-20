
@extends('layouts.app')
@section('content')


@section('content')
    <h1>Products</h1>
    @if(count($products) > 0)
        @foreach($products as $product)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:100%" src="/storage/image/{{$product->image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3>{{$product->name}}</a></h3>
                       <b><h2> {{$product->price}}</b><span>$</span></h2>
                    </div>
                    <h4>{{$product->description}}</h4>
                </div>
                <br><br>
       <form action="/add_to_cart" method="POST">
       <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

           <input type="hidden" name="product_id" value={{$product['id']}}>
       <button class="btn btn-primary">Add to Cart</button>
       </form>
       <br><br>
       <button class="btn btn-success">Buy Now</button>
       <br><br>
            </div>
        @endforeach
       
    @else
        <p>No products found</p>
    @endif
@endsection


@endsection
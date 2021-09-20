@extends('layouts.app')

@section('title', '| Create New Post')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

        <h1>Create Product</h1>
        <hr>
        {{-- @include ('errors.list') --}}

        {{-- Using the Laravel HTML Form Collective to create our form --}}
        {{ Form::open(array('route' => 'products.store','enctype'=>'multipart/form-data')) }} 
       

        <div class="form-group">
            {{ Form::label('name', 'Product Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
            <br>
            {{ Form::label('description', 'Product description') }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
            <br>
            {{ Form::label('price', 'Product Price') }}
            {{ Form::text('price', null, array('class' => 'form-control')) }}
            <br>
            {{Form::label('rating', 'Rating', ['class' => 'awesome'])}}
            {{Form::selectRange('rating', 1, 5,['class'=>'form-control', 'placeholder'=>'rating'])}}
 
            <br>
            {{Form::file('image')}}
           

            {{ Form::submit('Create Post', array('class' => 'btn btn-success')) }}
            {{ Form::close() }}
        </div>
        </div>
    </div>

@endsection
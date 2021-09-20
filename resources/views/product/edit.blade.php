@extends('layouts.app')

@section('title', '| Edit Post')

@section('content')
<div class="row">

    <div class="col-md-8 col-md-offset-2">
    
        <h1>Edit Product</h1>
        <hr>
        @include ('errors.list')
            {{ Form::model($product, array('route' => array('products.update', $product->id), 'method' => 'PUT')) }}
            <div class="form-group">
            {{ Form::label('name', 'Product Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}<br>

            {{ Form::label('description', 'Product Description') }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}<br>

            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
    </div>
    </div>
</div>

@endsection
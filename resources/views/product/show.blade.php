@extends('layouts.app')

@section('title', '| View Post')

@section('content')

<div class="container">
    
    <h1>{{ $product->name }}</h1>
    <hr>
    <p class="lead">{{ $product->description }} </p>
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['products.destroy', $product->id] ]) !!}
    <a href="/products" class="btn btn-primary">Back</a>
    @can('Edit Post')
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info" role="button">Edit</a>
    @endcan
    @can('Delete Post')
    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    @endcan
    {!! Form::close() !!}

</div>

@endsection
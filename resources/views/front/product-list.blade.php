@extends('layouts.app')

@section('content')
    <product-list v-bind:categories="{{ $categories }}" v-bind:cart="{{ $cart }}"></product-list>
@endsection

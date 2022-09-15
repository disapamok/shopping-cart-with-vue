@extends('layouts.dashboard')

@section('content')
    <admin-products v-bind:categories="{{ $categories }}" v-bind:products="{{ $product }}"></admin-products>
@endsection

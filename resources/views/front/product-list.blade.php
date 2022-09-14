@extends('layouts.app')

@section('content')
    <product-list v-bind:categories="{{ $categories }}"></product-list>
@endsection

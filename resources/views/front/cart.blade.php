@extends('layouts.app')

@section('content')
    <cart-view v-bind:cart="{{ $cart }}"></cart-view>
@endsection

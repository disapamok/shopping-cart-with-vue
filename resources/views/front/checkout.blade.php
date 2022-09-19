@extends('layouts.app')

@section('content')
    <checkout v-bind:cart="{{ $cart }}"></checkout>
@endsection

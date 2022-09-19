@extends('layouts.app')

@section('content')
    <order-history v-bind:orders="{{ $orders }}"></order-history>
@endsection

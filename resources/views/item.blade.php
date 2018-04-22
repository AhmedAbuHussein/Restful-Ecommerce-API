@extends('layouts.app')

@section('content')

<div class="container">

    <item productid="{{$id}}" username="{{isset(Auth::user()->name)?Auth::user()->name:null}}" class="mb-4"></item>
    

</div>

@endsection
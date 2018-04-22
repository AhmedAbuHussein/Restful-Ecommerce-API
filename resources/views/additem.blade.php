@extends('layouts.app')

@section('content')

<div class="container">
    <add-item :user="{{Auth::user()}}"></add-item>
</div>

@endsection
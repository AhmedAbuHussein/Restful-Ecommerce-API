@extends('layouts.app')
@section('style')

<style>

    .header{
        width: 100%;
        border: 1px solid black;
        margin-top: -1rem;
        background: url('/images/header.jpg') no-repeat center center;
        background-size: cover;
    }

</style>

@endsection
@section('content')

<div class="header">
    
</div>

<div class="container">

</div>

@endsection

@section('script')
<script src="/js/jquery.js"></script>
<script>

    $('.header').height($(window).height()-90);

</script>

@endsection
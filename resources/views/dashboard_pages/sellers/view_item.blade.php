
@extends('layouts.dashboard')
@section('active-dresses','active')

@section('body')



<div class="wrapper" style="margin: 40px 0px 0px 0px">

    <img src="{{ $item->image1 }}" alt="">
    <img src="{{ $item->image2 }}" alt="">
    <img src="{{ $item->image3 }}" alt="">
    <p>{{ $item->description }}</p>
    

</div>


@section('js-page','/js/pages/dashboard/users.js')

@endsection
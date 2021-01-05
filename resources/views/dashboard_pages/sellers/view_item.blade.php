
@extends('layouts.dashboard')
@section('active-dresses','active')

@section('body')



<div class="seller-view" >
    <div class="images">
        <img src="{{ $item->image1 }}" alt="">
        <img src="{{ $item->image2 }}" alt="">
        <img src="{{ $item->image3 }}" alt="">

    </div>

    <div class="checks">
        @if ($item->X)
        <i class="fa fa-check"></i><span>X</span>
        @endif
        @if ($item->L)
        <i class="fa fa-check"></i><span>L</span>
        @endif
        @if ($item->XL)
        <i class="fa fa-check"></i><span>XL</span>
        @endif
    </div>
    
    <div class="desc">
        <p>{{ $item->description }}</p>
    </div>
    

</div>


@section('js-page','/js/pages/dashboard/users.js')

@endsection
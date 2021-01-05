
@extends('layouts.dashboard')
@section('active-dresses','active')

@section('body')

<style>
   
body {
  background: #24282f;
  font-family: 'Alegreya Sans';
}

.wrapper {
  padding: 15px;
}

</style>


<div class="wrapper" style="margin: 40px 0px 0px 0px">
  <div class="bar">
    <a href="/dashboard/seller/add-dersses"  class="btn-base btn1"><i class="fa fa-plus"></i> جديد </a>
    <a href="/dashboard/seller/activeated_items" class="btn-base btn1" ><i class="fa fa-eye"></i> المنتجات النشطه </a>
    <a href="/dashboard/seller/dactiveated_items" class="btn-base btn1" ><i class="fa fa-eye-slash"></i> المنتجات الخامله </a>

  </div>
    
	{{-- <h2><strong>All Games<span>( 4 )</span></strong></h2> --}}
    
	<div class="">
    <div class="grid grid-pad porducer-me">
      <!--Start box-one-->
     
       


            @foreach ($items as $item)

            <!-- Edit here -->
            <div class="col-1-3">
              <div class="box">
                  <div class='img-me'>
                      <a href="/dashboard/seller/view_item/{{ $item->id }}"><img src="{{ $item->image1 }}" style=""></a>
                      {{-- <button type="button" class="far fa-heart heart"></button> --}}
                      <div class="toole-me">
                          <a href="/dashboard/seller/delete_item/{{ $item->id }}" type="button" class="fas fa-trash-alt trash" title="حذف المنتج"></a>
                          <a href="/dashboard/seller/active_item/{{ $item->id }}" type="button" class="fas fa-eye eye" title="تنشيط المنتج"></a>
                          <a href="/dashboard/seller/dactive_item/{{ $item->id }}" type="button" class="fas fa-eye-slash trash" title="الغاء تنشيط المنتج"></a>
                      </div>
                  </div>
                  
              </div>
            </div>

          <!-- /Edit here -->
          @endforeach
          

	</div>


</div>


@section('js-page','/js/pages/dashboard/users.js')

@endsection
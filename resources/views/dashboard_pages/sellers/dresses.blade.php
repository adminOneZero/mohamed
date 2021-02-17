
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
    <a href="/dashboard/seller/almost_done_items" class="btn-base btn1" ><i class="fa fa-thermometer-quarter"></i>  اوشكت</a>
    <a href="/dashboard/seller/done_items" class="btn-base btn1" ><i class="fa fa-thermometer-empty"></i>  منتهيه</a>

  </div>
    
    
	<div class="">
    <div class="grid grid-pad porducer-me">
      <!--Start box-one-->
     
       


            @foreach ($items as $item)

            <!-- Edit here -->
            <div class="col-1-3">
              <div class="box">
                  <div class='img-me'>
                      <a href="/dashboard/seller/view_item/{{ $item->id }}"><img src="{{ $item->image1 }}" style=""></a>
                      <div class="toole-me">
                          <a href="/dashboard/seller/delete_item/{{ $item->id }}" type="button" class="fas fa-trash-alt trash" title="حذف المنتج"></a>
                          <a href="/dashboard/seller/active_item/{{ $item->id }}" type="button" class="fas fa-eye eye" title="تنشيط المنتج"></a>
                          <a href="/dashboard/seller/dactive_item/{{ $item->id }}" type="button" class="fas fa-eye-slash trash" title="الغاء تنشيط المنتج"></a>
                          <a data-id="{{ $item->id }}" type="button" class="fas fa-sliders-h eye itemOptions" title="تعديل الكميه"></a>
                      </div>
                  </div>
                  
              </div>
            </div>

          <!-- /Edit here -->
          @endforeach
          

	</div>


    <div id="modal">
      <p> الكميه الحاليه : <input type="text" name="" disabled id="currentQuanInput"></p>
      <p> اضافه كميه : <input type="text" name="increaseQuan" > <a id="increaseQuan" href="#" class="fa fa-sync btn btn-success color-white link-btn"> </a>  </p>
      <p> سحب كميه : <input type="text" name="decreaseQuan" > <a id="decreaseQuan" href="#" class="fa fa-sync btn btn-success color-white link-btn"> </a>  </p>
      <input type="hidden" name="" id="optionsId">
    </div>

</div>


@section('js-page','/js/pages/dashboard/newDresses.js')

@endsection